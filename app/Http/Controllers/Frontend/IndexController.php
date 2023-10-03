<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityDetail;
use App\Models\ActivityPhoto;

class IndexController extends Controller
{
    public function index()
    {
        //
        // $activity = ActivityDetail::orderBy('id','desc')->get()->map(function($item) {
        //     $item->timeFormat = $item->created_at->format('Y/m/d');
        //     return $item;
        // });
        $activity = ActivityDetail::orderBy('id', 'desc')->where('activity_status', 1)->with('activityPhotos:id,activity_id,activity_img_path')->get();
        // $activityPhoto = ActivityPhoto::orderBy('id', 'desc')->where('activity_id', $activity->id)->get();
        
        // return Inertia::render('Frontend/Index', [ 'response' => rtFormat($activity) ]);
        return Inertia::render('Frontend/Index', [ 'response' => rtFormat($activity)]);
    }

    public function activityDetails()
    {
        return Inertia::render('Frontend/ActivityDetail');
    }
    
    public function activityClassification()
    {
        return Inertia::render('Frontend/ActivityClassification');
    }

    public function test()
    {
        return Inertia::render('Frontend/Test');
    }
}
