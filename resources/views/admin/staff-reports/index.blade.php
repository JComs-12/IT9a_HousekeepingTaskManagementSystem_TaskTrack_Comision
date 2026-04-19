<x-app-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">
                        <i class="fas fa-flag me-2" style="color: #e94560;"></i>
                        Staff Reports
                    </h2>
                    <p class="text-muted">Review incidents reported by staff</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>All Reports
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Staff</th>
                                <th>Room</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $report->staff ? $report->staff->name : 'N/A' }}</td>
                                    <td>
                                        @if($report->room)
                                            Room {{ $report->room->room_number }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-capitalize">{{ $report->report_type }}</td>
                                    <td style="max-width: 420px;">
                                        {{ \Illuminate\Support\Str::limit($report->description, 140) }}
                                    </td>
                                    <td>
                                        @if($report->status === 'resolved')
                                            <span class="badge bg-success">Resolved</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        @if($report->status === 'pending')
                                            <form action="{{ route('admin.staff-reports.update', $report->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="resolved">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check me-1"></i>Resolve
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No staff reports yet.
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

