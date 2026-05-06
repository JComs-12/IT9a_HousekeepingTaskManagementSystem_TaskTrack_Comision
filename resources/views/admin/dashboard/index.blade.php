<x-app-layout>
<style>
    /* Stat card hover */
    .stat-card {
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        cursor: pointer;
    }
    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(233,69,96,0.25);
        border-color: #e94560 !important;
    }
    .stat-card:hover .card-icon { transform: scale(1.15); }
    .card-icon { transition: transform 0.22s ease; display: inline-block; }

    /* Quick action card hover */
    .action-card {
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
    }
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 28px rgba(233,69,96,0.2);
        border-color: #e94560 !important;
    }
    .action-card:hover .action-icon { color: #ffffff !important; }
    .action-icon { transition: color 0.2s; }

    /* Button hover already in global styles — just ensure they pop */
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(233,69,96,0.45); }
</style>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">
                <i class="fas fa-home me-2" style="color:#e94560;"></i>Dashboard
            </h2>
            <p class="text-muted">Welcome back, {{ Auth::user()->name }}! 👋</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center p-3 stat-card" onclick="window.location.href='{{ route('admin.rooms.index') }}'">
                <span class="card-icon"><i class="fas fa-door-open fa-2x mb-2" style="color:#e94560;"></i></span>
                <h3 class="fw-bold">{{ $totalRooms }}</h3>
                <p class="text-muted mb-0">Total Rooms</p>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center p-3 stat-card" onclick="window.location.href='{{ route('admin.staff.index') }}'">
                <span class="card-icon"><i class="fas fa-users fa-2x mb-2" style="color:#e94560;"></i></span>
                <h3 class="fw-bold">{{ $totalStaff }}</h3>
                <p class="text-muted mb-0">Total Staff</p>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center p-3 stat-card" onclick="window.location.href='{{ route('admin.tasks.index') }}'">
                <span class="card-icon"><i class="fas fa-tasks fa-2x mb-2" style="color:#e94560;"></i></span>
                <h3 class="fw-bold">{{ $totalTasks }}</h3>
                <p class="text-muted mb-0">Total Tasks</p>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center p-3 stat-card" onclick="window.location.href='{{ route('admin.tasks.index') }}'">
                <span class="card-icon"><i class="fas fa-clock fa-2x mb-2" style="color:#ffc107;"></i></span>
                <h3 class="fw-bold">{{ $pendingTasks }}</h3>
                <p class="text-muted mb-0">Pending</p>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center p-3 stat-card" onclick="window.location.href='{{ route('admin.tasks.index') }}'">
                <span class="card-icon"><i class="fas fa-spinner fa-2x mb-2" style="color:#0dcaf0;"></i></span>
                <h3 class="fw-bold">{{ $inProgressTasks }}</h3>
                <p class="text-muted mb-0">In Progress</p>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="card text-center p-3 stat-card" onclick="window.location.href='{{ route('admin.tasks.index') }}'">
                <span class="card-icon"><i class="fas fa-check-circle fa-2x mb-2" style="color:#198754;"></i></span>
                <h3 class="fw-bold">{{ $completedTasks }}</h3>
                <p class="text-muted mb-0">Completed</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-4 text-center action-card">
                <span class="action-icon"><i class="fas fa-door-open fa-3x mb-3" style="color:#e94560;"></i></span>
                <h5 class="fw-bold">Manage Rooms</h5>
                <p class="text-muted">Add, edit or delete rooms</p>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary">Go to Rooms</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center action-card">
                <span class="action-icon"><i class="fas fa-users fa-3x mb-3" style="color:#e94560;"></i></span>
                <h5 class="fw-bold">Manage Staff</h5>
                <p class="text-muted">Add, edit or delete staff</p>
                <a href="{{ route('admin.staff.index') }}" class="btn btn-primary">Go to Staff</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center action-card">
                <span class="action-icon"><i class="fas fa-tasks fa-3x mb-3" style="color:#e94560;"></i></span>
                <h5 class="fw-bold">Manage Tasks</h5>
                <p class="text-muted">Assign and track tasks</p>
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-primary">Go to Tasks</a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-history me-2"></i>Recent Activity</span>
                    <a href="{{ route('admin.logs.index') }}" class="btn btn-sm btn-outline-light text-white">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentLogs as $log)
                                    <tr @if($log->is_important) style="background-color: rgba(255, 193, 7, 0.1); border-left: 3px solid #ffc107;" @endif>
                                        <td>
                                            @if($log->is_important)
                                                <i class="fas fa-star" style="color: #ffc107; margin-right: 5px;" title="Important Action"></i>
                                            @endif
                                            {{ $log->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            @if($log->user)
                                                <span class="badge bg-{{ $log->role === 'admin' ? 'primary' : 'secondary' }}">
                                                    {{ $log->user->name }}
                                                </span>
                                            @else
                                                <span class="badge bg-dark">System/Deleted</span>
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No recent activity found.</td>
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
</x-app-layout>