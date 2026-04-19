<x-app-layout>
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-chart-bar me-2" style="color: #e94560;"></i>
                    Reports
                </h2>
                <p class="text-muted">Overview of all tasks and their status</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <i class="fas fa-clock fa-2x mb-2" style="color: #ffc107;"></i>
                    <h3 class="fw-bold">{{ $pendingTasks }}</h3>
                    <p class="text-muted mb-0">Pending Tasks</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <i class="fas fa-spinner fa-2x mb-2" style="color: #0dcaf0;"></i>
                    <h3 class="fw-bold">{{ $inProgressTasks }}</h3>
                    <p class="text-muted mb-0">In Progress Tasks</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-4">
                    <i class="fas fa-check-circle fa-2x mb-2" style="color: #198754;"></i>
                    <h3 class="fw-bold">{{ $completedTasks }}</h3>
                    <p class="text-muted mb-0">Completed Tasks</p>
                </div>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>All Tasks Report
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task Name</th>
                                <th>Room</th>
                                <th>Staff</th>
                                <th>Priority</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->task_name }}</td>
                                <td>Room {{ $task->room->room_number }}</td>
                                <td>{{ $task->staff->pluck('name')->implode(', ') ?: '—' }}</td>
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
                                <td colspan="7" class="text-center text-muted">
                                    No tasks found!
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