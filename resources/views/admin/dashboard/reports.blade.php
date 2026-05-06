<x-app-layout>
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-chart-bar me-2" style="color: #e94560;"></i>
                    Reports
                </h2>
                <p class="text-muted">Overview of all tasks and their status</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <i class="fas fa-clock fa-2x mb-2" style="color: #ffc107;"></i>
                    <h3 class="fw-bold">{{ $pendingTasks }}</h3>
                    <p class="text-muted mb-0">Pending Tasks</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <i class="fas fa-spinner fa-2x mb-2" style="color: #0dcaf0;"></i>
                    <h3 class="fw-bold">{{ $inProgressTasks }}</h3>
                    <p class="text-muted mb-0">In Progress Tasks</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <i class="fas fa-check-circle fa-2x mb-2" style="color: #198754;"></i>
                    <h3 class="fw-bold">{{ $completedTasks }}</h3>
                    <p class="text-muted mb-0">Completed Tasks</p>
                </div>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-list me-2"></i>All Tasks Report
                </div>
                @if(count($tasks) > 0)
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-secondary" id="selectAllBtn">
                            <i class="fas fa-check-square me-1"></i>Select All
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" id="deleteSelectedBtn" disabled>
                            <i class="fas fa-trash me-1"></i>Delete Selected
                        </button>
                        <span class="badge bg-info text-dark align-self-center" id="selectedCountBadge" style="display:none; font-size:0.9rem;">
                            0 selected
                        </span>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>
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
                                <td>
                                    <input type="checkbox" class="form-check-input task-checkbox" data-task-id="{{ $task->id }}" style="cursor: pointer;">
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->task_name }}</td>
                                <td>Room {{ $task->room->room_number }}</td>
                                <td>{{ $task->staff->pluck('name')->implode(', ') ?: '—' }}</td>
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
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteTask({{ $task->id }})">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">
                                    No tasks found!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Delete Selected Confirmation Modal -->
    <div class="modal fade" id="deleteTasksModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" style="background-color:#16213e; border:1px solid #0f3460;">
                <div class="modal-header" style="border-bottom:1px solid #0f3460;">
                    <h6 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2" style="color:#e94560;"></i>Delete Tasks
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p style="color:#aaaaaa; font-size:0.9rem; margin-bottom:0;">
                        Are you sure you want to delete <strong id="tasksCount" style="color:#ffffff;">0</strong> selected task(s)? This cannot be undone.
                    </p>
                </div>
                <div class="modal-footer" style="border-top:1px solid #0f3460;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteTasksBtn">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const taskCheckboxes = document.querySelectorAll('.task-checkbox');
            const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const selectedCountBadge = document.getElementById('selectedCountBadge');
            const deleteTasksModal = new bootstrap.Modal(document.getElementById('deleteTasksModal'));
            const confirmDeleteTasksBtn = document.getElementById('confirmDeleteTasksBtn');

            function updateSelectedCount() {
                const checkedCount = document.querySelectorAll('.task-checkbox:checked').length;
                const totalCount = taskCheckboxes.length;

                if (selectedCountBadge) {
                    selectedCountBadge.style.display = checkedCount > 0 ? 'inline-flex' : 'none';
                    selectedCountBadge.textContent = `${checkedCount} selected`;
                }

                if (deleteSelectedBtn) {
                    deleteSelectedBtn.disabled = checkedCount === 0;
                }

                if (selectAllBtn) {
                    if (checkedCount === totalCount && totalCount > 0) {
                        selectAllBtn.classList.remove('btn-secondary');
                        selectAllBtn.classList.add('btn-success');
                    } else {
                        selectAllBtn.classList.remove('btn-success');
                        selectAllBtn.classList.add('btn-secondary');
                    }
                }
            }

            taskCheckboxes.forEach(cb => cb.addEventListener('change', updateSelectedCount));

            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function() {
                    const allChecked = Array.from(taskCheckboxes).every(cb => cb.checked);
                    taskCheckboxes.forEach(cb => cb.checked = !allChecked);
                    updateSelectedCount();
                });
            }

            if (deleteSelectedBtn) {
                deleteSelectedBtn.addEventListener('click', function() {
                    const count = document.querySelectorAll('.task-checkbox:checked').length;
                    document.getElementById('tasksCount').textContent = count;
                    deleteTasksModal.show();
                });
            }

            if (confirmDeleteTasksBtn) {
                confirmDeleteTasksBtn.addEventListener('click', function() {
                    const selectedIds = Array.from(document.querySelectorAll('.task-checkbox:checked'))
                        .map(cb => cb.dataset.taskId);

                    if (selectedIds.length > 0) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/admin/tasks/delete-selected';
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                        form.innerHTML = `
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            ${selectedIds.map(id => `<input type="hidden" name="ids[]" value="${id}">`).join('')}
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

            updateSelectedCount();
        });

        function deleteTask(taskId) {
            if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/admin/tasks/' + taskId;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                form.innerHTML = `
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="_method" value="DELETE">
                `;

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-app-layout>