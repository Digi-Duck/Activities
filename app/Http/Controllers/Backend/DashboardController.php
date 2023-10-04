<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Backend/Dashboard');
    }
    public function activityMange()
    {
        return Inertia::render('Backend/ActivityManage');
    }
    public function studentMange()
    {
        return Inertia::render('Backend/StudentManage');
    }
    public function presenterMange()
    {
        return Inertia::render('Backend/PresenterManage');
    }
}
