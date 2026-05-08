<x-app-layout>
<style>
    .info-row { display:flex; align-items:flex-start; gap:14px; padding:12px 0; border-bottom:1px solid rgba(255,255,255,0.05); }
    .info-row:last-child { border-bottom:none; }
    .info-icon { width:34px; height:34px; border-radius:10px; background:rgba(233,69,96,0.12); display:flex; align-items:center; justify-content:center; color:#e94560; font-size:0.85rem; flex-shrink:0; }
    .info-label { font-size:0.72rem; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; color:#475569; margin-bottom:2px; }
    .info-value { font-size:0.92rem; color:#e2e8f0; font-weight:500; }
    .priority-high   { background:rgba(239,68,68,0.18);  color:#f87171; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
    .priority-medium { background:rgba(245,158,11,0.18); color:#fbbf24; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
    .priority-low    { background:rgba(34,197,94,0.18);  color:#4ade80; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
    .status-pending    { background:rgba(245,158,11,0.18); color:#fbbf24; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
    .status-in_progress{ background:rgba(14,165,233,0.18); color:#38bdf8; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
    .status-completed  { background:rgba(34,197,94,0.18);  color:#4ade80; border-radius:20px; padding:2px 10px; font-size:0.75rem; font-weight:600; }
    .table tbody tr:hover td { background:rgba(255,255,255,0.06) !important; }
</style>

<div class="container-fluid">

    {{-- Header --}}
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold">
                    <i class="fas fa-user me-2" style="color:#e94560;"></i>Staff Profile
                </h2>
                <p class="text-muted">Viewing staff information</p>
            </div>
            <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Left: Profile Card --}}
        <div class="col-md-4">
            <div class="card p-4 text-center mb-4">
                {{-- Avatar --}}
                @if($user && $user->avatar)
                    <img src="{{ Storage::url($user->avatar) }}"
                         style="width:90px;height:90px;border-radius:50%;object-fit:cover;margin:0 auto 16px;border:3px solid rgba(233,69,96,0.5);"
                         alt="{{ $staff->name }}">
                @else
                    <div style="width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#e94560,#b91c1c);display:flex;align-items:center;justify-content:center;font-size:2.2rem;font-weight:800;color:#fff;margin:0 auto 16px;border:3px solid rgba(233,69,96,0.3);">
                        {{ strtoupper(substr($staff->name, 0, 1)) }}
                    </div>
                @endif

                <h5 class="fw-bold mb-1">{{ $staff->name }}</h5>
                <p style="color:#94a3b8; font-size:0.85rem; margin-bottom:12px;">{{ $staff->email }}</p>

                @php $isActive = ($staff->status ?? 'active') === 'active'; @endphp
                <span style="background:rgba({{ $isActive ? '16,185,129' : '239,68,68' }},0.15);color:{{ $isActive ? '#34d399' : '#f87171' }};border-radius:20px;padding:4px 14px;font-size:0.78rem;font-weight:700;">
                    <i class="fas fa-circle me-1" style="font-size:0.5rem;"></i>{{ ucfirst($staff->status ?? 'Active') }}
                </span>

                <hr style="border-color:rgba(255,255,255,0.08); margin:16px 0;">

                {{-- Info rows --}}
                <div class="text-start">
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-user"></i></div>
                        <div>
                            <div class="info-label">First Name</div>
                            <div class="info-value">{{ $staff->first_name ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-user"></i></div>
                        <div>
                            <div class="info-label">Last Name</div>
                            <div class="info-value">{{ $staff->last_name ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-venus-mars"></i></div>
                        <div>
                            <div class="info-label">Gender</div>
                            <div class="info-value">{{ str_replace('_', ' ', ucfirst($staff->gender ?? 'Not specified')) }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <div class="info-label">Phone</div>
                            <div class="info-value">{{ $staff->phone ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <div class="info-label">Address</div>
                            <div class="info-value">{{ $staff->address ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-birthday-cake"></i></div>
                        <div>
                            <div class="info-label">Birthdate</div>
                            <div class="info-value">{{ optional($staff->birthdate)->format('M d, Y') ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-hashtag"></i></div>
                        <div>
                            <div class="info-label">Age</div>
                            <div class="info-value">{{ $staff->age ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-calendar-plus"></i></div>
                        <div>
                            <div class="info-label">Member Since</div>
                            <div class="info-value">{{ $staff->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Tasks --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-tasks me-2"></i>Assigned Tasks</span>
                    <span style="background:rgba(233,69,96,0.15);color:#e94560;border-radius:20px;padding:3px 12px;font-size:0.78rem;font-weight:700;">
                        {{ $tasks->count() }} {{ Str::plural('task', $tasks->count()) }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Task Name</th>
                                    <th>Room</th>
                                    <th>Priority</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                <tr>
                                    <td style="color:#475569; font-size:0.83rem;">{{ $loop->iteration }}</td>
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
                                    <td style="font-size:0.85rem;color:#94a3b8;">Room {{ $task->room->room_number }}</td>
                                    <td>
                                        @if($task->priority == 'high') <span class="priority-high">High</span>
                                        @elseif($task->priority == 'medium') <span class="priority-medium">Medium</span>
                                        @else <span class="priority-low">Low</span>
                                        @endif
                                    </td>
                                    <td style="font-size:0.83rem;">{{ $task->due_date }}</td>
                                    <td>
                                        @if($task->status == 'completed') <span class="status-completed">Completed</span>
                                        @elseif($task->status == 'in_progress') <span class="status-in_progress">In Progress</span>
                                        @else <span class="status-pending">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5" style="color:#475569;">
                                        <i class="fas fa-tasks fa-2x d-block mb-2" style="opacity:0.3;"></i>
                                        No tasks assigned yet.
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
</x-app-layout>