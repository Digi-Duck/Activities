<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\ActivityPhoto;
use App\Models\ActivityDetail;
use App\Http\Controllers\Controller;
use App\Models\RegisterActivity;
use App\Models\StudentActivity;
use App\Models\UserRolePresenter;
use App\Models\UserRoleStudent;
use App\Presenters\ActivityPresenter;
use Illuminate\Foundation\Auth\User;

class IndexController extends Controller
{
    // 注入 ActivityPresenter
    public function __construct(
        protected ActivityPresenter $activityPresenter,
    ) {
    }

    /**
     * 前往前台首頁
     */
    public function index(Request $request)
    {
        // 活動列表資料
        $activity = ActivityDetail::orderBy('id', 'desc')
            ->where('activity_status', 1)
            ->with(['activityPhotos:id,activity_id,activity_img_path', 'studentActivities'])
            ->get()
            ->map(function ($item) {
                // 找出第一張圖片
                $coverPhoto = $item->activityPhotos->first();
                // 找出已收藏的人數
                $collectionCount = $item->studentActivities->where('activity_type', 1)->count();
                // 找出已報名的人數
                $registrationCount = $item->studentActivities->where('activity_type', 2)->count();

                return [
                    'id' => $item->id,
                    // 活動名稱
                    'activity_name' => $item->activity_name,
                    // 活動Slogan
                    'activity_info' => $item->activity_info,
                    // 活動講者
                    'activity_presenter' => $item->activity_presenter,
                    // 活動類型代號
                    'activity_type' => $item->activity_type,
                    // 活動類型名稱
                    'activity_type_name' => $this->activityPresenter->getActivityTypeName($item->activity_type),
                    // 活動人數下限
                    'activity_lowest_number_of_people' => $item->activity_lowest_number_of_people,
                    // 活動人數上限
                    'activity_highest_number_of_people' => $item->activity_highest_number_of_people,
                    // 活動報名截止時間
                    'activity_end_registration_time' => date('Y-m-d H:i', strtotime($item->activity_end_registration_time)),
                    // 活動開始時間
                    'activity_start_time' => date('Y-m-d H:i', strtotime($item->activity_start_time)),
                    // 活動地點
                    'activity_address' => $item->activity_address,
                    // 活動封面圖片
                    'cover_photo' => $coverPhoto->activity_img_path ?? '',
                    // 活動收藏人數
                    'collection_count' => $collectionCount,
                    // 活動報名人數
                    'registration_count' => $registrationCount,
                ];
            });

        $keyword = $request->keyword ?? '';
        $type = $request->type ?? '';
        $activityTable = ActivityDetail::where('activity_status', 1)
            ->where(function ($query) use ($keyword) {
                $query->where('activity_name', 'like', "%$keyword%")
                    ->orwhere('activity_presenter', 'like', "%$keyword%")
                    ->orwhere('activity_end_registration_time', 'like', "%$keyword%")
                    ->orwhere('activity_lowest_number_of_people', 'like', "%$keyword%")
                    ->orwhere('activity_highest_number_of_people', 'like', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->with(['activityPhotos:id,activity_id,activity_img_path', 'studentActivities'])
            ->paginate(5)
            ->through(function ($item) {
                $registrationCount = $item->studentActivities->where('activity_type', 2)->count();

                return [
                    'id' => $item->id,
                    'activity_name' => $item->activity_name,
                    'activity_presenter' => $item->activity_presenter,
                    'activity_type' => $item->activity_type,
                    'activity_type_name' => $this->activityPresenter->getActivityTypeName($item->activity_type),
                    'activity_lowest_number_of_people' => $item->activity_lowest_number_of_people,
                    'activity_highest_number_of_people' => $item->activity_highest_number_of_people,
                    'activity_end_registration_time' => date('Y-m-d H:i', strtotime($item->activity_end_registration_time)),
                    'registration_count' => $registrationCount,
                ];
            });

        $sortedActivity = $activity->sortByDesc('collection_count');
        $hottestActivity = $sortedActivity->first();

        $data = (object) [
            'activity' => $activity,
            'activityTable' => $activityTable,
            'hottestActivity' => $hottestActivity,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];

        return Inertia::render('Frontend/Index', ['response' => rtFormat($data)]);
    }

    public function userInfo(Request $request)
    {
        $userData = User::find($request->user()->id);
        $userRole = $userData->user_role;

        $imgPath = null;

        if ($userRole == 2) {
            $presenterImage = UserRolePresenter::where('user_id', $userData->id)->first();
            if ($presenterImage) {
                $imgPath = $presenterImage->img_path;
            }
        } elseif ($userRole == 3) {
            $studentImage = UserRoleStudent::where('user_id', $userData->id)->first();
            if ($studentImage) {
                $imgPath = $studentImage->img_path;
            }
        }

        $data = (object)[
            'userData' => $userData,
            'imgPath' => $imgPath, // 添加图像路径到数据对象
        ];

        return Inertia::render('Auth/UserInfo', ['response' => rtFormat($data)]);
    }


    public function declaration()
    {
        return Inertia::render('Frontend/Declaration');
    }

    public function activityClassification(Request $request)
    {
        $keyword = $request->keyword ?? '';
        $type = $request->type ?? '';
        $activity = ActivityDetail::where(function ($query) use ($keyword) {
            $query->where('activity_name', 'like', "%$keyword%")
                ->orwhere('activity_end_registration_time', 'like', "%$keyword%")
                ->orwhere('activity_info', 'like', "%$keyword%");
        })
            ->where(function ($query) use ($type) {
                if (!empty($type)) {
                    $query->where('activity_type', 'like', "%$type%");
                }
            })
            ->where('activity_status', 1)
            ->orderBy('id', 'desc')
            ->with('activityPhotos:id,activity_id,activity_img_path')
            ->get()
            ->map(function ($item) {
                $item->activity_end_registration_time = $item->activity_end_registration_time->format('Y-m-d H:i');
                return $item;
            });
        $firstHotActivity = RegisterActivity::join('activity_details', 'register_activities.activity_id', '=', 'activity_details.id')
            ->select('activity_details.activity_type', RegisterActivity::raw('COUNT(*) as type_count'))
            ->groupBy('activity_details.activity_type')
            ->orderByDesc('type_count')
            ->limit(3)
            ->get()
            ->map(function ($item) {
                return [
                    'activity_type' => $item->activity_type,
                    'activity_type_name' => $this->activityPresenter->getActivityTypeName($item->activity_type)
                ];
            });
        $acitvityPhoto = ActivityPhoto::orderBy('id', 'desc')
            ->first();
        $title = $this->activityPresenter->getActivityTypeName($request->type);

        $data = (object)[
            'activity' => $activity,
            'title' => $title,
            'type' => $type,
            'acitvityPhoto' => $acitvityPhoto,
            'firstHotActivity' => $firstHotActivity,
            'keyword' => $keyword,
        ];
        return Inertia::render('Frontend/ActivityClassification', ['response' => rtFormat($data)]);
    }

    public function test()
    {
        return Inertia::render('Frontend/Test');
    }
}
