<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityDetail;

class IndexController extends Controller
{
    public function index()
    {
        //
        $activity = ActivityDetail::all();
        
        return Inertia::render('Frontend/Index', [ 'response' => rtFormat($activity) ]);
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
