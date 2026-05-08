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
                                    <label class="form-label fw-bold">First Name</label>
                                    <input type="text"
                                           name="first_name"
                                           class="form-control @error('first_name') is-invalid @enderror"
                                           placeholder="Enter first name"
                                           value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Last Name</label>
                                    <input type="text"
                                           name="last_name"
                                           class="form-control @error('last_name') is-invalid @enderror"
                                           placeholder="Enter last name"
                                           value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
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
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Gender</label>
                                    <select name="gender"
                                            class="form-select @error('gender') is-invalid @enderror">
                                        <option value="">Select gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                        <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                    @error('gender')
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

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <input type="text"
                                           name="address"
                                           class="form-control @error('address') is-invalid @enderror"
                                           placeholder="Enter address"
                                           value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Birthdate</label>
                                    <input type="date"
                                           name="birthdate"
                                           id="staffBirthdate"
                                           class="form-control @error('birthdate') is-invalid @enderror"
                                           value="{{ old('birthdate') }}"
                                           max="{{ now()->subYears(18)->format('Y-m-d') }}"
                                           onchange="calcAge()">
                                    <div id="staffAgeError" style="color:#f87171; font-size:0.82rem; margin-top:4px; display:none;">
                                        <i class="fas fa-exclamation-circle me-1"></i>Must be at least 18 years old.
                                    </div>
                                    @error('birthdate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        Age
                                        <small style="color:#475569; font-weight:400; font-size:0.72rem; margin-left:6px;">(auto-filled)</small>
                                    </label>
                                    {{-- Display only — backend computes age from birthdate --}}
                                    <input type="number" id="staffAgeDisplay"
                                           class="form-control"
                                           placeholder="Select birthdate first"
                                           disabled
                                           style="background:rgba(11,15,25,0.7); cursor:not-allowed; color:#e2e8f0; -webkit-text-fill-color:#e2e8f0; border-color:rgba(255,255,255,0.15);">
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
                            </div>

                            <div class="row">
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
        function calcAge() {
            const bd  = document.getElementById('staffBirthdate');
            const out = document.getElementById('staffAgeDisplay');
            const err = document.getElementById('staffAgeError');
            if (!bd || !bd.value) return;

            const dob   = new Date(bd.value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;

            out.value = age;

            if (age < 18) {
                err.style.display = 'block';
                bd.setCustomValidity('Must be at least 18 years old.');
            } else {
                err.style.display = 'none';
                bd.setCustomValidity('');
            }
        }

        document.addEventListener('DOMContentLoaded', calcAge);

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