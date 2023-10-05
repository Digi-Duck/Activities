<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityDetail;
use App\Models\RegisterActivity;
use App\Models\StudentActivity;
use Inertia\Inertia;
use App\Presenters\ActivityPresenter;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function __construct(
        protected ActivityPresenter $activityPresenter,
    ) {
    }
    /**
     * Display a listing of the resource.
     * 這是各活動細項
     */
    public function index($id)
    {
        //
        $activity = ActivityDetail::find($id)->with('activityPhotos:id,activity_id,activity_img_path')->where('id', $id)->first();

        $registerPeople = ActivityDetail::orderBy('id', 'desc')
        ->whereHas('registerActivities', function ($query) use ($id) {
                return $query->where('activity_id', $id);
            })
        ->count();

        $data = (object) [
            'activity' => $activity,
            'registerPeople' => $registerPeople,
            'activityTypeData' => $this->activityPresenter->typeOption,
        ];

        
        return Inertia::render('Frontend/Student/ActivityDetail', ['response' => rtFormat($data)]);
    }
    public function personalPage(Request $request)
    {
        // $activity = ActivityDetail::orderBy('id', 'desc')->where('presenter_id', $request->user()->UserRoleStudent->id)->get()->map(function ($item) {
        //     $item->timeFormat = $item->created_at->format('Y/m/d');
        //     return $item;
        // });
        // $registerActivity = StudentActivity::where('student_id', $request->user()->UserRoleStudent->id)->where('activity_type', 2)->with('activityDetail.activityPhotos')->get();
        // dd($request->user());

        // $registerActivity = ActivityDetail::orderBy('id', 'desc')
        //     // ->where('id', $request->user()->userRoleStudent->id)
        //     /**
        //      * 關連到外部的model，藉由model中的function連接，
        //      * 使用$query遍歷該資料
        //      * 使用$request將此function之外的變數拉進來
        //      */
            // ->whereHas('registerActivities.userRoleStudent', function ($query) use ($request) {
            //     return $query->where('id', $request->user()->userRoleStudent->id);
            // })
            // ->whereHas('studentActivities', function ($query) {
            //     return $query->where('activity_type', 2);
            // })
        //     ->with('activityPhotos:id,activity_id,activity_img_path')
        //     ->get();

        // $favoriteActivity = ActivityDetail::orderBy('id', 'desc')
        //     // ->where('id', $request->user()->userRoleStudent->id)
        //     /**
        //      * 關連到外部的model，藉由model中的function連接，
        //      * 使用$query遍歷該資料
        //      * 使用$request將此function之外的變數拉進來
        //      */
        //     ->whereHas('registerActivities.userRoleStudent', function ($query) use ($request) {
        //         return $query->where('id', $request->user()->userRoleStudent->id);
        //     })
        //     ->whereHas('studentActivities', function ($query) {
        //         return $query->where('activity_type', 1);
        //     })
        //     ->with('activityPhotos:id,activity_id,activity_img_path')
        //     ->get();

        // $allActivityDetails = ActivityDetail::orderBy('id', 'desc')
        //     // ->where('id', $request->user()->userRoleStudent->id)
        //     /**
        //      * 關連到外部的model，藉由model中的function連接，
        //      * 使用$query遍歷該資料
        //      * 使用$request將此function之外的變數拉進來
        //      */
        //     ->whereHas('registerActivities.userRoleStudent', function ($query) use ($request) {
        //         return $query->where('id', $request->user()->userRoleStudent->id);
        //     })
        //     ->with('activityPhotos:id,activity_id,activity_img_path')
        //     ->get();

        // $data = (object)[
        //     'registerActivity' => $registerActivity,
        //     // 'regiterActivityDetails' => $regiterActivityDetails,
        //     'favoriteActivity' => $favoriteActivity,
        //     // 'favoriteActivityDetails' => $favoriteActivityDetails,
        //     'allActivityDetails' => $allActivityDetails,
        // ];


        // 活動列表資料
        $registerActivity = ActivityDetail::orderBy('id', 'desc')
            ->whereHas('registerActivities.userRoleStudent', function ($query) use ($request) {
                return $query->where('id', $request->user()->userRoleStudent->id);
            })
            ->whereHas('studentActivities', function ($query) {
                return $query->where('activity_type', 2);
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

        $favoriteActivity = ActivityDetail::orderBy('id', 'desc')
            ->whereHas('registerActivities.userRoleStudent', function ($query) use ($request) {
                return $query->where('id', $request->user()->userRoleStudent->id);
            })
            ->whereHas('studentActivities', function ($query) {
                return $query->where('activity_type', 1);
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

        $allActivity = ActivityDetail::orderBy('id', 'desc')
            ->whereHas('registerActivities.userRoleStudent', function ($query) use ($request) {
                return $query->where('id', $request->user()->userRoleStudent->id);
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
            'registerActivity' => $registerActivity,
            'favoriteActivity' => $favoriteActivity,
            'allActivity' => $allActivity,
            'activityTypeData' => $this->activityPresenter->typeOption,
        ];


        return Inertia::render('Frontend/Student/StudentPersonalPage', ['response' => rtFormat($data)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        // dd($request->all());
        $request->validate([
            'studentName' => 'required',
            'studentPhoneNumber' => 'required',
            'studentEmail' => 'required',
            'activity_id' => 'required',
            // 'student_id' =>
        ]);
        // dd($request->all());

        // 判斷是否已經出現在table裡面

        // dd($request->all());
        // dd($request->activity_id);
        StudentActivity::create([
            'student_id' => $request->user()->userRoleStudent->id,
            'activity_id' => $request->activity_id,
            'activity_type' => $request->registered,
        ]);
        $register = RegisterActivity::create([
            'activity_id' => $request->activity_id,
            'student_id' => $request->user()->userRoleStudent->id,
            'student_name' => $request->studentName,
            'student_phone_number' => $request->studentPhoneNumber,
            'student_email' => $request->studentEmail,
            'student_additional_remark' => $request->studentAdditionalRemark,
        ]);


        return back()->with(['message' => rtFormat($register)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
