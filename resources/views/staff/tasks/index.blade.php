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
                                                  method="POST"
                                                  id="statusForm-{{ $task->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status"
                                                        class="form-select form-select-sm status-select"
                                                        data-task-id="{{ $task->id }}"
                                                        data-task-name="{{ $task->task_name }}"
                                                        data-current-status="{{ $task->status }}"
                                                        style="width: auto;">
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
                                            <button type="button" class="btn btn-sm btn-danger"
                                                    data-task-id="{{ $task->id }}"
                                                    data-task-name="{{ $task->task_name }}"
                                                    onclick="confirmDeleteTask(this)">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
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

    @foreach($completedTasks as $task)
        <form id="delete-task-form-{{ $task->id }}"
              action="{{ route('staff.tasks.destroy', $task->id) }}"
              method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endforeach

    <!-- Delete Completed Task Modal -->
    <div class="modal fade" id="deleteTaskModal" tabindex="-1">
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
                        Are you sure you want to remove the completed task
                        <strong id="deleteTaskName" style="color:#ffffff;"></strong>?
                        This will clear it from your completed tasks list.
                    </p>
                </div>
                <div class="modal-footer" style="border-top:1px solid #0f3460;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteTaskBtn">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Status Confirmation Modal -->
    <div class="modal fade" id="statusConfirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" style="background-color:#16213e; border:1px solid #0f3460;">
                <div class="modal-header" style="border-bottom:1px solid #0f3460;">
                    <h6 class="modal-title">
                        <i class="fas fa-check-circle me-2" style="color:#10b981;"></i>
                        <span id="confirmTitle">Confirm Status Change</span>
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p style="color:#aaaaaa; font-size:0.9rem; margin-bottom:15px;" id="confirmMessage">
                        Are you sure you want to change the task status?
                    </p>
                    <div style="background: rgba(233,69,96,0.1); border-left: 3px solid #e94560; padding: 12px; border-radius: 5px;">
                        <small style="color:#ffffff;">
                            <i class="fas fa-info-circle me-2" style="color:#e94560;"></i>
                            <span id="taskDetail"></span>
                        </small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #0f3460;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id="confirmStatusBtn">
                        <i class="fas fa-check me-1"></i>Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let pendingStatusChange = null;

        // Handle status select change
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function(e) {
                const newStatus = this.value;
                const currentStatus = this.dataset.currentStatus;
                const taskId = this.dataset.taskId;
                const taskName = this.dataset.taskName;
                const form = document.getElementById('statusForm-' + taskId);

                // If changing to completed, show confirmation
                if (newStatus === 'completed') {
                    pendingStatusChange = {
                        taskId: taskId,
                        taskName: taskName,
                        newStatus: newStatus,
                        form: form,
                        select: this
                    };

                    // Update modal content
                    document.getElementById('confirmTitle').innerHTML = '<i class="fas fa-check-circle me-2" style="color:#10b981;"></i>Complete Task?';
                    document.getElementById('confirmMessage').innerHTML = 
                        'Are you sure you want to mark <strong style="color:#ffffff;">' + taskName + '</strong> as completed? This action cannot be undone.';
                    document.getElementById('taskDetail').innerHTML = 
                        '<strong>Task:</strong> ' + taskName + '<br><strong>Action:</strong> Changing to Completed';

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('statusConfirmModal'));
                    modal.show();
                } else {
                    // For other status changes, submit immediately
                    form.submit();
                }
            });
        });

        // Handle confirmation button
        document.getElementById('confirmStatusBtn').addEventListener('click', function() {
            if (pendingStatusChange) {
                const form = pendingStatusChange.form;
                
                // Hide modal
                const modalElement = document.getElementById('statusConfirmModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }

                // Submit form
                setTimeout(() => {
                    form.submit();
                }, 300);
            }
        });

        // Delete completed task handlers
        let pendingDeleteTaskId = null;

        function confirmDeleteTask(button) {
            pendingDeleteTaskId = button.dataset.taskId;
            document.getElementById('deleteTaskName').textContent = button.dataset.taskName || 'this task';
            new bootstrap.Modal(document.getElementById('deleteTaskModal')).show();
        }

        document.getElementById('confirmDeleteTaskBtn').addEventListener('click', function() {
            if (pendingDeleteTaskId) {
                const form = document.getElementById('delete-task-form-' + pendingDeleteTaskId);
                if (form) {
                    form.submit();
                }
            }
        });

        // Reset pending change when modal is closed
        document.getElementById('statusConfirmModal').addEventListener('hidden.bs.modal', function() {
            if (pendingStatusChange && pendingStatusChange.select) {
                // Reset select to current value
                pendingStatusChange.select.value = pendingStatusChange.select.dataset.currentStatus;
            }
            pendingStatusChange = null;
        });
    </script>
</x-staff-layout>