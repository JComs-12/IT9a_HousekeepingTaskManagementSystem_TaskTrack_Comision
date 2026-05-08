<x-staff-layout>
<style>
    .stat-card {
        border-radius: 18px; padding: 22px 20px;
        position: relative; overflow: hidden;
        transition: transform 0.22s, box-shadow 0.22s;
        border: 1px solid rgba(255,255,255,0.08); cursor: default;
    }
    .stat-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,0,0,0.35); }
    .stat-card .stat-icon { width:48px; height:48px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; margin-bottom:14px; }
    .stat-card .stat-value { font-size:2rem; font-weight:800; line-height:1; margin-bottom:4px; }
    .stat-card .stat-label { font-size:0.78rem; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; opacity:0.75; }
    .stat-card .stat-glow { position:absolute; top:-30px; right:-30px; width:120px; height:120px; border-radius:50%; opacity:0.12; filter:blur(30px); }
    .stat-total   { background: linear-gradient(135deg, rgba(233,69,96,0.15),  rgba(233,69,96,0.05)); }
    .stat-pending { background: linear-gradient(135deg, rgba(245,158,11,0.15), rgba(245,158,11,0.05)); }
    .stat-prog    { background: linear-gradient(135deg, rgba(14,165,233,0.15), rgba(14,165,233,0.05)); }
    .stat-done    { background: linear-gradient(135deg, rgba(34,197,94,0.15),  rgba(34,197,94,0.05)); }

    /* Progress bar */
    .task-progress-bar { height: 6px; border-radius: 4px; background: rgba(255,255,255,0.08); overflow: hidden; margin-top: 10px; }
    .task-progress-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #e94560, #f59e0b); transition: width 0.6s ease; }

    /* Chart wrap */
    .chart-wrap { position:relative; height:200px; display:flex; align-items:center; justify-content:center; }

    /* Priority pills */
    .priority-high   { background:rgba(239,68,68,0.18);  color:#f87171; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
    .priority-medium { background:rgba(245,158,11,0.18); color:#fbbf24; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
    .priority-low    { background:rgba(34,197,94,0.18);  color:#4ade80; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
    .status-pending    { background:rgba(245,158,11,0.18); color:#fbbf24; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
    .status-in_progress{ background:rgba(14,165,233,0.18); color:#38bdf8; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
    .status-completed  { background:rgba(34,197,94,0.18);  color:#4ade80; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
</style>

<div class="container-fluid">

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-1">
                <i class="fas fa-home me-2" style="color:#e94560;"></i>Dashboard
            </h2>
            <p style="color:#94a3b8; font-size:0.9rem; margin:0;">
                Welcome back, <strong style="color:#e2e8f0;">{{ Auth::user()->name }}</strong>! 👋
                &nbsp;·&nbsp; {{ now()->format('l, F d Y') }}
            </p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card stat-total">
                <div class="stat-glow" style="background:#e94560;"></div>
                <div class="stat-icon" style="background:rgba(233,69,96,0.2);color:#e94560;">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-value">{{ $totalTasks }}</div>
                <div class="stat-label">Total Tasks</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card stat-pending">
                <div class="stat-glow" style="background:#f59e0b;"></div>
                <div class="stat-icon" style="background:rgba(245,158,11,0.2);color:#fbbf24;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ $pendingTasks }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card stat-prog">
                <div class="stat-glow" style="background:#0ea5e9;"></div>
                <div class="stat-icon" style="background:rgba(14,165,233,0.2);color:#38bdf8;">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stat-value">{{ $inProgressTasks }}</div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card stat-done">
                <div class="stat-glow" style="background:#22c55e;"></div>
                <div class="stat-icon" style="background:rgba(34,197,94,0.2);color:#4ade80;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $completedTasks }}</div>
                <div class="stat-label">Completed</div>
                @if($totalTasks > 0)
                    <div class="task-progress-bar mt-2">
                        <div class="task-progress-fill" style="width:{{ round(($completedTasks / $totalTasks) * 100) }}%; background:linear-gradient(90deg,#22c55e,#4ade80);"></div>
                    </div>
                    <div style="font-size:0.7rem;color:#4ade80;margin-top:4px;">{{ round(($completedTasks / $totalTasks) * 100) }}% done</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Chart + Recent Tasks --}}
    <div class="row g-3">
        {{-- Donut Chart --}}
        <div class="col-xl-4 col-md-5">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-2"></i>My Task Status
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                    <div class="chart-wrap w-100">
                        <canvas id="staffTaskDonut"></canvas>
                        <div style="position:absolute;text-align:center;pointer-events:none;">
                            <div style="font-size:1.8rem;font-weight:800;line-height:1;color:#f1f5f9;">{{ $totalTasks }}</div>
                            <div style="font-size:0.72rem;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;">Tasks</div>
                        </div>
                    </div>
                    <div class="d-flex gap-3 flex-wrap justify-content-center mt-3">
                        <span style="font-size:0.78rem;color:#94a3b8;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#fbbf24;margin-right:5px;"></span>Pending</span>
                        <span style="font-size:0.78rem;color:#94a3b8;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#38bdf8;margin-right:5px;"></span>In Progress</span>
                        <span style="font-size:0.78rem;color:#94a3b8;"><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#4ade80;margin-right:5px;"></span>Completed</span>
                    </div>
                    <a href="{{ route('staff.tasks') }}" class="btn btn-primary btn-sm w-100 mt-4">
                        <i class="fas fa-tasks me-2"></i>View All Tasks
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Tasks --}}
        <div class="col-xl-8 col-md-7">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-list me-2"></i>Recent Tasks</span>
                    <a href="{{ route('staff.tasks') }}" class="btn btn-sm btn-outline-light" style="font-size:0.78rem;border-color:rgba(255,255,255,0.15);">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Room</th>
                                    <th>Priority</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTasks as $task)
                                <tr>
                                    <td>
                                        @php $taskNames = explode(', ', $task->task_name); @endphp
                                        @if(count($taskNames) > 1)
                                            <div class="dropdown">
                                                <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                                    style="background:#1a1a2e;color:#fff;border:1px solid #1a4a8a;font-size:0.82rem;">
                                                    <i class="fas fa-list-ul me-1" style="color:#e94560;"></i>{{ count($taskNames) }} Tasks
                                                </button>
                                                <ul class="dropdown-menu" style="background:#16213e;border:1px solid #0f3460;">
                                                    @foreach($taskNames as $tName)
                                                        <li class="dropdown-item text-white" style="font-size:0.85rem;">
                                                            <i class="fas fa-check me-2" style="color:#e94560;font-size:0.8em;"></i>{{ $tName }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @else
                                            <span style="font-size:0.88rem;">{{ $task->task_name }}</span>
                                        @endif
                                    </td>
                                    <td><span style="font-size:0.85rem;color:#94a3b8;">Room {{ $task->room->room_number }}</span></td>
                                    <td>
                                        @if($task->priority == 'high') <span class="priority-high">High</span>
                                        @elseif($task->priority == 'medium') <span class="priority-medium">Medium</span>
                                        @else <span class="priority-low">Low</span>
                                        @endif
                                    </td>
                                    <td><span style="font-size:0.83rem;">{{ $task->due_date }}</span></td>
                                    <td>
                                        @if($task->status == 'completed') <span class="status-completed">Completed</span>
                                        @elseif($task->status == 'in_progress') <span class="status-in_progress">In Progress</span>
                                        @else <span class="status-pending">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5" style="color:#475569;">
                                        <i class="fas fa-tasks fa-2x d-block mb-2" style="opacity:0.3;"></i>
                                        No tasks assigned yet!
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx2 = document.getElementById('staffTaskDonut').getContext('2d');
    const p = {{ $pendingTasks }};
    const i = {{ $inProgressTasks }};
    const c = {{ $completedTasks }};
    const t = p + i + c;
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Pending','In Progress','Completed'],
            datasets: [{
                data: t > 0 ? [p, i, c] : [1,0,0],
                backgroundColor: ['rgba(251,191,36,0.85)','rgba(56,189,248,0.85)','rgba(74,222,128,0.85)'],
                borderColor: ['#fbbf24','#38bdf8','#4ade80'],
                borderWidth: 2, hoverOffset: 8,
            }]
        },
        options: {
            cutout: '72%', responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` },
                    backgroundColor: '#131929', borderColor: 'rgba(255,255,255,0.1)', borderWidth: 1,
                    titleColor: '#f1f5f9', bodyColor: '#94a3b8', padding: 12,
                }
            }
        }
    });
</script>
</x-staff-layout>