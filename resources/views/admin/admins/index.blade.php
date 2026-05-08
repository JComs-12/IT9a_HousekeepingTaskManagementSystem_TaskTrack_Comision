<x-app-layout>
<style>
    .table tbody tr { transition: background-color 0.2s; }
    .table tbody tr:hover td { background-color: rgba(255,255,255,0.06) !important; }
    .admin-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.85rem; font-weight: 700; color: #fff; flex-shrink: 0;
    }
    .admin-avatar.you { background: linear-gradient(135deg, #e94560, #b91c1c); }
    .you-badge { background: rgba(233,69,96,0.15); color: #e94560; border-radius: 20px; padding: 2px 9px; font-size: 0.7rem; font-weight: 700; border: 1px solid rgba(233,69,96,0.3); }
    .active-badge { background: rgba(16,185,129,0.15); color: #34d399; border-radius: 20px; padding: 3px 10px; font-size: 0.75rem; font-weight: 600; }
</style>

<div class="container-fluid">
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

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-user-shield me-2"></i>All Administrators</span>
            <span class="badge" style="background:rgba(99,102,241,0.2);color:#818cf8;border-radius:20px;padding:4px 12px;">
                {{ $admins->count() }} {{ Str::plural('admin', $admins->count()) }}
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Admin</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Joined</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                        <tr>
                            <td style="color:#475569; font-size:0.83rem;">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="admin-avatar {{ $admin->id === Auth::id() ? 'you' : '' }}">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold" style="font-size:0.9rem;">
                                            {{ $admin->name }}
                                            @if($admin->id === Auth::id())
                                                <span class="you-badge ms-1">You</span>
                                            @endif
                                        </div>
                                        <div style="font-size:0.75rem; color:#475569;">Administrator</div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size:0.88rem; color:#94a3b8;">{{ $admin->email }}</td>
                            <td style="font-size:0.88rem; color:#94a3b8;">{{ $admin->phone ?? '—' }}</td>
                            <td style="font-size:0.85rem;">
                                @php $gender = $admin->gender ?? null; @endphp
                                @if($gender)
                                    <span style="background:rgba(14,165,233,0.15);color:#38bdf8;border-radius:20px;padding:2px 10px;font-size:0.75rem;font-weight:600;">
                                        {{ str_replace('_', ' ', ucfirst($gender)) }}
                                    </span>
                                @else
                                    <span style="color:#334155;">—</span>
                                @endif
                            </td>
                            <td style="font-size:0.83rem; color:#94a3b8;">{{ $admin->created_at->format('M d, Y') }}</td>
                            <td><span class="active-badge"><i class="fas fa-circle me-1" style="font-size:0.55rem;"></i>Active</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5" style="color:#475569;">
                                <i class="fas fa-user-shield fa-2x d-block mb-2" style="opacity:0.3;"></i>
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
