<x-staff-layout>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-user me-2" style="color:#e94560;"></i>My Profile
                </h2>
                <p class="text-muted">Manage your account information</p>
            </div>
        </div>

        <div class="mb-4" style="position:sticky;top:80px;z-index:1000;">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>There was a problem updating your password.</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="row g-4">
            <!-- Avatar Card -->
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <!-- Show uploaded avatar or initials -->
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
                    <span class="badge mt-2" style="background-color:#0f3460;">
                        Housekeeping Staff
                    </span>
                    <hr style="border-color:#0f3460;">
                    <p class="mb-3" style="color:#aaaaaa;font-size:0.85rem;">
                        <i class="fas fa-calendar me-2" style="color:#e94560;"></i>
                        Joined {{ Auth::user()->created_at->format('M d, Y') }}
                    </p>

                    <!-- Upload Profile Picture -->
                    <form method="POST" action="{{ route('staff.profile.avatar') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <label class="form-label fw-bold" style="font-size:0.85rem;">
                            <i class="fas fa-camera me-1" style="color:#e94560;"></i>Change Photo
                        </label>
                        <input type="file" name="avatar" id="avatarInput"
                               class="form-control form-control-sm @error('avatar') is-invalid @enderror"
                               accept="image/*">
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">
                            <i class="fas fa-upload me-1"></i>Upload Photo
                        </button>
                    </form>
                </div>
            </div>

            <!-- Forms -->
            <div class="col-md-8">

                <!-- Update Profile -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-edit me-2"></i>Update Profile Information
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('staff.profile.update') }}">
                            @csrf
                            @method('PATCH')

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

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-lock me-2"></i>Update Password
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('staff.profile.password') }}">
                            @csrf
                            @method('PUT')

                            <!-- Current Password with toggle -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-lock me-2" style="color:#e94560;"></i>Current Password
                                </label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="currentPassword"
                                           class="form-control @error('current_password') is-invalid @enderror"
                                           placeholder="Enter current password">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('currentPassword', this)"
                                            style="border-color:#1a4a8a;background-color:#0f3460;color:#aaaaaa;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password with toggle -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-key me-2" style="color:#e94560;"></i>New Password
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password" id="newPassword"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Enter new password">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('newPassword', this)"
                                            style="border-color:#1a4a8a;background-color:#0f3460;color:#aaaaaa;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password with toggle -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-key me-2" style="color:#e94560;"></i>Confirm New Password
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="confirmPassword"
                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                           placeholder="Confirm new password">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('confirmPassword', this)"
                                            style="border-color:#1a4a8a;background-color:#0f3460;color:#aaaaaa;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Password
                            </button>
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
</x-staff-layout>