<x-app-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-edit me-2" style="color:#e94560;"></i>Edit Room
                </h2>
                <p class="text-muted">Update room details</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-door-open me-2"></i>Room Details — <strong>Room {{ $room->room_number }}</strong>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" id="editRoomForm">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-bold">Room Number</label>
                                <input type="text"
                                       name="room_number"
                                       class="form-control @error('room_number') is-invalid @enderror"
                                       value="{{ old('room_number', $room->room_number) }}">
                                @error('room_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Room Type — dropdown -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Room Type</label>
                                <select name="room_type"
                                        class="form-select @error('room_type') is-invalid @enderror">
                                    <option value="">-- Select Room Type --</option>
                                    @foreach($roomTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ old('room_type', $room->room_type) == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('room_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status"
                                        class="form-select @error('status') is-invalid @enderror">
                                    <option value="available"   {{ old('status', $room->status) == 'available'   ? 'selected' : '' }}>Available</option>
                                    <option value="occupied"    {{ old('status', $room->status) == 'occupied'    ? 'selected' : '' }}>Occupied</option>
                                    <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <!-- Update triggers confirmation modal -->
                                <button type="button" class="btn btn-primary w-100"
                                        data-bs-toggle="modal" data-bs-target="#confirmEditModal">
                                    <i class="fas fa-save me-2"></i>Update Room
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

    <!-- Confirm Update Modal -->
    <div class="modal fade" id="confirmEditModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" style="background-color:#16213e; border:1px solid #0f3460;">
                <div class="modal-header" style="border-bottom:1px solid #0f3460;">
                    <h6 class="modal-title">
                        <i class="fas fa-edit me-2" style="color:#e94560;"></i>Confirm Update
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p style="color:#aaaaaa; font-size:0.9rem; margin-bottom:0;">
                        Save changes to <strong style="color:#ffffff;">Room {{ $room->room_number }}</strong>?
                    </p>
                </div>
                <div class="modal-footer" style="border-top:1px solid #0f3460;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary btn-sm"
                            onclick="document.getElementById('editRoomForm').submit()">
                        <i class="fas fa-save me-1"></i>Yes, Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>