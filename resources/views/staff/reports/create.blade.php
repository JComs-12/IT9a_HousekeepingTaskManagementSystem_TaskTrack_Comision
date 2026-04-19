<x-staff-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">
                        <i class="fas fa-clipboard-medical me-2" style="color: #e94560;"></i>
                        New Report
                    </h2>
                    <p class="text-muted">Report damages, discoveries, or other concerns</p>
                </div>
                <a href="{{ route('staff.reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-file-alt me-2"></i>Report Details
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('staff.reports.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Room (optional)</label>
                                    <select name="room_id" class="form-select">
                                        <option value="">-- No Room --</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                Room {{ $room->room_number }} - {{ $room->room_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Type</label>
                                    <select name="report_type" class="form-select @error('report_type') is-invalid @enderror">
                                        <option value="">-- Select Type --</option>
                                        <option value="damage" {{ old('report_type') == 'damage' ? 'selected' : '' }}>Damage</option>
                                        <option value="discovery" {{ old('report_type') == 'discovery' ? 'selected' : '' }}>Discovery</option>
                                        <option value="other" {{ old('report_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('report_type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="5"
                                          placeholder="Describe what happened">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Submit Report
                                </button>
                                <a href="{{ route('staff.reports.index') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-staff-layout>

