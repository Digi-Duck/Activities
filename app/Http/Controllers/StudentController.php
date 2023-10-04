<?php

namespace App\Http\Controllers;

use App\Models\ActivityDetail;
use App\Models\RegisterActivity;
use Illuminate\Http\Request;
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
        $activity = ActivityDetail::find($id)->with('activityPhotos:id,activity_id,activity_img_path')->where('id', $id)->get();
        return Inertia::render('Frontend/Student/ActivityDetail', [ 'response' => rtFormat($activity) ]);
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
        ]);
        // dd($request->all());

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
