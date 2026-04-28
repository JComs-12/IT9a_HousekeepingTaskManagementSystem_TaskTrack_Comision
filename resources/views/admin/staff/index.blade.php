<x-app-layout>
<style>
    /* Hover effect on table rows */
    .table tbody tr { transition: background-color 0.2s, transform 0.1s; }
    .table tbody tr:hover td { background-color: #1e2d50 !important; cursor: default; }

    /* Filter buttons */
    .filter-btn { transition: all 0.2s; border-radius: 20px; padding: 5px 16px; font-size: 0.82rem; font-weight: 600; }
    .filter-btn.active-filter { background-color: #e94560 !important; border-color: #e94560 !important; color: #fff !important; }

    /* Search input */
    .search-wrapper { position: relative; }
    .search-wrapper .fas { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aaaaaa; }
    .search-wrapper input { padding-left: 36px; }

    /* Action buttons hover */
    .btn-warning:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(255,193,7,0.4); }
    .btn-danger:hover  { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220,53,69,0.4); }
    .btn-info:hover    { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(13,202,240,0.4); }
    .btn-primary:hover { transform: translateY(-1px); }
    .btn { transition: all 0.2s; }
</style>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">
                    <i class="fas fa-users me-2" style="color:#e94560;"></i>Staff
                </h2>
                <p class="text-muted">Manage all hotel staff</p>
            </div>
            <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Staff
            </a>
        </div>
    </div>

    <!-- Search + Filter Bar -->
    <div class="card mb-3">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.staff.index') }}" class="row g-2 align-items-center">
                <!-- Search -->
                <div class="col-md-5">
                    <div class="search-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="form-control"
                               placeholder="Search name, email, or phone…"
                               value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Status Filter Buttons -->
                <div class="col-md-5 d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.staff.index', array_merge(request()->except('status'), [])) }}"
                       class="btn btn-outline-secondary filter-btn {{ !request('status') ? 'active-filter' : '' }}">
                        All
                    </a>
                    <a href="{{ route('admin.staff.index', array_merge(request()->all(), ['status'=>'active'])) }}"
                       class="btn btn-outline-success filter-btn {{ request('status')=='active' ? 'active-filter' : '' }}">
                        <i class="fas fa-check-circle me-1"></i>Active
                    </a>
                    <a href="{{ route('admin.staff.index', array_merge(request()->all(), ['status'=>'inactive'])) }}"
                       class="btn btn-outline-danger filter-btn {{ request('status')=='inactive' ? 'active-filter' : '' }}">
                        <i class="fas fa-times-circle me-1"></i>Inactive
                    </a>
                </div>

                <!-- Search Submit -->
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i>Search
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Staff Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i>All Staff</span>
            <span class="badge" style="background-color:#0f3460;">{{ $staff->count() }} staff</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staff as $member)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $member->name }}</strong></td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>
                                @if($member->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.staff.show', $member->id) }}"
                                   class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <!-- Delete triggers modal -->
                                <button type="button" class="btn btn-sm btn-danger"
                                        data-member-id="{{ $member->id }}"
                                        data-member-name="{{ $member->name }}"
                                        onclick="confirmDelete(this)">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-2x mb-2 d-block" style="color:#0f3460;"></i>
                                No staff found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Hidden delete forms (one per staff) -->
@foreach($staff as $member)
<form id="delete-form-{{ $member->id }}"
      action="{{ route('admin.staff.destroy', ['staff' => $member->id]) }}"
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
        pendingDeleteId = button.dataset.memberId;
        document.getElementById('deleteItemName').textContent = button.dataset.memberName || 'this staff member';
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
</x-app-layout>