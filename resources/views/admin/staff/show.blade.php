<x-app-layout>
    <div class="container-fluid">
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
            <!-- Info Card -->
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <!-- Avatar: show uploaded photo or initials fallback -->
                    @if($user && $user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}"
                             style="width:100px;height:100px;border-radius:50%;object-fit:cover;
                                    margin:0 auto 15px;border:4px solid #0f3460;"
                             alt="{{ $staff->name }}">
                    @else
                        <div style="width:100px;height:100px;border-radius:50%;
                                    background-color:#e94560;display:flex;align-items:center;
                                    justify-content:center;font-size:2.5rem;font-weight:700;
                                    color:#ffffff;margin:0 auto 15px;border:4px solid #0f3460;">
                            {{ strtoupper(substr($staff->name, 0, 1)) }}
                        </div>
                    @endif

                    <h4 class="fw-bold mb-1">{{ $staff->name }}</h4>
                    <p class="text-muted mb-0">{{ $staff->email }}</p>
                    <p class="text-muted">{{ $staff->phone }}</p>
                    <span class="badge mt-2"
                          style="background-color:{{ $staff->status == 'active' ? '#198754' : '#dc3545' }};">
                        {{ ucfirst($staff->status) }}
                    </span>
                    <hr style="border-color:#0f3460;">
                    <p class="mb-0" style="color:#aaaaaa;font-size:0.85rem;">
                        <i class="fas fa-calendar me-2" style="color:#e94560;"></i>
                        Added {{ $staff->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>

            <!-- Tasks Card -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-tasks me-2"></i>
                        Assigned Tasks ({{ $tasks->count() }})
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
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
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @php $taskNames = explode(', ', $task->task_name); @endphp
                                            @if(count($taskNames) > 1)
                                                <div class="dropdown">
                                                    <button class="btn btn-sm dropdown-toggle w-100 text-start" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #1a1a2e; color: #ffffff; border: 1px solid #1a4a8a;">
                                                        <i class="fas fa-list-ul me-1" style="color: #e94560;"></i> {{ count($taskNames) }} Tasks
                                                    </button>
                                                    <ul class="dropdown-menu shadow" style="background-color: #16213e; border: 1px solid #0f3460;">
                                                        @foreach($taskNames as $tName)
                                                            <li class="dropdown-item px-3 py-1 text-white" style="background: transparent;">
                                                                <i class="fas fa-check me-2" style="color: #e94560; font-size: 0.8em;"></i>{{ $tName }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                {{ $task->task_name }}
                                            @endif
                                        </td>
                                        <td>Room {{ $task->room->room_number }}</td>
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
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
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
</x-app-layout>