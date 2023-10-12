<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityDetail;
use App\Models\StudentActivity;
use App\Models\User;
use App\Models\UserBehavior;
use App\Models\UserRolePresenter;
use App\Models\UserRoleStudent;
use App\Presenters\ActivityPresenter;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(
        protected ActivityPresenter $activityPresenter,
    ) {
    }
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';
        $selectedType = $request->selectedType;
        $twoWeeksAgo = date('Y-m-d', strtotime('-2 weeks'));
        $startDate = $request->startDate ?? $twoWeeksAgo;
        $endDate = $request->endDate ?? now()->format('Y-m-d');
        $startRecordDate = $request->startRecordDate ?? $twoWeeksAgo;
        $endRecordDate = $request->endRecordDate ?? now()->format('Y-m-d');
        $activityCount = ActivityDetail::where('created_at', '>=', $twoWeeksAgo)->count();
        $studentCount = UserRoleStudent::where('created_at', '>=', $twoWeeksAgo)->count();
        $presenterCount = UserRolePresenter::where('created_at', '>=', $twoWeeksAgo)->count();
        $chartData = [
            'xAxis' => [
                'type' => 'category',
                'data' => [], // Initialize as an empty array
            ],
            'yAxis' => [
                'type' => 'value',
            ],
            'series' => [
                [
                    'data' => [], // Initialize as an empty array
                    'type' => 'bar',
                ],
            ],
        ];

        $dates = [];
        $data = [];

        for ($date = Carbon::parse($startDate); $date <= Carbon::parse($endDate); $date->addDay()) {
            $day = $date->format('Y-m-d');
        
            if ($selectedType == 1) {
                $count = ActivityDetail::whereDate('created_at', $day)->count();
            } elseif ($selectedType == 2) {
                $count = UserRolePresenter::whereDate('created_at', $day)->count();
            } else {
                $count = UserRoleStudent::whereDate('created_at', $day)->count();
            }
        
            $dates[] = $date->format('D');
            $data[] = $count;
        }

        $chartData['xAxis']['data'] = $dates;
        $chartData['series'][0]['data'] = $data;

        $newBehaviors = UserBehavior::select([
            'user_behaviors.id',
            'user_behaviors.user_name',
            'user_behaviors.created_at',
            'user_behaviors.behavior',
            'user_role_students.img_path AS student_image',
            'user_role_presenters.img_path AS presenter_image',
        ])
            ->leftJoin('user_role_students', 'user_behaviors.user_name', '=', 'user_role_students.user_name')
            ->leftJoin('user_role_presenters', 'user_behaviors.user_name', '=', 'user_role_presenters.user_name')
            ->orderBy('user_behaviors.id', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'user_name' => $item->user_name,
                    'created_at' => $item->created_at->format('Y/m/d H:i'),
                    'behavior' => $item->behavior,
                    'student_image' => $item->student_image,
                    'presenter_image' => $item->presenter_image,
                ];
            });

        $behaviorRecord = UserBehavior::where('user_name', 'like', "%$keyword%")
            ->orwhere('user_type', 'like', "%$keyword%")
            ->orwhere('behavior', 'like', "%$keyword%")
            ->orWhereBetween('created_at', [$startRecordDate, $endRecordDate])
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->through(function ($item) {
                return [
                    'id' => $item->id,
                    'user_type' => $item->user_type,
                    'user_name' => $item->user_name,
                    'behavior' => $item->behavior,
                    'created_at' => $item->created_at->format('Y/m/d H:i'),
                ];
            });

        $data = (object) [
            'newBehaviors' => $newBehaviors,
            'activityCount' => $activityCount,
            'chartData' => $chartData,
            'selectedType' => $selectedType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'twoWeeksAgo' => $twoWeeksAgo,
            'studentCount' => $studentCount,
            'presenterCount' => $presenterCount,
            'behaviorRecord' => $behaviorRecord,
            'activityTypeData' => $this->activityPresenter->getTypeOption(),
            'keyword' => $keyword,
        ];


        return Inertia::render('Backend/Dashboard', ['response' => rtFormat($data)]);
    }
    public function studentManage(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $status = $request->input('status', '');

        $student = User::where('user_role', 3)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('created_at', 'like', "%$keyword%");
            });

        if ($status !== '') {
            $student->where('status', $status);
        }

        $student = $student->orderBy('created_at', 'desc')
            ->paginate(5)
            ->through(function ($item) {
                $statusText = $item->status == 1 ? '正常' : '停權';
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'user_role' => $item->user_role,
                    'email' => $item->email,
                    'status' => $statusText,
                    'created_at' => $item->created_at->format('Y/m/d H:i'),
                ];
            });

        $data = (object) [
            'keyword' => $keyword,
            'student' => $student,
        ];

        return Inertia::render('Backend/StudentManage', ['response' => rtFormat($data)]);
    }
    public function studentUpdate(Request $request)
    {
        $student = User::find($request->id);
        // dd($student->status);
        if ($student) {
            $newStatus = $student->status == 1 ? 0 : 1;
            $student->status = $newStatus;
            $student->save();
            return back();
        }
    }

    public function presenterManage(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $status = $request->input('status', ''); // 获取状态筛选条件

        $presenter = User::where('user_role', 2)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%")
                    ->orWhere('created_at', 'like', "%$keyword%");
            });

        if ($status !== '') {
            $presenter->where('status', $status);
        }

        $presenter = $presenter->orderBy('created_at', 'desc')
            ->paginate(5)
            ->through(function ($item) {
                $statusText = $item->status == 1 ? '正常' : '停權';
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'user_role' => $item->user_role,
                    'email' => $item->email,
                    'status' => $statusText,
                    'created_at' => $item->created_at->format('Y/m/d H:i'),
                ];
            });

        $data = (object) [
            'keyword' => $keyword,
            'presenter' => $presenter,
        ];

        return Inertia::render('Backend/PresenterManage', ['response' => rtFormat($data)]);
    }

    public function presenterUpdate(Request $request)
    {
        $presenter = User::find($request->id);
        // dd($presenter->status);
        if ($presenter) {
            $newStatus = $presenter->status == 1 ? 0 : 1;
            $presenter->status = $newStatus;
            $presenter->save();
            return back();
        }
    }

    public function activityUpdate(Request $request)
    {
        $activity = ActivityDetail::find($request->id);
        // dd($activity->activity_status);

        if ($activity) {
            $newStatus = ($activity->activity_status == 1) ? 2 : 1;
            $activity->activity_status = $newStatus;
            $activity->save();
            return back();
        }
    }

    public function activityManage(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $status = $request->input('status', '');

        $activity = ActivityDetail::where(function ($query) use ($keyword) {
            $query->where('activity_presenter', 'like', "%$keyword%")
                ->orwhere('activity_name', 'like', "%$keyword%")
                ->orwhere('activity_start_time', 'like', "%$keyword%")
                ->orwhere('activity_end_time', 'like', "%$keyword%")
                ->orwhere('activity_type', 'like', "%$keyword%")
                ->orwhere('activity_address', 'like', "%$keyword%");
        });

        // 如果提供了状态筛选条件，则添加状态筛选
        if ($status !== '') {
            $activity->where('activity_status', $status);
        }

        $activity = $activity->orderBy('created_at', 'desc')
            ->paginate(5)
            ->through(function ($item) {
                $statusText = $item->activity_status == 1 ? '正常' : '停權';
                return [
                    'id' => $item->id,
                    'activity_presenter' => $item->activity_presenter,
                    // 活動類型代號
                    'activity_type' => $item->activity_type,
                    // 活動類型名稱
                    'activity_type_name' => $this->activityPresenter->getActivityTypeName($item->activity_type),
                    'activity_name' => $item->activity_name,
                    'activity_type' => $item->activity_type,
                    'activity_address' => $item->activity_address,
                    'activity_start_time' => $item->activity_start_time->format('Y/m/d H:i'),
                    'activity_end_time' => $item->activity_end_time->format('Y/m/d H:i'),
                    'activity_status' => $statusText,
                ];
            });

        $data = (object) [
            'keyword' => $keyword,
            'activity' => $activity,
        ];

        return Inertia::render('Backend/ActivityManage', ['response' => rtFormat($data)]);
    }
}
