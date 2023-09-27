<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $testData = [100, 200, 300];

        return Inertia::render('Frontend/Index', ['response' => rtFormat($testData)]);
    }

    public function activity_details()
    {
        return Inertia::render('Frontend/ActivityDetail');
    }

    public function create_activity()
    {
        return Inertia::render('Frontend/Presenter/CreateActivity');
    }
    public function edit_activity()
    {
        return Inertia::render('Frontend/Presenter/EditActivity');
    }
    
    public function activity_classification()
    {
        return Inertia::render('Frontend/ActivityClassification');
    }
    
    public function swiper_test()
    {
        return Inertia::render('Frontend/SwiperTest');
    }

    public function test()
    {
        return Inertia::render('Frontend/Test');
    }
}
