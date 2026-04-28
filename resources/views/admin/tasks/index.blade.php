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
                                        <th>Staff</th>
                                        <th>Priority</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
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
                                            @if($task->status == 'in_progress')
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
                                            <!-- Delete triggers modal -->
                                            <button type="button" class="btn btn-sm btn-danger"
                                                    data-task-id="{{ $task->id }}"
                                                    data-task-name="{{ $task->task_name }}"
                                                    onclick="confirmDelete(this)">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            No active tasks found!
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
                                        <th>Staff</th>
                                        <th>Priority</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
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
                                            <span class="badge bg-success">Completed</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                               class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <!-- Delete triggers modal -->
                                            <button type="button" class="btn btn-sm btn-danger"
                                                    data-task-id="{{ $task->id }}"
                                                    data-task-name="{{ $task->task_name }}"
                                                    onclick="confirmDelete(this)">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            No completed tasks yet.
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

<!-- Hidden delete forms (one per task) -->
@foreach($tasks as $task)
<form id="delete-form-{{ $task->id }}"
      action="{{ route('admin.tasks.destroy', ['task' => $task->id]) }}"
      method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endforeach

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="background-color:#16213e; border:1px solid #0f3460;">
            <div class="modal-header" style="border-bottom:1px solid #0f3460;">
                <h6 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2" style="color:#e94560;"></i>
                    Confirm Delete
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="color:#aaaaaa; font-size:0.9rem; margin-bottom:0;">
                    Are you sure you want to delete <strong id="deleteItemName" style="color:#ffffff;"></strong>?
                    This cannot be undone.
                </p>
            </div>
            <div class="modal-footer" style="border-top:1px solid #0f3460;">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteBtn">
                    <i class="fas fa-trash me-1"></i>Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let pendingDeleteId = null;

    function confirmDelete(button) {
        pendingDeleteId = button.dataset.taskId;
        document.getElementById('deleteItemName').textContent = button.dataset.taskName || 'this task';
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (pendingDeleteId) {
            const form = document.getElementById('delete-form-' + pendingDeleteId);
            if (form) {
                form.submit();
            }
        }
    });
</script>
    </div>
</x-app-layout>