<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Room;
use App\Models\Staff;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::count();
        $totalStaff = Staff::count();
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();

        return view('admin.dashboard.index', compact(
            'totalRooms',
            'totalStaff',
            'totalTasks',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks'
        ));
    }

    public function reports()
    {
        $tasks = Task::with(['room', 'staff'])->get();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();

        return view('admin.dashboard.reports', compact(
            'tasks',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks'
        ));
    }
}