<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ActivityDetail;
use App\Models\ActivityPhoto;
use App\Models\QrcodeDetail;
use App\Models\RegisterActivity;
use App\Models\UserBehavior;
use App\Services\FilesService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Presenters\ActivityPresenter;

class PresenterController extends Controller
{
    public function __construct(
        protected FilesService $filesService,
        protected ActivityPresenter $activityPresenter,
    ) {
    }
    /**
     * 講師的個人介面
     */
    public function index(Request $request)
    {
        // $activity = ActivityDetail::orderBy('id', 'desc')->where('presenter_id', $request->user()->UserRolePresenter->id)->with('activityPhotos:id,activity_id,activity_img_path')->get();

        $keyword = $request->keyword ?? '';
        // dd($request->user()->UserRolePresenter->id);
        // 活動列表資料
        $activity = ActivityDetail::orderBy('id', 'desc')
            ->where('presenter_id', $request->user()->UserRolePresenter->id)
            ->where(function ($query) use ($keyword) {
                $query->where('activity_name', 'like', "%$keyword%")
                    ->orWhere('activity_end_registration_time', 'like', "%$keyword%")
                    ->orWhere('activity_lowest_number_of_people', 'like', "%$keyword%")
                    ->orWhere('activity_highest_number_of_people', 'like', "%$keyword%");
            })
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

        $data = (object) [
            'activity' => $activity,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];

        return Inertia::render('Frontend/Presenter/PresenterPersonalPage', ['response' => rtFormat($data)]);
        ;
    }

    public function createActivity()
    {
        return Inertia::render('Frontend/Presenter/CreateActivity');
    }

    public function activityStore(Request $request)
    {
        $request->validate([
            'activityName' => 'required',
            'activityInfo' => 'required',
            'activityType' => 'required',
            'activityPhoto' => 'required',
            'activityPresenter' => 'required',
            'activityLowestNumberOfPeople' => 'required|numeric',
            'activityHighestNumberOfPeople' => 'required|numeric',
            'activityStartRegistrationTime' => 'required|date_format:Y-m-d H:i', // 日期时间格式
            'activityEndRegistrationTime' => 'required|date_format:Y-m-d H:i|after:activityStartRegistrationTime', // 需要晚于开始时间
            'activityStartTime' => 'required|date_format:Y-m-d H:i',
            'activityEndTime' => 'required|date_format:Y-m-d H:i|after:activityStartTime', // 需要晚于开始时间
            'activityAddress' => 'required',
            'activityInstruction' => 'required',
            'activityInformation' => 'required',
        ], [
            'activityStartRegistrationTime.date_format' => '時間格式為:2000-01-01 10:00',
            'activityEndRegistrationTime.date_format' => '時間格式為:2000-01-01 10:00',
            'activityEndRegistrationTime.after' => '需晚於開始註冊時間',
            'activityStartTime.date_format' => '時間格式為:2000-01-01 10:00',
            'activityEndTime.date_format' => '時間格式為:2000-01-01 10:00',
            'activityEndTime.after' => '需晚於開始註冊時間',
        ]);


        $activity = ActivityDetail::create([
            'activity_name' => $request->activityName,
            'activity_info' => $request->activityInfo,
            'activity_type' => $request->activityType,
            'presenter_id' => $request->user()->userRolePresenter->id,
            'activity_phone_number' => $request->user()->userRolePresenter->phone_number,
            'activity_email' => $request->user()->email,
            'activity_presenter' => $request->activityPresenter,
            'activity_lowest_number_of_people' => $request->activityLowestNumberOfPeople,
            'activity_highest_number_of_people' => $request->activityHighestNumberOfPeople,
            'activity_start_registration_time' => $request->activityStartRegistrationTime,
            'activity_end_registration_time' => $request->activityEndRegistrationTime,
            'activity_start_time' => $request->activityStartTime,
            'activity_end_time' => $request->activityEndTime,
            'activity_address' => $request->activityAddress,
            'activity_instruction' => $request->activityInstruction,
            'activity_information' => $request->activityInformation,
        ]);

        UserBehavior::create([
            'type_id' => 1,
            'user_type' => '講師',
            'user_name' => $request->user()->userRolePresenter->user_name,
            'behavior' => $request->user()->userRolePresenter->user_name . '建立了' . $request->activityName,
        ]);

        foreach ($request->activityPhoto ?? [] as $value) {
            ActivityPhoto::create([
                'activity_id' => $activity->id,
                'activity_img_path' => $this->filesService->base64Upload($value['activity_img_path'], 'otherProduct'),
                // 'sort' => 1,
            ]);
        }

        return back()->with(['message' => rtFormat($activity)]);
    }

