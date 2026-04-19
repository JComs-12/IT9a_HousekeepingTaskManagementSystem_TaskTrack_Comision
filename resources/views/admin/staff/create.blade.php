<x-app-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-plus me-2" style="color: #e94560;"></i>
                    Add New Task
                </h2>
                <p class="text-muted">Fill in the details to assign a new task</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-tasks me-2"></i>Task Details
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.tasks.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Task Name</label>
                                    <input type="text"
                                           name="task_name"
                                           class="form-control @error('task_name') is-invalid @enderror"
                                           placeholder="Enter task name"
                                           value="{{ old('task_name') }}">
                                    @error('task_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Assign Room</label>
                                    <select name="room_id"
                                            class="form-select @error('room_id') is-invalid @enderror">
                                        <option value="">-- Select Room --</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                Room {{ $room->room_number }} - {{ $room->room_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('room_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Assign Staff</label>
                                    <select name="staff_ids[]"
                                            multiple
                                            class="form-select @error('staff_ids') is-invalid @enderror"
                                            style="min-height: 120px;">
                                        @foreach($staff as $member)
                                            <option value="{{ $member->id }}" {{ in_array($member->id, old('staff_ids', [])) ? 'selected' : '' }}>
                                                {{ $member->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Hold Ctrl (or Cmd on Mac) to select multiple staff</small>
                                    @error('staff_ids')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Priority</label>
                                    <select name="priority"
                                            class="form-select @error('priority') is-invalid @enderror">
                                        <option value="">-- Select Priority --</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Due Date</label>
                                    <input type="date"
                                           name="due_date"
                                           class="form-control @error('due_date') is-invalid @enderror"
                                           value="{{ old('due_date') }}">
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                        <option value="">-- Select Status --</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="3"
                                              placeholder="Enter task description (optional)">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Save Task
                                </button>
                                <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary w-100">
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