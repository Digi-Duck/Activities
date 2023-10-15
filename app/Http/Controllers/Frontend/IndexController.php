<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\ActivityPhoto;
use App\Models\ActivityDetail;
use App\Http\Controllers\Controller;
use App\Models\RegisterActivity;
use App\Models\Statistic;
use App\Models\StudentActivity;
use App\Models\UserRolePresenter;
use App\Models\UserRoleStudent;
use App\Presenters\ActivityPresenter;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use App\Services\FilesService;

class IndexController extends Controller
{
    public function __construct(
        protected FilesService $filesService,
        protected ActivityPresenter $activityPresenter,
    ) {
    }

    /**
     * 前台首頁
     */
    public function index(Request $request)
    {
        Statistic::create(['website_view' => 1]);
        // 活動列表資料
        $activity = ActivityDetail::orderBy('id', 'desc')
            ->where('activity_status', 1)
            ->with(['activityPhotos:id,activity_id,activity_img_path', 'studentActivities'])
            ->get()
            ->map(function ($item) {
                $coverPhoto = $item->activityPhotos->first();
                $collectionCount = $item->studentActivities->where('activity_type', 1)->count();
                $registrationCount = $item->studentActivities->where('activity_type', 2)->count();

                return [
                    'id' => $item->id,
                    'activity_name' => $item->activity_name,
                    'activity_info' => $item->activity_info,
                    'activity_presenter' => $item->activity_presenter,
                    'activity_type' => $item->activity_type,
                    'activity_type_name' => $this->activityPresenter->getActivityTypeName($item->activity_type),
                    'activity_lowest_number_of_people' => $item->activity_lowest_number_of_people,
                    'activity_highest_number_of_people' => $item->activity_highest_number_of_people,
                    'activity_end_registration_time' => date('Y-m-d H:i', strtotime($item->activity_end_registration_time)),
                    'activity_start_time' => date('Y-m-d H:i', strtotime($item->activity_start_time)),
                    'activity_address' => $item->activity_address,
                    'cover_photo' => $coverPhoto->activity_img_path ?? '',
                    'collection_count' => $collectionCount,
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

    /**
     * 會員中心
     */
    public function userInfo(Request $request)
    {
        $userData = User::find($request->user()->id);
        $userRole = $userData->user_role;

        $imgPath = null;

        if ($userRole == 2) {
            $presenterImage = UserRolePresenter::where('user_id', $userData->id)->first();
            if ($presenterImage) {
                $imgPath = $presenterImage->img_path;
                $phoneNumber = $presenterImage->phone_number;
            }
        } elseif ($userRole == 3) {
            $studentImage = UserRoleStudent::where('user_id', $userData->id)->first();
            if ($studentImage) {
                $imgPath = $studentImage->img_path;
                $phoneNumber = $studentImage->phone_number;
            }
        }

        $data = (object)[
            'userData' => $userData,
            'imgPath' => $imgPath,
            'phoneNumber' => $phoneNumber,
        ];

        return Inertia::render('Auth/UserInfo', ['response' => rtFormat($data)]);
    }
    public function changeUserInfo(Request $request)
    {
        $userData = User::find($request->user()->id);
        $userRole = $userData->user_role;

        $imgPath = null;

        if ($userRole == 2) {
            $presenterImage = UserRolePresenter::where('user_id', $userData->id)->first();
            if ($presenterImage) {
                $imgPath = $presenterImage->img_path;
                $phoneNumber = $presenterImage->phone_number;
            }
        } elseif ($userRole == 3) {
            $studentImage = UserRoleStudent::where('user_id', $userData->id)->first();
            if ($studentImage) {
                $imgPath = $studentImage->img_path;
                $phoneNumber = $studentImage->phone_number;
            }
        }

        $data = (object)[
            'userData' => $userData,
            'imgPath' => $imgPath,
            'phoneNumber' => $phoneNumber,
        ];
        return Inertia::render('Auth/ChangeUserInfo', ['response' => rtFormat($data)]);
    }
    public function userInfoUpdate(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required',
            'phoneNumber' => 'required',
            'id' => 'required|exists:users,id',
            'image' => 'required',
        ]);

        $userData = User::find($request->id);

        if ($request->user_role === 2) {
            UserRolePresenter::where('user_id', $request->id)->update([
                'phone_number' => $validated['phoneNumber'],
                'img_path' => $this->filesService->base64Upload($validated['image'], 'otherProduct'),
            ]);
        } elseif ($request->user_role === 3) {
            UserRoleStudent::where('user_id', $request->id)->update([
                'phone_number' => $validated['phoneNumber'],
                'img_path' => $this->filesService->base64Upload($validated['image'], 'otherProduct'),
            ]);
        }
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $data = (object) [
            'userData' => $userData,
        ];

        return back()->with(['message' => rtFormat($data)]);
    }
    /**
     * 活動分類
     */
    public function activityClassification(Request $request)
    {
        // dd($request->all());
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
                $coverPhoto = $item->activityPhotos->first();
                $collectionCount = $item->studentActivities->where('activity_type', 1)->count();
                $registrationCount = $item->studentActivities->where('activity_type', 2)->count();

                return [
                    'id' => $item->id,
                    'activity_name' => $item->activity_name,
                    'activity_info' => $item->activity_info,
                    'activity_presenter' => $item->activity_presenter,
                    'activity_type' => $item->activity_type,
                    'activity_type_name' => $this->activityPresenter->getActivityTypeName($item->activity_type),
                    'activity_lowest_number_of_people' => $item->activity_lowest_number_of_people,
                    'activity_highest_number_of_people' => $item->activity_highest_number_of_people,
                    'activity_end_registration_time' => date('Y-m-d H:i', strtotime($item->activity_end_registration_time)),
                    'activity_start_time' => date('Y-m-d H:i', strtotime($item->activity_start_time)),
                    'activity_address' => $item->activity_address,
                    'cover_photo' => $coverPhoto->activity_img_path ?? '',
                    'collection_count' => $collectionCount,
                    'registration_count' => $registrationCount,
                ];
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

    /**
     * 相關聲明
     */
    public function declaration()
    {
        return Inertia::render('Frontend/Declaration');
    }

    public function test()
    {
        return Inertia::render('Frontend/Test');
    }
}
