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
}
