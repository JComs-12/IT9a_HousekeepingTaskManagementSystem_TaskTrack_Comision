<x-staff-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">
                        <i class="fas fa-clipboard-list me-2" style="color: #e94560;"></i>
                        My Reports
                    </h2>
                    <p class="text-muted">Submit incidents and track their status</p>
                </div>
                <a href="{{ route('staff.reports.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>New Report
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>Submitted Reports
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Room</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Submitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($report->room)
                                            Room {{ $report->room->room_number }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-capitalize">{{ $report->report_type }}</td>
                                    <td style="max-width: 420px;">
                                        {{ \Illuminate\Support\Str::limit($report->description, 120) }}
                                    </td>
                                    <td>
                                        @if($report->status === 'resolved')
                                            <span class="badge bg-success">Resolved</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No reports yet. Click “New Report” to submit.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-staff-layout>

