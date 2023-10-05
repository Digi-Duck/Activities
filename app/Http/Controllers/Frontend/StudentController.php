<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityDetail;
use App\Models\RegisterActivity;
use App\Models\StudentActivity;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     * 這是各活動細項
     */
    public function index($id)
    {
        //
        $activity = ActivityDetail::find($id)->with('activityPhotos:id,activity_id,activity_img_path')->where('id', $id)->first();
        return Inertia::render('Frontend/Student/ActivityDetail', ['response' => rtFormat($activity)]);
    }
    public function personalPage(Request $request)
    {
        // $activity = ActivityDetail::orderBy('id', 'desc')->where('presenter_id', $request->user()->UserRoleStudent->id)->get()->map(function ($item) {
        //     $item->timeFormat = $item->created_at->format('Y/m/d');
        //     return $item;
        // });


        // $registerActivity = StudentActivity::where('student_id', $request->user()->UserRoleStudent->id)->where('activity_type', 2)->with('activityDetail.activityPhotos')->get();

        // dd($request->user());
        $registerActivity = ActivityDetail::orderBy('id', 'desc')
            // ->where('id', $request->user()->userRoleStudent->id)
            /**
             * 關連到外部的model，藉由model中的function連接，
             * 使用$query遍歷該資料
             * 使用$request將此function之外的變數拉進來
             */
            ->whereHas('registerActivities.userRoleStudent', function ($query) use ($request) {
                return $query->where('id', $request->user()->userRoleStudent->id);
            })
            ->whereHas('studentActivities', function ($query) {
                return $query->where('activity_type', 2);
            })
            ->with('activityPhotos:id,activity_id,activity_img_path')
            ->get();

        $favoriteActivity = ActivityDetail::orderBy('id', 'desc')
            // ->where('id', $request->user()->userRoleStudent->id)
            /**
             * 關連到外部的model，藉由model中的function連接，
             * 使用$query遍歷該資料
             * 使用$request將此function之外的變數拉進來
             */
            ->whereHas('registerActivities.userRoleStudent', function ($query) use ($request) {
                return $query->where('id', $request->user()->userRoleStudent->id);
            })
            ->whereHas('studentActivities', function ($query) {
                return $query->where('activity_type', 1);
            })
            ->with('activityPhotos:id,activity_id,activity_img_path')
            ->get();

        $allActivityDetails = ActivityDetail::orderBy('id', 'desc')
            // ->where('id', $request->user()->userRoleStudent->id)
            /**
             * 關連到外部的model，藉由model中的function連接，
             * 使用$query遍歷該資料
             * 使用$request將此function之外的變數拉進來
             */
            ->whereHas('registerActivities.userRoleStudent', function ($query) use ($request) {
                return $query->where('id', $request->user()->userRoleStudent->id);
            })
            ->with('activityPhotos:id,activity_id,activity_img_path')
            ->get();
        // dd($registerActivity);
        // $responseForm = ActivityDetail::where(function($query) use($request){
        //     return $query->where('lead_author_id', $request->user()->id)
        //         ->orWhereHas('coworker',function($coQuery) use($request){
        //             return $coQuery->where('coworker_id',$request->user()->id);
        //         });
        // })->find($request->id);

        // dd($registerActivity);
        // $regiterActivityDetails = ActivityDetail::orderBy('id', 'desc')->where('id', $registerActivity->id)->with('activityPhotos:id,activity_id,activity_img_path')->get();

        // $favoriteActivity = StudentActivity::where('student_id', $request->user()->UserRoleStudent->id)->where('activity_type', 1)->with('activityDetail.activityPhotos')->get();
        // $favoriteActivityDetails = ActivityDetail::orderBy('id', 'desc')->where('id', $favoriteActivity->id)->with('activityPhotos:id,activity_id,activity_img_path')->get();

        // $allActivityDetails = ActivityDetail::orderBy('id', 'desc')->where('id', $favoriteActivity->id)->orwhere('id', $registerActivity->id)->with('activityPhotos:id,activity_id,activity_img_path')->get();

        $data = (object)[
            'registerActivity' => $registerActivity,
            // 'regiterActivityDetails' => $regiterActivityDetails,
            'favoriteActivity' => $favoriteActivity,
            // 'favoriteActivityDetails' => $favoriteActivityDetails,
            'allActivityDetails' => $allActivityDetails,
        ];
        // dd(rtFormat($data));
        // return Inertia::render('Frontend/Presenter/PresenterPersonalPage', [ 'response' => rtFormat($activity)]);
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
