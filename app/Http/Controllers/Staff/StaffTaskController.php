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

        // Mark NewTaskAssigned notifications as read
        Auth::user()->unreadNotifications->where('type', 'App\Notifications\NewTaskAssigned')->markAsRead();

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

        if ($task->status === 'completed') {
            return redirect()->back()
                ->with('error', 'Completed tasks cannot be modified!');
        }

        $task->update(['status' => $request->status]);

        \App\Models\ActivityLog::create([
            'user_id'      => Auth::id(),
            'role'         => 'staff',
            'action'       => 'Task Status Updated',
            'description'  => "Staff " . Auth::user()->name . " updated task \"{$task->task_name}\" status to {$request->status}.",
            'subject_type' => 'Task',
            'subject_id'   => $task->id,
        ]);

        if ($request->status === 'completed') {
            $admins = \App\Models\User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\TaskCompleted($task));
            }
        }

        return redirect()->back()
            ->with('success', 'Task status updated!');
    }

    public function destroy(Task $task)
    {
        $staffId = Auth::user()->staff_id;
        $isAssigned = $task->staff()->where('staff.id', $staffId)->exists();

        if (!$isAssigned) {
            return redirect()->back()->with('error', 'Unauthorized action!');
        }

        if ($task->status !== 'completed') {
            return redirect()->back()->with('error', 'Only completed tasks can be deleted.');
        }

        $taskName = $task->task_name;
        $task->staff()->detach();
        $task->delete();

        \App\Models\ActivityLog::create([
            'user_id'      => Auth::id(),
            'role'         => 'staff',
            'action'       => 'Completed Task Deleted',
            'description'  => "Staff " . Auth::user()->name . " deleted completed task \"{$taskName}\".",
            'subject_type' => 'Task',
            'subject_id'   => null,
        ]);

        return redirect()->back()->with('success', 'Completed task removed successfully.');
    }
}
