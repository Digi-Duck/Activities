<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityDetail;
use App\Models\StudentActivity;
use App\Models\User;
use App\Models\UserBehavior;
use App\Models\UserRoleStudent;
use App\Presenters\ActivityPresenter;

class DashboardController extends Controller
{
    public function __construct(
        protected ActivityPresenter $activityPresenter,
    ) {
    }
    public function index(Request $request)
    {
        // dd($request->all());
        // 活動列表資料
        $activity = ActivityDetail::orderBy('id', 'desc')
            ->where('activity_status', 1)
            ->with(['activityPhotos:id,activity_id,activity_img_path', 'studentActivities'])
            ->paginate(5)
            ->through(function ($item) {
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

        $newBehaviors = UserBehavior::orderBy('id', 'desc')
            ->take(5)
            ->get();

        $keyword = $request->keyword ?? '';

        $behaviorRecord = UserBehavior::where('user_name', 'like', "%$keyword%")
            ->orwhere('user_type', 'like', "%$keyword%")
            ->orwhere('behavior', 'like', "%$keyword%")
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->through(function ($item) {
                return [
                    'id' => $item->id,
                    'user_type' => $item->user_type,
                    'user_name' => $item->user_name,
                    'behavior' => $item->behavior,
                    'created_at' => $item->created_at->format('Y/m/d H:i'),
                ];
            });

        $data = (object) [
            'activity' => $activity,
            'newBehaviors' => $newBehaviors,
            'behaviorRecord' => $behaviorRecord,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
            'keyword' => $keyword,
        ];


        return Inertia::render('Backend/Dashboard', ['response' => rtFormat($data)]);
    }
    public function studentManage(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $status = $request->input('status', ''); // 获取状态筛选条件

        $student = User::where('user_role', 3)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('created_at', 'like', "%$keyword%");
            });

        // 如果提供了状态筛选条件，则添加状态筛选
        if ($status !== '') {
            $student->where('status', $status);
        }

        $student = $student->orderBy('created_at', 'desc')
            ->paginate(5)
            ->through(function ($item) {
                $statusText = $item->status == 1 ? '正常' : '停權';
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'user_role' => $item->user_role,
                    'email' => $item->email,
                    'status' => $statusText,
                    'created_at' => $item->created_at->format('Y/m/d H:i'),
                ];
            });

        $data = (object) [
            'keyword' => $keyword,
            'student' => $student,
        ];

        return Inertia::render('Backend/StudentManage', ['response' => rtFormat($data)]);
    }

    public function presenterManage(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $status = $request->input('status', ''); // 获取状态筛选条件

        $presenter = User::where('user_role', 2)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('created_at', 'like', "%$keyword%");
            });

        // 如果提供了状态筛选条件，则添加状态筛选
        if ($status !== '') {
            $presenter->where('status', $status);
        }

        $presenter = $presenter->orderBy('created_at', 'desc')
            ->paginate(5)
            ->through(function ($item) {
                $statusText = $item->status == 1 ? '正常' : '停權';
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'user_role' => $item->user_role,
                    'email' => $item->email,
                    'status' => $statusText,
                    'created_at' => $item->created_at->format('Y/m/d H:i'),
                ];
            });

        $data = (object) [
            'keyword' => $keyword,
            'presenter' => $presenter,
        ];

        return Inertia::render('Backend/PresenterManage', ['response' => rtFormat($data)]);
    }

    public function activityManage(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $status = $request->input('status', '');

        $activity = ActivityDetail::where(function ($query) use($keyword) {
            $query->where('activity_presenter', 'like', "%$keyword%")
                ->orwhere('activity_name', 'like', "%$keyword%")
                ->orwhere('activity_start_time', 'like', "%$keyword%")
                ->orwhere('activity_end_time', 'like', "%$keyword%")
                ->orwhere('activity_type', 'like', "%$keyword%")
                ->orwhere('activity_address', 'like', "%$keyword%");
        });

        // 如果提供了状态筛选条件，则添加状态筛选
        if ($status !== '') {
            $activity->where('activity_status', $status);
        }

        $activity = $activity->orderBy('created_at', 'desc')
            ->paginate(5)
            ->through(function ($item) {
                $statusText = $item->activity_status == 1 ? '正常' : '停權';
                return [
                    'id' => $item->id,
                    'activity_presenter' => $item->activity_presenter,
                    'activity_name' => $item->activity_name,
                    'activity_type' => $item->activity_type,
                    'activity_address' => $item->activity_address,
                    'activity_start_time' => $item->activity_start_time->format('Y/m/d H:i'),
                    'activity_end_time' => $item->activity_end_time->format('Y/m/d H:i'),
                    'activity_status' => $statusText,
                ];
            });

        $data = (object) [
            'keyword' => $keyword,
            'activity' => $activity,
        ];

        return Inertia::render('Backend/ActivityManage', ['response' => rtFormat($data)]);
    }
}
