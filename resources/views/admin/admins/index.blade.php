<x-app-layout>
<style>
    .filter-btn { transition: all 0.2s; border-radius: 20px; padding: 5px 16px; font-size: 0.82rem; font-weight: 600; }
    .btn-warning:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(255,193,7,0.4); }
    .btn-danger:hover  { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220,53,69,0.4); }
</style>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">
                    <i class="fas fa-user-shield me-2" style="color:#e94560;"></i>Admin Accounts
                </h2>
                <p class="text-muted">Manage administrator accounts</p>
            </div>
            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Admin
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Admins Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i>All Administrators</span>
            <span class="badge" style="background-color:#0f3460;">{{ $admins->count() }} admins</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold">{{ $admin->name }}</div>
                                @if($admin->id === Auth::id())
                                    <small class="text-muted">(You)</small>
                                @endif
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-secondary">Active User</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-user-shield fa-2x mb-2 d-block" style="color:#0f3460;"></i>
                                No admin accounts found.
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
