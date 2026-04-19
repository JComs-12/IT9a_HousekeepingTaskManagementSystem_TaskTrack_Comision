<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $staffId = Auth::user()->staff_id;

        $totalTasks = Task::whereHas('staff', function ($q) use ($staffId) {
            $q->where('staff.id', $staffId);
        })->count();

        $pendingTasks = Task::whereHas('staff', function ($q) use ($staffId) {
            $q->where('staff.id', $staffId);
        })->where('status', 'pending')->count();

        $inProgressTasks = Task::whereHas('staff', function ($q) use ($staffId) {
            $q->where('staff.id', $staffId);
        })->where('status', 'in_progress')->count();

        $completedTasks = Task::whereHas('staff', function ($q) use ($staffId) {
            $q->where('staff.id', $staffId);
        })->where('status', 'completed')->count();

        $recentTasks = Task::with(['room', 'staff'])
            ->whereHas('staff', function ($q) use ($staffId) {
                $q->where('staff.id', $staffId);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('staff.dashboard.index', compact(
            'totalTasks',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'recentTasks'
        ));
    }
}