<x-app-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-plus me-2" style="color: #e94560;"></i>
                    Add New Staff
                </h2>
                <p class="text-muted">Create a new staff member for the hotel team</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user-plus me-2"></i>Staff Details
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.staff.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Enter full name"
                                           value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email"
                                           name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="Enter email address"
                                           value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Password</label>
                                    <div class="password-wrapper">
                                        <input type="password"
                                               name="password"
                                               id="staffPassword"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Enter password">
                                        <button type="button" class="toggle-pwd" onclick="toggleStaffPassword()">
                                            <i class="fas fa-eye" id="staffPasswordIcon"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Confirm Password</label>
                                    <div class="password-wrapper">
                                        <input type="password"
                                               name="password_confirmation"
                                               id="staffConfirmPassword"
                                               class="form-control @error('password_confirmation') is-invalid @enderror"
                                               placeholder="Confirm password">
                                        <button type="button" class="toggle-pwd" onclick="toggleStaffConfirmPassword()">
                                            <i class="fas fa-eye" id="staffConfirmPasswordIcon"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Phone</label>
                                    <input type="text"
                                           name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           placeholder="Enter phone number"
                                           value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                        <option value="">-- Select Status --</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Create Staff
                                </button>
                                <a href="{{ route('admin.staff.index') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .password-wrapper {
            position: relative;
        }
        .password-wrapper .toggle-pwd {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #aaaaaa;
            cursor: pointer;
            padding: 0;
            font-size: 0.95rem;
            transition: color 0.2s;
        }
        .password-wrapper .toggle-pwd:hover {
            color: #e94560;
        }
        .password-wrapper .form-control {
            padding-right: 42px;
        }
    </style>

    <script>
        function toggleStaffPassword() {
            const input = document.getElementById('staffPassword');
            const icon = document.getElementById('staffPasswordIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function toggleStaffConfirmPassword() {
            const input = document.getElementById('staffConfirmPassword');
            const icon = document.getElementById('staffConfirmPasswordIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</x-app-layout>