<?php

namespace App\Http\Controllers;

use App\Models\ActivityDetail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PresenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function createActivity()
    {
        return Inertia::render('Frontend/Presenter/CreateActivity');
    }

    public function activityStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'activityPresenter' => 'required',
            'activityLowestNumberOfPeople' => 'required|numeric',
            'activityHighestNumberOfPeople' => 'required|numeric',
            'activityStartRegistrationTime' => 'required',
            'activityEndRegistrationTime' => 'required',
            'activityStartTime' => 'required',
            'activityEndTime' => 'required',
            'activityAddress' => 'required',
            'activityInstruction' => 'required',
        ]);

        $activity = ActivityDetail::create([
            'presenterId' => $request->presenter_id,
            'activityPresenter' => $request->activity_presenter,
            'activityLowestNumberOfPeople' => $request->activity_lowest_number_of_people,
            'activityHighestNumberOfPeople' => $request->activity_highest_number_of_people,
            'activityStartRegistrationTime' => $request->activity_start_registration_time,
            'activityEndRegistrationTime' => $request->activity_end_registration_time,
            'activityStartTime' => $request->activity_start_time,
            'activityEndTime' => $request->activity_end_time,
            'activityAddress' => $request->activity_address,
            'activityInstruction' => $request->activity_instruction,
        ]);

        return back()->with(['message' => rtFormat($activity)]);
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
