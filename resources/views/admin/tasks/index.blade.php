<x-app-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">
                        <i class="fas fa-tasks me-2" style="color: #e94560;"></i>
                        Tasks
                    </h2>
                    <p class="text-muted">Manage all housekeeping tasks</p>
                </div>
                <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Task
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>All Tasks
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task Name</th>
                                <th>Room</th>
                                <th>Staff</th>
                                <th>Priority</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @php $taskNames = explode(', ', $task->task_name); @endphp
                                    @if(count($taskNames) > 1)
                                        <div class="dropdown">
                                            <button class="btn btn-sm dropdown-toggle w-100 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #1a1a2e; color: #ffffff; border: 1px solid #1a4a8a;">
                                                <i class="fas fa-list-ul me-1" style="color: #e94560;"></i> {{ count($taskNames) }} Tasks
                                            </button>
                                            <ul class="dropdown-menu shadow" style="background-color: #16213e; border: 1px solid #0f3460;">
                                                @foreach($taskNames as $tName)
                                                    <li class="dropdown-item px-3 py-1 text-white" style="background: transparent;">
                                                        <i class="fas fa-check me-2" style="color: #e94560; font-size: 0.8em;"></i>{{ $tName }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        {{ $task->task_name }}
                                    @endif
                                </td>
                                <td>Room {{ $task->room->room_number }}</td>
                                <td>
                                    @if($task->staff->count() > 1)
                                        <div class="dropdown">
                                            <button class="btn btn-sm dropdown-toggle w-100 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #1a1a2e; color: #ffffff; border: 1px solid #1a4a8a;">
                                                <i class="fas fa-users me-1" style="color: #e94560;"></i> {{ $task->staff->count() }} Staff
                                            </button>
                                            <ul class="dropdown-menu shadow" style="background-color: #16213e; border: 1px solid #0f3460;">
                                                @foreach($task->staff as $member)
                                                    <li class="dropdown-item px-3 py-1 text-white" style="background: transparent;">
                                                        <i class="fas fa-user me-2" style="color: #e94560; font-size: 0.8em;"></i>{{ $member->name }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @elseif($task->staff->count() == 1)
                                        <i class="fas fa-user me-1 text-muted" style="font-size: 0.8em;"></i>{{ $task->staff->first()->name }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($task->priority == 'high')
                                        <span class="badge bg-danger">High</span>
                                    @elseif($task->priority == 'medium')
                                        <span class="badge bg-warning">Medium</span>
                                    @else
                                        <span class="badge bg-success">Low</span>
                                    @endif
                                </td>
                                <td>{{ $task->due_date }}</td>
                                <td>
                                    @if($task->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($task->status == 'in_progress')
                                        <span class="badge bg-info">In Progress</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.tasks.destroy', $task->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    No tasks found! Click "Add Task" to get started.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>