    public function activityScanner($id, Request $request)
    {
        $activity = ActivityDetail::find($id);
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
        $keyword = $request->keyword ?? '';
        $studentData = RegisterActivity::where('activity_id', $id)
            ->where('student_name', 'like', "%$keyword%")
            ->orwhere('student_phone_number', 'like', "%$keyword%")
            ->orwhere('student_email', 'like', "%$keyword%")
            ->paginate(5)
            ->through(function ($item) {
                return [
                    'id' => $item->id,
                    'student_name' => $item->student_name,
                    'student_phone_number' => $item->student_phone_number,
                    'student_email' => $item->student_email,
                    'student_additional_remark' => $item->student_additional_remark,
                ];
            });
        $data = (object) [
            'activity' => $result,
            'registerPeople' => $registerPeople,
            'studentData' => $studentData,
            'timeDifferenceInDays' => $timeDifferenceInDays,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];
        return Inertia::render('Frontend/Presenter/ScannerPage', ['response' => rtFormat($data)]);
    }

    public function activityScannerConfirm(Request $request)
    {
        $registerCheck = QrcodeDetail::where('activity_id', $request->activity_id)->where('qrcode_number', $request->code);
        $registerCheck->update([
            'qrcode_status' => 1,
        ]);

        return back()->with(['message' => rtFormat($registerCheck)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function activityEdit($id)
    {
        //
        // $activity = ActivityDetail::find($id)
        //     ->with('activityPhotos:id,activity_id,activity_img_path')
        //     ->where('id', $id)
        //     ->first();

        $activity = ActivityDetail::find($id);

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

        $data = (object) [
            'activity' => $result,
            'timeDifferenceInDays' => $timeDifferenceInDays,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];

        return Inertia::render('Frontend/Presenter/EditActivity', ['response' => rtFormat($data)]);
    }

    public function activityUpdate(Request $request)
    {

        $request->validate([
            'formData.activityName' => 'required',
            'formData.activityInfo' => 'required',
            'formData.activityType' => 'required',
            'formData.activityPhoto' => 'required',
            'formData.activityPresenter' => 'required',
            'formData.activityLowestNumberOfPeople' => 'required|numeric',
            'formData.activityHighestNumberOfPeople' => 'required|numeric',
            'formData.activityStartRegistrationTime' => 'required',
            'formData.activityEndRegistrationTime' => 'required',
            'formData.activityStartTime' => 'required',
            'formData.activityEndTime' => 'required',
            'formData.activityAddress' => 'required',
            'formData.activityInstruction' => 'required',
            'formData.activityInformation' => 'required',
        ]);

        $activity = ActivityDetail::find($request->id);
        UserBehavior::create([
            'type_id' => 1,
            'user_type' => '講師',
            'user_name' => $request->user()->userRolePresenter->user_name,
            'behavior' => $request->user()->userRolePresenter->user_name . '修改了' . $activity->activity_name,
        ]);


        $activity->update([
            'activity_name' => $request->formData['activityName'],
            'activity_info' => $request->formData['activityInfo'],
            'activity_type' => $request->formData['activityType'],
            'activity_presenter' => $request->formData['activityPresenter'],
            'activity_lowest_number_of_people' => $request->formData['activityLowestNumberOfPeople'],
            'activity_highest_number_of_people' => $request->formData['activityHighestNumberOfPeople'],
            'activity_start_registration_time' => $request->formData['activityStartRegistrationTime'],
            'activity_end_registration_time' => $request->formData['activityEndRegistrationTime'],
            'activity_start_time' => $request->formData['activityStartTime'],
            'activity_end_time' => $request->formData['activityEndTime'],
            'activity_address' => $request->formData['activityAddress'],
            'activity_instruction' => $request->formData['activityInstruction'],
            'activity_information' => $request->formData['activityInformation'],
        ]);

        return back()->with(['message' => rtFormat($activity)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function activityDelete(Request $request)
    {
        //
        $request->validate([
            'id' => 'required|exists:activity_details,id'
        ]);
        $activity = ActivityDetail::find($request->id);

        UserBehavior::create([
            'type_id' => 1,
            'user_type' => '講師',
            'user_name' => $request->user()->userRolePresenter->user_name,
            'behavior' => $request->user()->userRolePresenter->user_name . '刪除了' . $request->activityName,
        ]);


        $activity->delete();

        return redirect(route('presenterPersonalPage'));
    }
}
