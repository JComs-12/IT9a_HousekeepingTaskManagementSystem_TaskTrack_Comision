<x-app-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">
                        <i class="fas fa-flag me-2" style="color: #e94560;"></i>
                        Staff Reports
                    </h2>
                    <p class="text-muted">Review incidents reported by staff</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-list me-2"></i>All Reports</span>
                @if(count($reports) > 0)
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>
                                <th>#</th>
                                <th>Staff</th>
                                <th>Room</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr data-report-id="{{ $report->id }}">
                                    <td>
                                        <input type="checkbox" class="form-check-input report-checkbox" data-report-id="{{ $report->id }}" style="cursor: pointer;">
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $report->staff ? $report->staff->name : 'N/A' }}</td>
                                    <td>
                                        @if($report->room)
                                            Room {{ $report->room->room_number }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-capitalize">{{ $report->report_type }}</td>
                                    <td style="max-width: 420px;">
                                        {{ \Illuminate\Support\Str::limit($report->description, 140) }}
                                    </td>
                                    <td>
                                        @if($report->status === 'resolved')
                                            <span class="badge bg-success">Resolved</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if($report->status === 'pending')
                                            <form action="{{ route('admin.staff-reports.update', $report->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="resolved">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check me-1"></i>Resolve
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-danger ms-1" onclick="deleteReport({{ $report->id }})">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        No staff reports yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteReportsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" style="background-color:#16213e; border:1px solid #0f3460;">
                <div class="modal-header" style="border-bottom:1px solid #0f3460;">
                    <h6 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2" style="color:#e94560;"></i>Delete Reports
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p style="color:#aaaaaa; font-size:0.9rem; margin-bottom:0;">
                        Are you sure you want to delete <strong id="reportsCount" style="color:#ffffff;">0</strong> report(s)? This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer" style="border-top:1px solid #0f3460;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteReportsBtn">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reportCheckboxes = document.querySelectorAll('.report-checkbox');
            const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const deleteReportsModal = new bootstrap.Modal(document.getElementById('deleteReportsModal'));
            const confirmDeleteReportsBtn = document.getElementById('confirmDeleteReportsBtn');

            function updateDeleteButton() {
                const checkedCount = document.querySelectorAll('.report-checkbox:checked').length;
                const totalCount = reportCheckboxes.length;
                
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

            reportCheckboxes.forEach(cb => cb.addEventListener('change', updateDeleteButton));

            if (deleteSelectedBtn) {
                deleteSelectedBtn.addEventListener('click', function() {
                    const count = document.querySelectorAll('.report-checkbox:checked').length;
                    document.getElementById('reportsCount').textContent = count;
                    deleteReportsModal.show();
                });
            }

            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function() {
                    const allChecked = Array.from(reportCheckboxes).every(cb => cb.checked);
                    reportCheckboxes.forEach(cb => cb.checked = !allChecked);
                    updateDeleteButton();
                });
            }

            if (confirmDeleteReportsBtn) {
                confirmDeleteReportsBtn.addEventListener('click', function() {
                    const selectedIds = Array.from(document.querySelectorAll('.report-checkbox:checked'))
                        .map(cb => cb.dataset.reportId);

                    if (selectedIds.length > 0) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/admin/staff-reports/delete-selected';

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

        function deleteReport(reportId) {
            if (confirm('Are you sure you want to delete this staff report? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/admin/staff-reports/' + reportId;

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
