<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffTaskController extends Controller
{
    public function index()
    {
        $staffId = Auth::user()->staff_id;

        $tasks = Task::with(['room', 'staff'])
            ->whereHas('staff', function ($q) use ($staffId) {
                $q->where('staff.id', $staffId);
            })
            ->latest()
            ->get();

        return view('staff.tasks.index', compact('tasks'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $staffId = Auth::user()->staff_id;
        $isAssigned = $task->staff()->where('staff.id', $staffId)->exists();

        if (!$isAssigned) {
            return redirect()->back()
                ->with('error', 'Unauthorized action!');
        }

        $task->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Task status updated!');
    }
}