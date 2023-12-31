<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityDetail;
use App\Models\ActivityPhoto;
use App\Models\QrcodeDetail;
use App\Models\RegisterActivity;
use App\Models\StudentActivity;
use App\Models\UserBehavior;
use App\Models\UserRoleStudent;
use Inertia\Inertia;
use App\Presenters\ActivityPresenter;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;

class StudentController extends Controller
{
    public function __construct(
        protected ActivityPresenter $activityPresenter,
    ) {
    }

    /**
     * 各活動詳細
     */
    public function index($id, Request $request)
    {
        $activity = ActivityDetail::find($id);

        if (!$activity) {
            return abort(404);
        }
        $currentTimestamp = time();
        $activityStartTime = strtotime($activity->activity_start_time);
        $timeDifferenceInSeconds = $activityStartTime - $currentTimestamp;
        $timeDifferenceInDays = intval($timeDifferenceInSeconds / (3600 * 24));

        $activityPhotos = $activity->activityPhotos;

        $result = [
            'id' => $activity->id,
            'activity_name' => $activity->activity_name,
            'activity_info' => $activity->activity_info,
            'activity_presenter' => $activity->activity_presenter,
            'activity_type' => $activity->activity_type,
            'activity_type_name' => $this->activityPresenter->getActivityTypeName($activity->activity_type),
            'activity_lowest_number_of_people' => $activity->activity_lowest_number_of_people,
            'activity_highest_number_of_people' => $activity->activity_highest_number_of_people,
            'activity_start_registration_time' => date('Y-m-d H:i', strtotime($activity->activity_start_registration_time)),
            'activity_end_registration_time' => date('Y-m-d H:i', strtotime($activity->activity_end_registration_time)),
            'activity_start_time' => date('Y-m-d H:i', strtotime($activity->activity_start_time)),
            'activity_end_time' => date('Y-m-d H:i', strtotime($activity->activity_end_time)),
            'activity_address' => $activity->activity_address,
            'activity_instruction' => $activity->activity_instruction,
            'activity_information' => $activity->activity_information,
            'activityPhotos' => $activityPhotos->pluck('activity_img_path')->toArray(),
        ];

        $registerPeople = ActivityDetail::whereHas('registerActivities', function ($query) use ($id) {
            return $query->where('activity_id', $id);
        })->count();

        $user = $request->user();

        if ($user && isset($user->userRoleStudent)) {
            $studentId = $user->userRoleStudent->id;

            $favoriteCheck = StudentActivity::where('activity_id', $id)
                ->where('student_id', $studentId)
                ->first();
        } else {
            $favoriteCheck = null;
        }

        $data = (object) [
            'activity' => $result,
            'registerPeople' => $registerPeople,
            'user' => $user,
            'favoriteCheck' => $favoriteCheck ?? null,
            'timeDifferenceInDays' => $timeDifferenceInDays,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];

        return Inertia::render('Frontend/Student/ActivityDetail', ['response' => rtFormat($data)]);
    }


