<x-app-layout>
    @section('page-title', 'System Activity Logs')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-history me-2"></i>All System Activity</span>
            @if(count($logs) > 0)
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-secondary" id="selectAllBtn">
                        <i class="fas fa-check-square me-1"></i>Select All
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" id="deleteSelectedBtn" disabled>
                        <i class="fas fa-trash me-1"></i>Delete Selected
                    </button>
                </div>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Date / Time</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr data-log-id="{{ $log->id }}" @if($log->is_important) style="background-color: rgba(255, 193, 7, 0.1); border-left: 4px solid #ffc107;" @endif>
                                <td>
                                    <input type="checkbox" class="form-check-input log-checkbox" data-log-id="{{ $log->id }}" style="cursor: pointer;">
                                </td>
                                <td>
                                    <div style="font-size: 0.9rem;">
                                        @if($log->is_important)
                                            <i class="fas fa-star" style="color: #ffc107; margin-right: 5px;" title="Important Action"></i>
                                        @endif
                                        {{ $log->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.8rem;">{{ $log->created_at->format('h:i A') }}</div>
                                </td>
                                <td>
                                    @if($log->user)
                                        <div class="fw-bold">{{ $log->user->name }}</div>
                                        <div class="text-muted" style="font-size: 0.8rem;">{{ $log->user->email }}</div>
                                    @else
                                        <span class="text-muted">System / Deleted</span>
                                    @endif
                                </td>
                                <td>
                                    @if($log->role === 'admin')
                                        <span class="badge bg-primary">Admin</span>
                                    @else
                                        <span class="badge bg-secondary">Staff</span>
                                    @endif
                                </td>
                                <td>
                                    @if($log->is_important)
                                        <span class="badge bg-warning text-dark" title="Important Action">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $log->action }}
                                        </span>
                                    @else
                                        <span class="badge bg-info text-dark">{{ $log->action }}</span>
                                    @endif
                                </td>
                                <td>{{ $log->description }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="deleteLog({{ $log->id }})">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox fa-3x mb-3" style="opacity: 0.5;"></i>
                                    <p>No activity logs found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteLogsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" style="background-color:#16213e; border:1px solid #0f3460;">
                <div class="modal-header" style="border-bottom:1px solid #0f3460;">
                    <h6 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2" style="color:#e94560;"></i>Delete Logs
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p style="color:#aaaaaa; font-size:0.9rem; margin-bottom:0;">
                        Are you sure you want to delete <strong id="logsCount" style="color:#ffffff;">0</strong> log(s)? This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer" style="border-top:1px solid #0f3460;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteLogsBtn">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logCheckboxes = document.querySelectorAll('.log-checkbox');
            const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const deleteLogsModal = new bootstrap.Modal(document.getElementById('deleteLogsModal'));
            const confirmDeleteLogsBtn = document.getElementById('confirmDeleteLogsBtn');

            function updateDeleteButton() {
                const checkedCount = document.querySelectorAll('.log-checkbox:checked').length;
                const totalCount = logCheckboxes.length;
                
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

            logCheckboxes.forEach(cb => cb.addEventListener('change', updateDeleteButton));

            if (deleteSelectedBtn) {
                deleteSelectedBtn.addEventListener('click', function() {
                    const count = document.querySelectorAll('.log-checkbox:checked').length;
                    document.getElementById('logsCount').textContent = count;
                    deleteLogsModal.show();
                });
            }

            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function() {
                    const allChecked = Array.from(logCheckboxes).every(cb => cb.checked);
                    logCheckboxes.forEach(cb => cb.checked = !allChecked);
                    updateDeleteButton();
                });
            }

            if (confirmDeleteLogsBtn) {
                confirmDeleteLogsBtn.addEventListener('click', function() {
                    const selectedIds = Array.from(document.querySelectorAll('.log-checkbox:checked'))
                        .map(cb => cb.dataset.logId);

                    if (selectedIds.length > 0) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/admin/logs/delete-selected';

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

            updateDeleteButton();
        });

        function deleteLog(logId) {
            if (confirm('Are you sure you want to delete this log entry? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/admin/logs/' + logId;

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
