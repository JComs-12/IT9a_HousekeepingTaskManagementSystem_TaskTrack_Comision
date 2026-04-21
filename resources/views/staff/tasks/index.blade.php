<x-staff-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-tasks me-2" style="color: #e94560;"></i>
                    My Tasks
                </h2>
                <p class="text-muted">View and update your assigned tasks</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="tasksTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab" aria-controls="active" aria-selected="true">
                            <i class="fas fa-list me-2"></i>Active Tasks
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">
                            <i class="fas fa-check-circle me-2"></i>Completed Tasks
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                @php
                    $activeTasks = $tasks->where('status', '!=', 'completed');
                    $completedTasks = $tasks->where('status', 'completed');
                @endphp
                <div class="tab-content" id="tasksTabContent">
                    <!-- Active Tasks Tab -->
                    <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Task Name</th>
                                        <th>Room</th>
                                        <th>Team Members</th>
                                        <th>Priority</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activeTasks as $task)
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
                                            @php
                                                $teamMembers = \App\Models\Task::with('staff')
                                                    ->where('room_id', $task->room_id)
                                                    ->where('id', '!=', $task->id)
                                                    ->get()
                                                    ->pluck('staff.name')
                                                    ->unique()
                                                    ->filter();
                                            @endphp
                                            @if($teamMembers->count() > 1)
                                                <div class="dropdown">
                                                    <button class="btn btn-sm dropdown-toggle w-100 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #1a1a2e; color: #ffffff; border: 1px solid #1a4a8a;">
                                                        <i class="fas fa-users me-1" style="color: #e94560;"></i> {{ $teamMembers->count() }} Members
                                                    </button>
                                                    <ul class="dropdown-menu shadow" style="background-color: #16213e; border: 1px solid #0f3460;">
                                                        @foreach($teamMembers as $member)
                                                            <li class="dropdown-item px-3 py-1 text-white" style="background: transparent;">
                                                                <i class="fas fa-user me-2" style="color: #e94560; font-size: 0.8em;"></i>{{ $member }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @elseif($teamMembers->count() == 1)
                                                <i class="fas fa-user me-1 text-muted" style="font-size: 0.8em;"></i>{{ $teamMembers->first() }}
                                            @else
                                                <span class="text-muted">Solo</span>
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
                                            @if($task->status == 'in_progress')
                                                <span class="badge bg-info">In Progress</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('staff.tasks.updateStatus', $task->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status"
                                                        class="form-select form-select-sm"
                                                        style="width: auto;"
                                                        onchange="if(this.value === 'completed') { if(confirm('Are you sure the tasks are complete? This action cannot be undone.')) { this.form.submit(); } else { this.value = '{{ $task->status }}'; return false; } } else { this.form.submit(); }">
                                                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>
                                                        Pending
                                                    </option>
                                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>
                                                        In Progress
                                                    </option>
                                                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>
                                                        Completed
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            No active tasks assigned to you yet!
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Completed Tasks Tab -->
                    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Task Name</th>
                                        <th>Room</th>
                                        <th>Team Members</th>
                                        <th>Priority</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($completedTasks as $task)
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
                                            @php
                                                $teamMembers = \App\Models\Task::with('staff')
                                                    ->where('room_id', $task->room_id)
                                                    ->where('id', '!=', $task->id)
                                                    ->get()
                                                    ->pluck('staff.name')
                                                    ->unique()
                                                    ->filter();
                                            @endphp
                                            @if($teamMembers->count() > 1)
                                                <div class="dropdown">
                                                    <button class="btn btn-sm dropdown-toggle w-100 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #1a1a2e; color: #ffffff; border: 1px solid #1a4a8a;">
                                                        <i class="fas fa-users me-1" style="color: #e94560;"></i> {{ $teamMembers->count() }} Members
                                                    </button>
                                                    <ul class="dropdown-menu shadow" style="background-color: #16213e; border: 1px solid #0f3460;">
                                                        @foreach($teamMembers as $member)
                                                            <li class="dropdown-item px-3 py-1 text-white" style="background: transparent;">
                                                                <i class="fas fa-user me-2" style="color: #e94560; font-size: 0.8em;"></i>{{ $member }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @elseif($teamMembers->count() == 1)
                                                <i class="fas fa-user me-1 text-muted" style="font-size: 0.8em;"></i>{{ $teamMembers->first() }}
                                            @else
                                                <span class="text-muted">Solo</span>
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
                                            <span class="badge bg-success">Completed</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Done</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            No completed tasks assigned to you yet.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-staff-layout>