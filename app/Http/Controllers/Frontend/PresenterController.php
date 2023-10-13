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
            ->whereDate('activity_end_time', '>=', now()->toDateString())
            ->with('activityPhotos:id,activity_id,activity_img_path')
            ->paginate(5)
            ->through(function ($item) {

                $coverPhoto = $item->activityPhotos->first();
                $collectionCount = $item->studentActivities->where('activity_type', 1)->count();
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
                    'activity_start_time' => date('Y-m-d H:i', strtotime($item->activity_start_time)),
                    'activity_address' => $item->activity_address,
                    'cover_photo' => $coverPhoto->activity_img_path ?? '',
                    'collection_count' => $collectionCount,
                    'registration_count' => $registrationCount,
                ];
            });

        $finishedActivity = ActivityDetail::orderBy('id', 'desc')
            ->where('presenter_id', $request->user()->UserRolePresenter->id)
            ->where(function ($query) use ($keyword) {
                $query->where('activity_name', 'like', "%$keyword%")
                    ->orWhere('activity_end_registration_time', 'like', "%$keyword%")
                    ->orWhere('activity_lowest_number_of_people', 'like', "%$keyword%")
                    ->orWhere('activity_highest_number_of_people', 'like', "%$keyword%");
            })
            ->whereDate('activity_end_time', '<', now()->toDateString())
            ->with('activityPhotos:id,activity_id,activity_img_path')
            ->paginate(5)
            ->through(function ($item) {

                $coverPhoto = $item->activityPhotos->first();
                $collectionCount = $item->studentActivities->where('activity_type', 1)->count();

                return [
                    'id' => $item->id,
                    'activity_name' => $item->activity_name,
                    'activity_type' => $item->activity_type,
                    'activity_type_name' => $this->activityPresenter->getActivityTypeName($item->activity_type),
                    'activity_start_time' => date('Y-m-d H:i', strtotime($item->activity_start_time)),
                    'activity_address' => $item->activity_address,
                    'cover_photo' => $coverPhoto->activity_img_path ?? '',
                    'collection_count' => $collectionCount,
                ];
            });

        $data = (object) [
            'activity' => $activity,
            'finishedActivity' => $finishedActivity,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];

        return Inertia::render('Frontend/Presenter/PresenterPersonalPage', ['response' => rtFormat($data)]);;
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
        $checkPeople = QrcodeDetail::where('activity_id', $id)->where('qrcode_status', 1)->count();
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
            'checkPeople' => $checkPeople,
            'timeDifferenceInDays' => $timeDifferenceInDays,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];
        return Inertia::render('Frontend/Presenter/ScannerPage', ['response' => rtFormat($data)]);
    }

    public function presenterFinishedActivity($id, Request $request)
    {
        $activity = ActivityDetail::find($id);
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

        $data = (object) [
            'activity' => $result,
            'registerPeople' => $registerPeople,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];
        return Inertia::render('Frontend/Presenter/FinishedActivity', ['response' => rtFormat($data)]);
    }

    public function activityScannerConfirm(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:qrcode_details,qrcode_number'
        ]);
        $registerCheck = QrcodeDetail::where('qrcode_number', $request->code)->first();
        $registerCheck->update([
            'qrcode_status' => 1,
        ]);

        return back()->with(['message' => rtFormat($registerCheck)]);
    }

    public function activityEdit($id)
    {
        $activity = ActivityDetail::find($id);

        $currentTimestamp = time();
        $activityStartTime = strtotime($activity->activity_start_time);
        $timeDifferenceInSeconds = $activityStartTime - $currentTimestamp;
        $timeDifferenceInDays = intval($timeDifferenceInSeconds / (3600 * 24));

        $activityPhotos = $activity->activityPhotos->map(function ($photo) {
            return [
                'id' => $photo->id,
                'activity_img_path' => $photo->activity_img_path,
            ];
        })->toArray();

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
            'activityPhotos' => $activityPhotos,
        ];


        $data = (object) [
            'activity' => $result,
            'timeDifferenceInDays' => $timeDifferenceInDays,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
        ];

        return Inertia::render('Frontend/Presenter/EditActivity', ['response' => rtFormat($data)]);
    }

    public function activityPresenterUpdate(Request $request)
    {
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

        $activityPhotos = ActivityPhoto::where('activity_id', $activity->id)->get();

        foreach ($activityPhotos as $photo) {
            $photo->delete();
        }

        foreach ($request->formData['activityPhoto'] as $value) {

            $activity_img_path = $value['activity_img_path'];

            if (strpos($activity_img_path, '/') === 0) {
                $activity_img_path_result = $activity_img_path;
            } else {
                $activity_img_path_result = $this->filesService->base64Upload($activity_img_path, 'otherProduct');
            }

            ActivityPhoto::create([
                'activity_id' => $activity->id,
                'activity_img_path' => $activity_img_path_result,
            ]);
        }

        // dd(123);


        return back()->with(['message' => rtFormat($activity)]);
    }

    public function activityDelete(Request $request)
    {
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
