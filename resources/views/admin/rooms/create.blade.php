<x-app-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-plus me-2" style="color:#e94560;"></i>Add New Room
                </h2>
                <p class="text-muted">Fill in the details to add a new room</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-door-open me-2"></i>Room Details
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.rooms.store') }}" method="POST">
                            @csrf

                            <!-- Room Number -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Room Number</label>
                                <input type="text"
                                       name="room_number"
                                       class="form-control @error('room_number') is-invalid @enderror"
                                       placeholder="e.g. 101"
                                       value="{{ old('room_number') }}">
                                @error('room_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Room Type — now a dropdown -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Room Type</label>
                                <select name="room_type"
                                        class="form-select @error('room_type') is-invalid @enderror">
                                    <option value="">-- Select Room Type --</option>
                                    @foreach($roomTypes as $type)
                                        <option value="{{ $type }}" {{ old('room_type') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                    <option value="">-- Select Status --</option>
                                    <option value="available"    {{ old('status') == 'available'    ? 'selected' : '' }}>Available</option>
                                    <option value="occupied"     {{ old('status') == 'occupied'     ? 'selected' : '' }}>Occupied</option>
                                    <option value="maintenance"  {{ old('status') == 'maintenance'  ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Save Room
                                </button>
                                <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>