<x-app-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-user-plus me-2" style="color: #e94560;"></i>
                    Create Admin Account
                </h2>
                <p class="text-muted">Add a new administrator to the system</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user-shield me-2"></i>Admin Account Details
                    </div>
                    <div class="card-body p-4" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                        <form action="{{ route('admin.admins.store') }}" method="POST">
                            @csrf

                            <!-- Name Fields -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-id-badge me-2" style="color:#e94560;"></i>First Name
                                    </label>
                                    <input type="text" name="first_name"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           placeholder="Enter first name"
                                           value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-id-badge me-2" style="color:#e94560;"></i>Last Name
                                    </label>
                                    <input type="text" name="last_name"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           placeholder="Enter last name"
                                           value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-envelope me-2" style="color:#e94560;"></i>Email
                                    </label>
                                    <input type="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="Enter email address"
                                           value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-phone me-2" style="color:#e94560;"></i>Phone
                                    </label>
                                    <input type="text" name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           placeholder="Enter phone number"
                                           value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-map-marker-alt me-2" style="color:#e94560;"></i>Address
                                </label>
                                <input type="text" name="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       placeholder="Enter full address"
                                       value="{{ old('address') }}" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Birthdate & Age -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-calendar-alt me-2" style="color:#e94560;"></i>Birthdate
                                    </label>
                                    <input type="date" name="birthdate"
                                           class="form-control @error('birthdate') is-invalid @enderror"
                                           value="{{ old('birthdate') }}" required>
                                    @error('birthdate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-users me-2" style="color:#e94560;"></i>Age
                                    </label>
                                    <input type="number" name="age"
                                           class="form-control @error('age') is-invalid @enderror"
                                           placeholder="Age"
                                           min="16" max="120"
                                           value="{{ old('age') }}" required>
                                    @error('age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Fields -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-lock me-2" style="color:#e94560;"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="adminPassword"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Enter password" required>
                                        <button type="button" class="btn btn-outline-secondary"
                                                onclick="togglePassword('adminPassword', this)"
                                                style="border-color:#1a4a8a;background-color:#0f3460;color:#aaaaaa;">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-lock me-2" style="color:#e94560;"></i>Confirm Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="adminConfirmPassword"
                                               class="form-control @error('password_confirmation') is-invalid @enderror"
                                               placeholder="Confirm password" required>
                                        <button type="button" class="btn btn-outline-secondary"
                                                onclick="togglePassword('adminConfirmPassword', this)"
                                                style="border-color:#1a4a8a;background-color:#0f3460;color:#aaaaaa;">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2 pt-3">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="fas fa-save me-2"></i>Create Admin Account
                                </button>
                                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary flex-grow-1">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
                btn.style.color = '#e94560';
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
                btn.style.color = '#aaaaaa';
            }
        }
    </script>
</x-app-layout>
