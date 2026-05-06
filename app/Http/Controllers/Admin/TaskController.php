<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Task;
use App\Models\Room;
use App\Models\Staff;
use App\Models\ActivityLog;
use App\Models\User;
use App\Notifications\NewTaskAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['room', 'staff'])->latest();

        // Mark TaskCompleted notifications as read
        Auth::user()->unreadNotifications->where('type', 'App\Notifications\TaskCompleted')->markAsRead();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('task_name', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('priority', 'like', "%{$search}%")
                  ->orWhereHas('room', fn($r) => $r->where('room_number', 'like', "%{$search}%"))
                  ->orWhereHas('staff', fn($s) => $s->where('name', 'like', "%{$search}%"));
            });
        }

        $tasks = $query->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $rooms = Room::latest()->get();
        $staff = Staff::where('status', 'active')->get();
        return view('admin.tasks.create', compact('rooms', 'staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id'     => 'required|exists:rooms,id',
            'staff_ids'   => 'required|array|min:1',
            'staff_ids.*' => 'exists:staff,id',
            'task_name'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'required|date',
            'status'      => 'required|in:pending,in_progress,completed',
        ]);

        $task = Task::create([
            'room_id'     => $request->room_id,
            'task_name'   => $request->task_name,
            'description' => $request->description,
            'priority'    => $request->priority,
            'due_date'    => $request->due_date,
            'status'      => $request->status,
        ]);

        $task->staff()->sync($request->staff_ids);

        $staffNames = Staff::whereIn('id', $request->staff_ids)->pluck('name')->implode(', ');
        $room = Room::find($request->room_id);

        ActivityLog::create([
            'user_id'      => Auth::id(),
            'role'         => 'admin',
            'action'       => 'Task Created',
            'description'  => "Task \"{$task->task_name}\" created for Room {$room->room_number} — assigned to: {$staffNames}",
            'subject_type' => 'Task',
            'subject_id'   => $task->id,
        ]);

        // Notify assigned staff
        $staffUsers = User::whereIn('staff_id', $request->staff_ids)->get();
        foreach ($staffUsers as $user) {
            $user->notify(new NewTaskAssigned($task));
        }

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task assigned successfully!');
    }

    public function edit(Task $task)
    {
        $rooms = Room::all();
        $staff = Staff::where('status', 'active')->get();
        $assignedStaffIds = $task->staff->pluck('id')->toArray();
        return view('admin.tasks.edit', compact('task', 'rooms', 'staff', 'assignedStaffIds'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'room_id'     => 'required|exists:rooms,id',
            'staff_ids'   => 'required|array|min:1',
            'staff_ids.*' => 'exists:staff,id',
            'task_name'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'required|date',
            'status'      => 'required|in:pending,in_progress,completed',
        ]);

        $oldStatus = $task->status;

        if ($oldStatus === 'completed') {
            $request->validate([
                'modification_reason' => 'required|string|min:5',
            ]);
        }

        $task->update([
            'room_id'     => $request->room_id,
            'task_name'   => $request->task_name,
            'description' => $request->description,
            'priority'    => $request->priority,
            'due_date'    => $request->due_date,
            'status'      => $request->status,
        ]);

        $task->staff()->sync($request->staff_ids);

        $staffNames = Staff::whereIn('id', $request->staff_ids)->pluck('name')->implode(', ');
        $room = Room::find($request->room_id);
        $statusChanged = $oldStatus !== $request->status
            ? " (status: {$oldStatus} → {$request->status})"
            : '';

        $reasonText = $request->filled('modification_reason') 
            ? " | Reason: {$request->modification_reason}" 
            : '';

        ActivityLog::create([
            'user_id'      => Auth::id(),
            'role'         => 'admin',
            'action'       => 'Task Updated',
            'description'  => "Task \"{$task->task_name}\" updated for Room {$room->room_number}{$statusChanged} — staff: {$staffNames}{$reasonText}",
            'subject_type' => 'Task',
            'subject_id'   => $task->id,
        ]);

        if ($oldStatus === 'completed' && $request->status !== 'completed') {
            $assignedStaffUsers = User::whereIn('staff_id', $request->staff_ids)->get();
            foreach ($assignedStaffUsers as $user) {
                $user->notify(new NewTaskAssigned($task));
            }
        }

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $name = $task->task_name;
        $task->delete();

        ActivityLog::create([
            'user_id'      => Auth::id(),
            'role'         => 'admin',
            'action'       => 'Task Deleted',
            'description'  => "Task \"{$name}\" was deleted.",
            'subject_type' => 'Task',
            'subject_id'   => null,
        ]);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task deleted successfully!');
    }

    public function deleteSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:tasks,id',
        ]);

        $taskIds = $request->ids;
        $tasks = Task::whereIn('id', $taskIds)->get();
        $deletedNames = $tasks->pluck('task_name')->implode(', ');

        Task::whereIn('id', $taskIds)->delete();

        ActivityLog::create([
            'user_id'      => Auth::id(),
            'role'         => 'admin',
            'action'       => 'Tasks Deleted',
            'description'  => "Deleted tasks: {$deletedNames}",
            'subject_type' => 'Task',
            'subject_id'   => null,
        ]);

        return redirect()->route('reports.index')
            ->with('success', 'Selected tasks deleted successfully.');
    }
}
