<?php

namespace App\Http\Controllers;

use App\Models\ActivityDetail;
use App\Models\ActivityPhoto;
use App\Services\FilesService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PresenterController extends Controller
{
    public function __construct(protected FilesService $filesService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $activity = ActivityDetail::orderBy('id','desc')->where('presenter_id',$request->user()->UserRolePresenter->id)->get()->map(function($item) {
            $item->timeFormat = $item->created_at->format('Y/m/d');
            return $item;
        });

        return Inertia::render('Frontend/Presenter/PresenterPersonalPage', [ 'response' => rtFormat($activity)]);;
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
        // $user = $request->user();
        // dd($user = $request->user()->userRolePresenter->id);
        // dd($request->all());
        $request->validate([
            'activityName' => 'required',
            'activityInfo' => 'required',
            'activityType' => 'required',
            'activityPhoto' => 'required',
            'activityPresenter' => 'required',
            'activityLowestNumberOfPeople' => 'required|numeric',
            'activityHighestNumberOfPeople' => 'required|numeric',
            'activityStartRegistrationTime' => 'required',
            'activityEndRegistrationTime' => 'required',
            'activityStartTime' => 'required',
            'activityEndTime' => 'required',
            'activityAddress' => 'required',
            'activityInstruction' => 'required',
            'activityInformation' => 'required',
        ]);
        // dd($request->all());

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

        // $activity_photo = ActivityPhoto::create([
        //     'activity_img_path' => $this->filesService->base64Upload($request->activityPhoto[0], 'activity'),
        // ]);

        foreach ($request->activityPhoto ?? [] as $value) {
            ActivityPhoto::create([
                'activity_id' => $activity->id,
                'activity_img_path' => $this->filesService->base64Upload($value['activity_img_path'], 'otherProduct'),
                // 'sort' => 1,
            ]);
        }

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
    public function activityEdit($id)
    {
        //
        $activity = ActivityDetail::find($id);

        return Inertia::render('Frontend/Presenter/EditActivity', [ 'response' => rtFormat($activity)]);
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
