<x-staff-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-home me-2" style="color: #e94560;"></i>
                    Dashboard
                </h2>
                <p class="text-muted">Welcome back, {{ Auth::user()->name }}! 👋</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <i class="fas fa-tasks fa-2x mb-2" style="color: #e94560;"></i>
                    <h3 class="fw-bold">{{ $totalTasks }}</h3>
                    <p class="text-muted mb-0">Total Tasks</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <i class="fas fa-clock fa-2x mb-2" style="color: #ffc107;"></i>
                    <h3 class="fw-bold">{{ $pendingTasks }}</h3>
                    <p class="text-muted mb-0">Pending</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <i class="fas fa-spinner fa-2x mb-2" style="color: #0dcaf0;"></i>
                    <h3 class="fw-bold">{{ $inProgressTasks }}</h3>
                    <p class="text-muted mb-0">In Progress</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <i class="fas fa-check-circle fa-2x mb-2" style="color: #198754;"></i>
                    <h3 class="fw-bold">{{ $completedTasks }}</h3>
                    <p class="text-muted mb-0">Completed</p>
                </div>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>Recent Tasks
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
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
                                <td colspan="5" class="text-center text-muted">
                                    No tasks assigned yet!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('staff.tasks') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-tasks me-2"></i>View All Tasks
                </a>
            </div>
        </div>
    </div>
</x-staff-layout>