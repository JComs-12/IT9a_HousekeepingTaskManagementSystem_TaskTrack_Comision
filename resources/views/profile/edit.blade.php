<x-app-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-user me-2" style="color:#e94560;"></i>Profile Settings
                </h2>
                <p class="text-muted">Manage your account information</p>
            </div>
        </div>

        <div class="row g-4">

            <!-- Left — Avatar Card -->
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    @if(Auth::user()->avatar)
                        <img src="{{ Storage::url(Auth::user()->avatar) }}"
                             style="width:100px;height:100px;border-radius:50%;object-fit:cover;
                                    margin:0 auto 15px;border:4px solid #0f3460;"
                             alt="Profile Picture">
                    @else
                        <div style="width:100px;height:100px;border-radius:50%;
                                    background-color:#e94560;display:flex;align-items:center;
                                    justify-content:center;font-size:2.5rem;font-weight:700;
                                    color:#ffffff;margin:0 auto 15px;border:4px solid #0f3460;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif

                    <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>
                    <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                    <span class="badge mt-2" style="background-color:#e94560;">Administrator</span>

                    <hr style="border-color:#0f3460;">

                    <div class="text-start mb-3">
                        <p class="mb-2" style="color:#aaaaaa;font-size:0.85rem;">
                            <i class="fas fa-calendar me-2" style="color:#e94560;"></i>
                            Joined {{ Auth::user()->created_at->format('M d, Y') }}
                        </p>
                        <p class="mb-0" style="color:#aaaaaa;font-size:0.85rem;">
                            <i class="fas fa-shield-alt me-2" style="color:#e94560;"></i>
                            Account Active
                        </p>
                    </div>

                    <!-- Upload Profile Picture -->
                    <form method="POST" action="{{ route('profile.avatar') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <label class="form-label fw-bold" style="font-size:0.85rem;">
                            <i class="fas fa-camera me-1" style="color:#e94560;"></i>Change Photo
                        </label>
                        <input type="file" name="avatar"
                               class="form-control form-control-sm @error('avatar') is-invalid @enderror"
                               accept="image/*">
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">
                            <i class="fas fa-upload me-1"></i>Upload Photo
                        </button>
                        @if(session('status') === 'avatar-updated')
                            <div class="alert alert-success mt-2 p-2" style="font-size:0.82rem;">
                                <i class="fas fa-check-circle me-1"></i>Photo updated!
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Right — Forms -->
            <div class="col-md-8">

                <!-- Update Profile Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-edit me-2"></i>Update Profile Information
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user me-2" style="color:#e94560;"></i>Name
                                </label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-envelope me-2" style="color:#e94560;"></i>Email
                                </label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if(session('status') === 'profile-updated')
                                <div class="alert alert-success mb-3">
                                    <i class="fas fa-check-circle me-2"></i>Profile updated successfully!
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-lock me-2"></i>Update Password
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-lock me-2" style="color:#e94560;"></i>Current Password
                                </label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="currentPwd"
                                           class="form-control @error('current_password') is-invalid @enderror"
                                           placeholder="Enter current password">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('currentPwd', this)"
                                            style="border-color:#1a4a8a;background-color:#0f3460;color:#aaaaaa;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-key me-2" style="color:#e94560;"></i>New Password
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password" id="newPwd"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Enter new password">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('newPwd', this)"
                                            style="border-color:#1a4a8a;background-color:#0f3460;color:#aaaaaa;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-key me-2" style="color:#e94560;"></i>Confirm New Password
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="confirmPwd"
                                           class="form-control" placeholder="Confirm new password">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('confirmPwd', this)"
                                            style="border-color:#1a4a8a;background-color:#0f3460;color:#aaaaaa;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            @if(session('status') === 'password-updated')
                                <div class="alert alert-success mb-3">
                                    <i class="fas fa-check-circle me-2"></i>Password updated successfully!
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Password
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="card">
                    <div class="card-header" style="border-bottom-color:#dc3545;">
                        <i class="fas fa-exclamation-triangle me-2" style="color:#dc3545;"></i>
                        <span style="color:#dc3545;">Danger Zone</span>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-3">Once your account is deleted, all data will be permanently removed.</p>
                        <button type="button" class="btn btn-danger"
                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:#16213e;border:1px solid #0f3460;">
                <div class="modal-header" style="border-bottom:1px solid #0f3460;">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2" style="color:#dc3545;"></i>Delete Account
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p style="color:#aaaaaa;">Are you sure you want to delete your account? This cannot be undone!</p>
                    <form method="POST" action="{{ route('profile.destroy') }}" id="deleteForm">
                        @csrf
                        @method('delete')
                        <label class="form-label fw-bold">Enter your password to confirm:</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Enter your password">
                    </form>
                </div>
                <div class="modal-footer" style="border-top:1px solid #0f3460;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="deleteForm" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete Account
                    </button>
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