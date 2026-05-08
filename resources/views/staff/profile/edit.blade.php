<x-staff-layout>
<style>
    .flash-banner {
        position: fixed; top: 20px; left: 50%; transform: translateX(-50%);
        z-index: 9999; min-width: 340px; max-width: 560px;
        border-radius: 14px; padding: 15px 24px;
        font-size: 0.93rem; font-weight: 600;
        display: flex; align-items: center; gap: 12px;
        box-shadow: 0 10px 36px rgba(0,0,0,0.4);
        animation: bannerSlideDown 0.38s cubic-bezier(.21,1.02,.73,1) both;
    }
    .flash-banner.flash-success { background: linear-gradient(135deg,#10b981,#059669); color: #fff; }
    .flash-banner.flash-error   { background: linear-gradient(135deg,#ef4444,#b91c1c); color: #fff; }
    .flash-banner .flash-close  { margin-left: auto; background: rgba(255,255,255,0.25); border: none; color: #fff; border-radius: 50%; width: 26px; height: 26px; cursor: pointer; display:flex; align-items:center; justify-content:center; font-size:0.85rem; }
    .flash-banner .flash-close:hover { background: rgba(255,255,255,0.4); }
    @keyframes bannerSlideDown { from { top: -70px; opacity:0; } to { top: 20px; opacity:1; } }
</style>
    @php
        $staff = Auth::user()->staff;
    @endphp
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">
                    <i class="fas fa-user me-2" style="color:#e94560;"></i>My Profile
                </h2>
                <p class="text-muted">Manage your account information</p>
            </div>
        </div>

        <!-- TOP FLASH BANNER -->
        @php
            $pwdErrors  = $errors->passwordUpdate;
            $hasSuccess = session('success');
            $hasError   = session('error') || $errors->default->any();
            $hasPwdErr  = $pwdErrors->any();
            $flashType  = ($hasSuccess) ? 'flash-success' : 'flash-error';
            $flashMsg   = $hasSuccess ? session('success') :
                         (session('error') ? session('error') :
                         ($errors->default->any() ? 'Please fix the errors below.' : null));
        @endphp
        @if($hasSuccess || $hasError)
            <div class="flash-banner {{ $flashType }}" id="topFlashBanner">
                <i class="fas {{ $hasSuccess ? 'fa-check-circle' : 'fa-exclamation-circle' }} fa-lg"></i>
                <span>{{ $flashMsg }}</span>
                <button class="flash-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
            <script>setTimeout(()=>{ const b=document.getElementById('topFlashBanner'); if(b){b.style.opacity=0; setTimeout(()=>{b.remove();},400);} },5000);</script>
        @endif
        @if($hasPwdErr)
            <div class="flash-banner flash-error" id="pwdFlashBanner">
                <i class="fas fa-exclamation-circle fa-lg"></i>
                <div>
                    <div>Password update failed:</div>
                    <ul class="mb-0 mt-1" style="font-size:0.85rem; font-weight:400;">
                        @foreach($pwdErrors->all() as $err)<li>{{ $err }}</li>@endforeach
                    </ul>
                </div>
                <button class="flash-close" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
            <script>setTimeout(()=>{ const b=document.getElementById('pwdFlashBanner'); if(b){b.style.opacity=0; setTimeout(()=>{b.remove();},400);} },7000);</script>
        @endif

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
                    @if($staff)
                        <div class="text-start mb-3">
                            <p class="mb-2"><strong>First Name:</strong> {{ $staff->first_name }}</p>
                            <p class="mb-2"><strong>Last Name:</strong> {{ $staff->last_name }}</p>
                            <p class="mb-2"><strong>Gender:</strong> {{ str_replace('_', ' ', ucfirst($staff->gender ?? 'Not specified')) }}</p>
                            <p class="mb-2"><strong>Phone:</strong> {{ $staff->phone }}</p>
                            <p class="mb-2"><strong>Address:</strong> {{ $staff->address }}</p>
                            <p class="mb-2"><strong>Birthdate:</strong> {{ optional($staff->birthdate)->format('M d, Y') }}</p>
                            <p class="mb-0"><strong>Age:</strong> {{ $staff->age }}</p>
                        </div>
                    @endif
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

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-id-badge me-2" style="color:#e94560;"></i>First Name
                                    </label>
                                    <input type="text" name="first_name"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           value="{{ old('first_name', $staff?->first_name) }}" required>
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
                                           value="{{ old('last_name', $staff?->last_name) }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-user me-2" style="color:#e94560;"></i>Display Name
                                    </label>
                                    <input type="text" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', Auth::user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
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
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-phone me-2" style="color:#e94560;"></i>Phone
                                    </label>
                                    <input type="text" name="phone"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone', $staff?->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-venus-mars me-2" style="color:#e94560;"></i>Gender
                                    </label>
                                    <select name="gender"
                                            class="form-select @error('gender') is-invalid @enderror"
                                            required>
                                        <option value="">Select gender</option>
                                        <option value="male" {{ old('gender', $staff?->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $staff?->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $staff?->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                        <option value="prefer_not_to_say" {{ old('gender', $staff?->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-map-marker-alt me-2" style="color:#e94560;"></i>Address
                                </label>
                                <input type="text" name="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address', $staff?->address) }}" required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-calendar-alt me-2" style="color:#e94560;"></i>Birthdate
                                    </label>
                                    <input type="date" name="birthdate"
                                           class="form-control @error('birthdate') is-invalid @enderror"
                                           value="{{ old('birthdate', optional($staff?->birthdate)->format('Y-m-d')) }}" required>
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
                                           value="{{ old('age', $staff?->age) }}" min="16" max="120" required>
                                    @error('age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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

                            <!-- Current Password -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-lock me-2" style="color:#e94560;"></i>Current Password
                                </label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="currentPassword"
                                           class="form-control @if($errors->passwordUpdate->has('current_password')) is-invalid @endif"
                                           placeholder="Enter current password">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('currentPassword', this)"
                                            style="border-color:#1a4a8a;background-color:#0f3460;color:#aaaaaa;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @if($errors->passwordUpdate->has('current_password'))
                                    <div class="text-danger mt-1" style="font-size:0.82rem;"><i class="fas fa-exclamation-circle me-1"></i>{{ $errors->passwordUpdate->first('current_password') }}</div>
                                @endif
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-key me-2" style="color:#e94560;"></i>New Password
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password" id="newPassword"
                                           class="form-control @if($errors->passwordUpdate->has('password')) is-invalid @endif"
                                           placeholder="Enter new password">
                                    <button type="button" class="btn btn-outline-secondary"
                                            onclick="togglePassword('newPassword', this)"
                                            style="border-color:#1a4a8a;background-color:#0f3460;color:#aaaaaa;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @if($errors->passwordUpdate->has('password'))
                                    <div class="text-danger mt-1" style="font-size:0.82rem;"><i class="fas fa-exclamation-circle me-1"></i>{{ $errors->passwordUpdate->first('password') }}</div>
                                @endif
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