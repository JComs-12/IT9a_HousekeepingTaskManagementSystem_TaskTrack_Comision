<x-app-layout>
<style>
    /* ── Stat Cards ── */
    .stat-card {
        border-radius: 18px;
        padding: 22px 20px;
        position: relative;
        overflow: hidden;
        transition: transform 0.22s, box-shadow 0.22s;
        cursor: pointer;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .stat-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.35); }
    .stat-card .stat-icon {
        width: 48px; height: 48px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; margin-bottom: 14px;
    }
    .stat-card .stat-value { font-size: 2rem; font-weight: 800; line-height: 1; margin-bottom: 4px; }
    .stat-card .stat-label { font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; opacity: 0.75; }
    .stat-card .stat-glow {
        position: absolute; top: -30px; right: -30px;
        width: 120px; height: 120px; border-radius: 50%;
        opacity: 0.12; filter: blur(30px);
    }

    /* Card colour themes */
    .stat-rooms  { background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(99,102,241,0.05)); }
    .stat-staff  { background: linear-gradient(135deg, rgba(16,185,129,0.15), rgba(16,185,129,0.05)); }
    .stat-total  { background: linear-gradient(135deg, rgba(233,69,96,0.15),  rgba(233,69,96,0.05));  }
    .stat-pending{ background: linear-gradient(135deg, rgba(245,158,11,0.15), rgba(245,158,11,0.05)); }
    .stat-prog   { background: linear-gradient(135deg, rgba(14,165,233,0.15), rgba(14,165,233,0.05)); }
    .stat-done   { background: linear-gradient(135deg, rgba(34,197,94,0.15),  rgba(34,197,94,0.05));  }

    /* ── Quick Action Cards ── */
    .action-card {
        border-radius: 18px; padding: 28px 22px; text-align: center;
        border: 1px solid rgba(255,255,255,0.08);
        transition: transform 0.22s, box-shadow 0.22s, border-color 0.22s;
        background: rgba(255,255,255,0.04);
        position: relative; overflow: hidden;
    }
    .action-card:hover { transform: translateY(-6px); box-shadow: 0 14px 36px rgba(233,69,96,0.2); border-color: rgba(233,69,96,0.4); }
    .action-card .action-icon-wrap {
        width: 64px; height: 64px; border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px; font-size: 1.6rem;
        background: rgba(233,69,96,0.12); color: #e94560;
        transition: background 0.22s, transform 0.22s;
    }
    .action-card:hover .action-icon-wrap { background: rgba(233,69,96,0.22); transform: scale(1.1); }
    .action-card h6 { font-weight: 700; font-size: 1rem; margin-bottom: 6px; }
    .action-card p  { font-size: 0.82rem; color: #94a3b8; margin-bottom: 16px; }

    /* ── Activity Feed ── */
    .activity-item {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 14px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        transition: background 0.15s;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-item:hover { background: rgba(255,255,255,0.03); }
    .activity-dot {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; flex-shrink: 0; margin-top: 2px;
    }
    .activity-dot.admin  { background: rgba(99,102,241,0.2); color: #818cf8; }
    .activity-dot.staff  { background: rgba(16,185,129,0.2); color: #34d399; }
    .activity-dot.system { background: rgba(100,116,139,0.2); color: #94a3b8; }
    .activity-dot.important { background: rgba(245,158,11,0.2); color: #fbbf24; }
    .activity-action { font-weight: 600; font-size: 0.88rem; margin-bottom: 2px; }
    .activity-desc  { font-size: 0.82rem; color: #94a3b8; line-height: 1.4; }
    .activity-time  { font-size: 0.72rem; color: #475569; margin-top: 4px; }

    /* ── Chart wrapper ── */
    .chart-wrap { position: relative; height: 220px; display: flex; align-items: center; justify-content: center; }
</style>

<div class="container-fluid">

    {{-- Page Header --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-home me-2" style="color:#e94560;"></i>Dashboard
                </h2>
                <p style="color:#94a3b8; font-size:0.9rem; margin:0;">
                    Welcome back, <strong style="color:#e2e8f0;">{{ Auth::user()->name }}</strong>! 👋
                    &nbsp;·&nbsp; {{ now()->format('l, F d Y') }}
                </p>
            </div>
        </div>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card stat-rooms" onclick="window.location='{{ route('admin.rooms.index') }}'">
                <div class="stat-glow" style="background:#6366f1;"></div>
                <div class="stat-icon" style="background:rgba(99,102,241,0.2); color:#818cf8;">
                    <i class="fas fa-door-open"></i>
                </div>
                <div class="stat-value">{{ $totalRooms }}</div>
                <div class="stat-label">Rooms</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card stat-staff" onclick="window.location='{{ route('admin.staff.index') }}'">
                <div class="stat-glow" style="background:#10b981;"></div>
                <div class="stat-icon" style="background:rgba(16,185,129,0.2); color:#34d399;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ $totalStaff }}</div>
                <div class="stat-label">Staff</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card stat-total" onclick="window.location='{{ route('admin.tasks.index') }}'">
                <div class="stat-glow" style="background:#e94560;"></div>
                <div class="stat-icon" style="background:rgba(233,69,96,0.2); color:#e94560;">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-value">{{ $totalTasks }}</div>
                <div class="stat-label">Total Tasks</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card stat-pending" onclick="window.location='{{ route('admin.tasks.index') }}'">
                <div class="stat-glow" style="background:#f59e0b;"></div>
                <div class="stat-icon" style="background:rgba(245,158,11,0.2); color:#fbbf24;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ $pendingTasks }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card stat-prog" onclick="window.location='{{ route('admin.tasks.index') }}'">
                <div class="stat-glow" style="background:#0ea5e9;"></div>
                <div class="stat-icon" style="background:rgba(14,165,233,0.2); color:#38bdf8;">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-value">{{ $inProgressTasks }}</div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card stat-done" onclick="window.location='{{ route('admin.tasks.index') }}'">
                <div class="stat-glow" style="background:#22c55e;"></div>
                <div class="stat-icon" style="background:rgba(34,197,94,0.2); color:#4ade80;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $completedTasks }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
    </div>

    {{-- ── Chart + Quick Actions ── --}}
    <div class="row g-3 mb-4">
        {{-- Donut Chart --}}
        <div class="col-xl-4 col-md-5">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-2"></i>Task Overview
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                    <div class="chart-wrap w-100">
                        <canvas id="taskDonut"></canvas>
                        <div id="donutCenter" style="position:absolute;text-align:center;pointer-events:none;">
                            <div style="font-size:1.9rem;font-weight:800;line-height:1;color:#f1f5f9;">{{ $totalTasks }}</div>
                            <div style="font-size:0.72rem;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;">Total</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3 flex-wrap justify-content-center mt-3">
                        <span style="font-size:0.78rem;color:#94a3b8;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#fbbf24;margin-right:5px;"></span>Pending</span>
                        <span style="font-size:0.78rem;color:#94a3b8;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#38bdf8;margin-right:5px;"></span>In Progress</span>
                        <span style="font-size:0.78rem;color:#94a3b8;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#4ade80;margin-right:5px;"></span>Completed</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-xl-8 col-md-7">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="action-card">
                                <div class="action-icon-wrap"><i class="fas fa-door-open"></i></div>
                                <h6>Manage Rooms</h6>
                                <p>Add, edit or delete rooms in the system</p>
                                <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary btn-sm px-4">Go to Rooms</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="action-card">
                                <div class="action-icon-wrap"><i class="fas fa-users"></i></div>
                                <h6>Manage Staff</h6>
                                <p>View and manage all staff accounts</p>
                                <a href="{{ route('admin.staff.index') }}" class="btn btn-primary btn-sm px-4">Go to Staff</a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="action-card">
                                <div class="action-icon-wrap"><i class="fas fa-tasks"></i></div>
                                <h6>Manage Tasks</h6>
                                <p>Assign and track housekeeping tasks</p>
                                <a href="{{ route('admin.tasks.index') }}" class="btn btn-primary btn-sm px-4">Go to Tasks</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Recent Activity ── --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-history me-2"></i>Recent Activity</span>
                    <a href="{{ route('admin.logs.index') }}" class="btn btn-sm btn-outline-light" style="font-size:0.78rem; border-color:rgba(255,255,255,0.15);">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    @forelse($recentLogs as $log)
                        @php
                            $dotClass = $log->is_important ? 'important' : ($log->role === 'admin' ? 'admin' : ($log->role === 'staff' ? 'staff' : 'system'));
                            $dotIcon  = $log->is_important ? 'fa-star' : ($log->role === 'admin' ? 'fa-user-shield' : ($log->role === 'staff' ? 'fa-user' : 'fa-cog'));
                        @endphp
                        <div class="activity-item">
                            <div class="activity-dot {{ $dotClass }}">
                                <i class="fas {{ $dotIcon }}"></i>
                            </div>
                            <div style="flex:1; min-width:0;">
                                <div class="activity-action d-flex align-items-center gap-2">
                                    {{ $log->action }}
                                    @if($log->is_important)
                                        <span class="badge" style="background:rgba(245,158,11,0.2);color:#fbbf24;font-size:0.65rem;">Important</span>
                                    @endif
                                    @if($log->user)
                                        <span class="badge" style="background:rgba({{ $log->role === 'admin' ? '99,102,241' : '16,185,129' }},0.2);color:{{ $log->role === 'admin' ? '#818cf8' : '#34d399' }};font-size:0.65rem;">
                                            {{ $log->user->name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="activity-desc">{{ $log->description }}</div>
                                <div class="activity-time"><i class="fas fa-clock me-1"></i>{{ $log->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5" style="color:#475569;">
                            <i class="fas fa-history fa-2x mb-3 d-block" style="opacity:0.4;"></i>
                            No recent activity found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('taskDonut').getContext('2d');
    const pending   = {{ $pendingTasks }};
    const inProg    = {{ $inProgressTasks }};
    const completed = {{ $completedTasks }};
    const total     = pending + inProg + completed;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'In Progress', 'Completed'],
            datasets: [{
                data: total > 0 ? [pending, inProg, completed] : [1, 0, 0],
                backgroundColor: ['rgba(251,191,36,0.85)', 'rgba(56,189,248,0.85)', 'rgba(74,222,128,0.85)'],
                borderColor:     ['#fbbf24', '#38bdf8', '#4ade80'],
                borderWidth: 2,
                hoverOffset: 8,
            }]
        },
        options: {
            cutout: '72%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed} task${ctx.parsed !== 1 ? 's' : ''}`
                    },
                    backgroundColor: '#131929',
                    borderColor: 'rgba(255,255,255,0.1)',
                    borderWidth: 1,
                    titleColor: '#f1f5f9',
                    bodyColor: '#94a3b8',
                    padding: 12,
                }
            }
        }
    });
</script>
</x-app-layout>