    /**
     * 學員個人介面
     */
    public function personalPage(Request $request)
    {
        $registerActivity = ActivityDetail::orderBy('id', 'desc')
            ->whereHas('registerActivities.userRoleStudent', function ($query) use ($request) {
                return $query->where('id', $request->user()->userRoleStudent->id);
            })
            ->whereHas('studentActivities', function ($query) {
                return $query->where('activity_type', 2);
            })
            ->whereDate('activity_end_time', '>=', now()->toDateString())
            ->with('activityPhotos:id,activity_id,activity_img_path')
            ->paginate(5)
            ->through(function ($item) {
                // 找出第一張圖片
                $coverPhoto = $item->activityPhotos->first();

                // 找出已收藏的人數
                $collectionCount = $item->studentActivities->where('activity_type', 1)->count();

                return [
                    'id' => $item->id,
                    // 活動名稱
                    'activity_name' => $item->activity_name,
                    // 活動Slogan
                    'activity_info' => $item->activity_info,
                    // 活動類型代號
                    'activity_type' => $item->activity_type,
                    // 活動類型名稱
                    'activity_type_name' => $this->activityPresenter->getActivityTypeName($item->activity_type),
                    // 活動人數下限
                    'activity_lowest_number_of_people' => $item->activity_lowest_number_of_people,
                    // 活動人數上限
                    'activity_highest_number_of_people' => $item->activity_highest_number_of_people,
                    // 活動報名開始時間
                    'activity_start_registration_time' => date('Y-m-d H:i', strtotime($item->activity_start_registration_time)),
                    // 活動報名截止時間
                    'activity_end_registration_time' => date('Y-m-d H:i', strtotime($item->activity_end_registration_time)),
                    // 活動開始時間
                    'activity_start_time' => date('Y-m-d H:i', strtotime($item->activity_start_time)),
                    // 活動結束時間
                    'activity_end_time' => date('Y-m-d H:i', strtotime($item->activity_end_time)),
                    // 活動地點
                    'activity_address' => $item->activity_address,
                    // 活動封面圖片
                    'cover_photo' => $coverPhoto->activity_img_path ?? '',
                    // 活動收藏人數
                    'collection_count' => $collectionCount,
                ];
            });

        $favoriteActivity = ActivityDetail::orderBy('id', 'desc')
            ->whereHas('studentActivities', function ($query) use ($request) {
                return $query
                    ->where('student_id', $request->user()->userRoleStudent->id)
                    ->where('activity_type', 1);
            })
            ->whereDate('activity_end_time', '>=', now()->toDateString())
            ->with('activityPhotos:id,activity_id,activity_img_path')
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
                    // 活動類型代號
                    'activity_type' => $item->activity_type,
                    // 活動類型名稱
                    'activity_type_name' => $this->activityPresenter->getActivityTypeName($item->activity_type),
                    // 活動人數下限
                    'activity_lowest_number_of_people' => $item->activity_lowest_number_of_people,
                    // 活動人數上限
                    'activity_highest_number_of_people' => $item->activity_highest_number_of_people,
                    // 活動報名開始時間
                    'activity_start_registration_time' => date('Y-m-d H:i', strtotime($item->activity_start_registration_time)),
                    // 活動報名截止時間
                    'activity_end_registration_time' => date('Y-m-d H:i', strtotime($item->activity_end_registration_time)),
                    // 活動開始時間
                    'activity_start_time' => date('Y-m-d H:i', strtotime($item->activity_start_time)),
                    // 活動結束時間
                    'activity_end_time' => date('Y-m-d H:i', strtotime($item->activity_end_time)),
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
        $allActivity = ActivityDetail::orderBy('id', 'desc')
            ->whereDate('activity_end_time', '>=', now()->toDateString())
            ->where(function ($query) use ($request, $keyword) {
                $query->whereHas('studentActivities', function ($subquery) use ($request) {
                    $subquery->where('student_id', $request->user()->userRoleStudent->id);
                })
                    ->where(function ($subquery) use ($keyword) {
                        $subquery->where('activity_name', 'like', "%$keyword%")
                            ->orWhere('activity_presenter', 'like', "%$keyword%")
                            ->orWhere('activity_end_registration_time', 'like', "%$keyword%")
                            ->orWhere('activity_lowest_number_of_people', 'like', "%$keyword%")
                            ->orWhere('activity_highest_number_of_people', 'like', "%$keyword%");
                    });
            })
            ->paginate(5)
            ->through(function ($item) {
                // 找出已報名的人數
                $registrationCount = $item->studentActivities->where('activity_type', 2)->count();
                return [
                    'id' => $item->id,
                    // 活動名稱
                    'activity_name' => $item->activity_name,
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
                    // 活動報名人數
                    'registration_count' => $registrationCount,
                ];
            });
        $finishedActivity = ActivityDetail::orderBy('id', 'desc')
            ->whereDate('activity_end_time', '<=', now()->toDateString())
            ->where(function ($query) use ($request, $keyword) {
                $query->whereHas('studentActivities', function ($subquery) use ($request) {
                    $subquery->where('student_id', $request->user()->userRoleStudent->id);
                })
                    ->where(function ($subquery) use ($keyword) {
                        $subquery->where('activity_name', 'like', "%$keyword%")
                            ->orWhere('activity_presenter', 'like', "%$keyword%")
                            ->orWhere('activity_end_registration_time', 'like', "%$keyword%")
                            ->orWhere('activity_lowest_number_of_people', 'like', "%$keyword%")
                            ->orWhere('activity_highest_number_of_people', 'like', "%$keyword%");
                    });
            })
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
                    // 活動講者
                    'activity_presenter' => $item->activity_presenter,
                    // 活動類型代號
                    'activity_type' => $item->activity_type,
                    // 活動封面圖片
                    'cover_photo' => $coverPhoto->activity_img_path ?? '',
                    // 活動類型名稱
                    'activity_type_name' => $this->activityPresenter->getActivityTypeName($item->activity_type),
                    // 活動人數下限
                    'activity_lowest_number_of_people' => $item->activity_lowest_number_of_people,
                    // 活動人數上限
                    'activity_highest_number_of_people' => $item->activity_highest_number_of_people,
                    // 活動報名截止時間
                    'activity_end_registration_time' => date('Y-m-d H:i', strtotime($item->activity_end_registration_time)),
                    // 活動報名人數
                    'registration_count' => $registrationCount,
                    // 活動收藏人數
                    'collection_count' => $collectionCount,
                    // 活動結束時間
                    'activity_start_time' => date('Y-m-d H:i', strtotime($item->activity_start_time)),
                    // 活動地點
                    'activity_address' => $item->activity_address,
                ];
            });

        $data = (object) [
            'registerActivity' => $registerActivity,
            'favoriteActivity' => $favoriteActivity,
            'finishedActivity' => $finishedActivity,
            'allActivity' => $allActivity,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];


        return Inertia::render('Frontend/Student/StudentPersonalPage', ['response' => rtFormat($data)]);
    }

    /**
     * 報名活動
     */
    public function create(Request $request)
    {
        $request->validate([
            'studentName' => 'required',
            'studentPhoneNumber' => 'required',
            'studentEmail' => 'required',
            'activity_id' => 'required',
            'qrcodeNumber' => 'required',
            'qrcodeImage' => 'required',
        ]);
        $register = [];

        $activityDetail = ActivityDetail::find($request->activity_id);

        $test = RegisterActivity::where('student_id', $request->user()->userRoleStudent->id)
            ->where('activity_id', $request->activity_id)
            ->first();

        if (!$test) {
            StudentActivity::create([
                'student_id' => $request->user()->userRoleStudent->id,
                'activity_id' => $request->activity_id,
                'activity_type' => $request->registered,
            ]);
            QrcodeDetail::create([
                'activity_id' => $request->activity_id,
                'student_id' => $request->user()->userRoleStudent->id,
                'qrcode_path' => $request->qrcodeImage,
                'qrcode_number' => $request->qrcodeNumber,
            ]);
            UserBehavior::create([
                'type_id' => 2,
                'user_type' => '學員',
                'user_name' => $request->user()->userRoleStudent->user_name,
                'behavior' => $request->user()->userRoleStudent->user_name . '報名了' . $activityDetail->activity_name . '活動',
            ]);
            $register = RegisterActivity::updateOrCreate([
                'activity_id' => $request->activity_id,
                'student_id' => $request->user()->userRoleStudent->id,
                'student_name' => $request->studentName,
                'student_phone_number' => $request->studentPhoneNumber,
                'student_email' => $request->studentEmail,
                'student_additional_remark' => $request->studentAdditionalRemark,
            ]);
        }

        return back()->with(['message' => rtFormat($register)]);
    }

    public function fillUserData(Request $request)
    {
        $userData = User::find($request->user()->id);
        $userPhoneNumber = UserRoleStudent::where('user_id', $request->user()->id)->first();

        $data = (object) [
            'userData' => $userData,
            'userPhoneNumber' => $userPhoneNumber,
        ];
        
        return back()->with(['message' => rtFormat($data)]);
    }

    /**
     * 刪除報名
     */
    public function registerDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:register_activities,activity_id'
        ]);

        $register = RegisterActivity::where('activity_id', $request->id)->where('student_id', $request->user()->UserRoleStudent->id)->first();

        $student = StudentActivity::where('activity_type', 2)->where('student_id', $request->user()->UserRoleStudent->id);

        $activityDetail = ActivityDetail::where('id', $request->id)->first();

        UserBehavior::create([
            'type_id' => 2,
            'user_type' => '學員',
            'user_name' => $request->user()->userRoleStudent->user_name,
            'behavior' => $request->user()->userRoleStudent->user_name . '取消報名' . $activityDetail->activity_name,
        ]);


        $register->delete();
        $student->delete();


        return redirect(route('studentPersonalPage'));
    }

    /**
     * 編輯報名
     */
    public function activityEdit($id, Request $request)
    {
        $favoriteCheck = StudentActivity::where('activity_type', 1)
            ->where('activity_id', $id)
            ->where('student_id', $request->user()->UserRoleStudent->id)
            ->first();

        $activity = ActivityDetail::with(['activityPhotos:id,activity_id,activity_img_path'])
            ->where('id', $id)
            ->first();
        if (!$activity) {
            return abort(404);
        }

        $currentTimestamp = time();
        $activityStartTime = strtotime($activity->activity_start_time);
        $timeDifferenceInSeconds = $activityStartTime - $currentTimestamp;
        $timeDifferenceInDays = intval($timeDifferenceInSeconds / (3600 * 24));

        $activityPhotos = $activity->activityPhotos;
        $result = [
            'id' => $activity->id,
            'activity_name' => $activity->activity_name,
            'activity_info' => $activity->activity_info,
            'activity_presenter' => $activity->activity_presenter,
            'activity_type' => $activity->activity_type,
            'activity_type_name' => $this->activityPresenter->getActivityTypeName($activity->activity_type),
            'activity_lowest_number_of_people' => $activity->activity_lowest_number_of_people,
            'activity_highest_number_of_people' => $activity->activity_highest_number_of_people,
            'activity_start_registration_time' => date('Y-m-d H:i', strtotime($activity->activity_start_registration_time)),
            'activity_end_registration_time' => date('Y-m-d H:i', strtotime($activity->activity_end_registration_time)),
            'activity_start_time' => date('Y-m-d H:i', strtotime($activity->activity_start_time)),
            'activity_end_time' => date('Y-m-d H:i', strtotime($activity->activity_end_time)),
            'activity_address' => $activity->activity_address,
            'activity_instruction' => $activity->activity_instruction,
            'activity_information' => $activity->activity_information,
            'activityPhotos' => $activityPhotos->pluck('activity_img_path')->toArray(),
        ];

        $qrcode = QrcodeDetail::where('activity_id', $id)->where('student_id', $request->user()->UserRoleStudent->id)->first();

        $registerPeople = ActivityDetail::orderBy('id', 'desc')
            ->whereHas('registerActivities', function ($query) use ($id) {
                return $query->where('activity_id', $id);
            })
            ->count();

        $registerData = RegisterActivity::where('activity_id', $id)
            ->first();

        $data = (object) [
            'activity' => $result,
            'qrcode' => $qrcode,
            'favoriteCheck' => $favoriteCheck,
            'timeDifferenceInDays' => $timeDifferenceInDays,
            'registerPeople' => $registerPeople,
            'registerData' => $registerData,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];

        return Inertia::render('Frontend/Student/StudentEditActivity', ['response' => rtFormat($data)]);
    }

    /**
     * 報名資訊更新
     */
    public function registerUpdate(Request $request)
    {
        $request->validate([
            'studentName' => 'required',
            'studentPhoneNumber' => 'required',
            'studentEmail' => 'required',
            'activity_id' => 'required',
        ]);

        $registerData = RegisterActivity::find($request->user()->userRoleStudent->id);

        $activityDetail = ActivityDetail::find($request->activity_id);

        UserBehavior::create([
            'type_id' => 2,
            'user_type' => '學員',
            'user_name' => $request->user()->userRoleStudent->user_name,
            'behavior' => $request->user()->userRoleStudent->user_name . '修改了' . $activityDetail->activity_name . '的報名資訊',
        ]);

        $registerData->update([
            'activity_id' => $request->activity_id,
            'student_id' => $request->user()->userRoleStudent->id,
            'student_name' => $request->studentName,
            'student_phone_number' => $request->studentPhoneNumber,
            'student_email' => $request->studentEmail,
            'student_additional_remark' => $request->studentAdditionalRemark,
        ]);

        return back()->with(['message' => rtFormat($registerData)]);
    }

    /**
     * 收藏
     */
    public function createFavorite(Request $request)
    {
        $request->validate([
            'activity_id' => 'required',
        ]);
        $favorite = StudentActivity::create([
            'student_id' => $request->user()->userRoleStudent->id,
            'activity_id' => $request->activity_id,
            'activity_type' => $request->favorited,
        ]);
        $activityDetail = ActivityDetail::find($request->activity_id);
        UserBehavior::create([
            'type_id' => 2,
            'user_type' => '學員',
            'user_name' => $request->user()->userRoleStudent->user_name,
            'behavior' => $request->user()->userRoleStudent->user_name . '收藏了' . $activityDetail->activity_name . '活動',
        ]);

        return back()->with(['message' => rtFormat($favorite)]);
    }

    /**
     * 取消收藏
     */
    public function cancelFavorite(Request $request)
    {
        $request->validate([
            'activity_id' => 'required',
        ]);
        $cancelFavorite = StudentActivity::where('activity_id', $request->activity_id)->where('activity_type', 1)->where('student_id', $request->user()->userRoleStudent->id)->first();
        $activityDetail = ActivityDetail::where('id', $request->activity_id)->first();

        UserBehavior::create([
            'type_id' => 2,
            'user_type' => '學員',
            'user_name' => $request->user()->userRoleStudent->user_name,
            'behavior' => $request->user()->userRoleStudent->user_name . '取消收藏' . $activityDetail->activity_name . '活動',
        ]);

        $cancelFavorite->delete();

        return back()->with(['message' => rtFormat($cancelFavorite)]);
    }

    /**
     * 以完成活動
     */
    public function finishedActivity($id, Request $request)
    {
        $activity = ActivityDetail::with(['activityPhotos:id,activity_id,activity_img_path'])
            ->where('id', $id)
            ->first();
        if (!$activity) {
            return abort(404);
        }

        $currentTimestamp = time();
        $activityStartTime = strtotime($activity->activity_start_time);
        $timeDifferenceInSeconds = $activityStartTime - $currentTimestamp;
        $timeDifferenceInDays = intval($timeDifferenceInSeconds / (3600 * 24));

        $activityPhotos = $activity->activityPhotos;
        $result = [
            'id' => $activity->id,
            'activity_name' => $activity->activity_name,
            'activity_info' => $activity->activity_info,
            'activity_presenter' => $activity->activity_presenter,
            'activity_type' => $activity->activity_type,
            'activity_type_name' => $this->activityPresenter->getActivityTypeName($activity->activity_type),
            'activity_lowest_number_of_people' => $activity->activity_lowest_number_of_people,
            'activity_highest_number_of_people' => $activity->activity_highest_number_of_people,
            'activity_start_registration_time' => date('Y-m-d H:i', strtotime($activity->activity_start_registration_time)),
            'activity_end_registration_time' => date('Y-m-d H:i', strtotime($activity->activity_end_registration_time)),
            'activity_start_time' => date('Y-m-d H:i', strtotime($activity->activity_start_time)),
            'activity_end_time' => date('Y-m-d H:i', strtotime($activity->activity_end_time)),
            'activity_address' => $activity->activity_address,
            'activity_instruction' => $activity->activity_instruction,
            'activity_information' => $activity->activity_information,
            'activityPhotos' => $activityPhotos->pluck('activity_img_path')->toArray(),
        ];

        $qrcode = QrcodeDetail::where('activity_id', $id)->where('student_id', $request->user()->UserRoleStudent->id)->first();

        $registerPeople = ActivityDetail::orderBy('id', 'desc')
            ->whereHas('registerActivities', function ($query) use ($id) {
                return $query->where('activity_id', $id);
            })
            ->count();

        $registerData = RegisterActivity::where('activity_id', $id)
            ->first();

        $data = (object) [
            'activity' => $result,
            'qrcode' => $qrcode,
            'registerPeople' => $registerPeople,
            'registerData' => $registerData,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];

        return Inertia::render('Frontend/Student/FinishedActivity', ['response' => rtFormat($data)]);
    }
}
