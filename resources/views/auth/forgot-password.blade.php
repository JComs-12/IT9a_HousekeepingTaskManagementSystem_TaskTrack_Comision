<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskTrack - Reset Password</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #e94560;
            --primary-hover: #d13d56;
            --bg-color: #0b0f19;
            --text-main: #ffffff;
            --text-muted: #e2e8f0;
            --card-bg: rgba(255, 255, 255, 0.05);
            --card-border: rgba(255, 255, 255, 0.1);
            --success-color: #10b981;
            --warning-color: #f59e0b;
        }
        * { font-family: 'Inter', sans-serif; }
        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Gradients */
        .bg-glow-1 {
            position: absolute;
            top: -20%;
            left: -10%;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(233,69,96,0.15) 0%, rgba(11,15,25,0) 70%);
            z-index: -1;
            animation: pulse 8s infinite alternate;
        }

        .bg-glow-2 {
            position: absolute;
            bottom: -20%;
            right: -10%;
            width: 70vw;
            height: 70vw;
            background: radial-gradient(circle, rgba(99,102,241,0.1) 0%, rgba(11,15,25,0) 70%);
            z-index: -1;
            animation: pulse 12s infinite alternate-reverse;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.1); opacity: 1; }
        }

        .reset-container { width: 100%; max-width: 500px; padding: 20px; z-index: 1; }
        .reset-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 40px;
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .reset-logo { text-align: center; margin-bottom: 30px; }
        .reset-logo img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 50%;
            background-color: transparent;
            margin-bottom: 10px;
        }
        .reset-logo .fallback-icon { font-size: 3rem; color: var(--primary-color); display: none; }
        .reset-logo h2 { font-weight: 800; color: var(--text-main); margin-top: 6px; letter-spacing: -0.5px; }
        .reset-logo p  { color: var(--text-muted); font-size: 0.9rem; }

        .form-label { color: var(--text-main); font-weight: 500; }
        .form-control {
            background-color: rgba(11, 15, 25, 0.5);
            border: 1px solid var(--card-border);
            color: var(--text-main);
            border-radius: 10px;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            background-color: rgba(11, 15, 25, 0.8);
            border-color: var(--primary-color);
            color: var(--text-main);
            box-shadow: 0 0 0 0.2rem rgba(233,69,96,0.25);
        }
        .form-control::placeholder { color: rgba(255, 255, 255, 0.3); }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .form-control.is-valid {
            border-color: var(--success-color);
        }

        .btn-reset {
            background-color: var(--primary-color);
            border: none;
            color: #ffffff;
            width: 100%;
            padding: 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(233,69,96,0.3);
        }
        .btn-reset:hover:not(:disabled) {
            background-color: var(--primary-hover);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(233,69,96,0.4);
        }
        .btn-reset:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-cancel {
            background-color: transparent;
            border: 1px solid var(--card-border);
            color: #aaaaaa;
            width: 100%;
            padding: 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 10px;
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: #aaaaaa;
            color: #ffffff;
        }

        .alert-info {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: #93c5fd;
            border-radius: 10px;
            backdrop-filter: blur(5px);
            font-size: 0.9rem;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }

        /* Email validation indicator */
        .email-validator {
            font-size: 0.85rem;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
        }
        .email-validator.valid {
            color: var(--success-color);
        }
        .email-validator.invalid {
            color: #ff6b6b;
        }
        .email-validator i {
            font-size: 0.9rem;
        }

        .progress-tracker {
            margin-bottom: 20px;
            padding: 12px;
            background: rgba(233, 69, 96, 0.05);
            border: 1px solid rgba(233, 69, 96, 0.2);
            border-radius: 10px;
        }
        .progress-step {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .progress-step:last-child {
            margin-bottom: 0;
        }
        .step-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(233, 69, 96, 0.2);
            color: var(--primary-color);
            font-size: 0.75rem;
            font-weight: bold;
        }
        .step-icon.done {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success-color);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        .back-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        .back-link a:hover {
            color: var(--primary-hover);
        }
    </style>
</head>
<body>
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>

    <div class="reset-container">
        <div class="reset-card">
            <!-- Logo -->
            <div class="reset-logo">
                <a href="{{ url('/') }}" style="text-decoration: none; color: inherit;">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="TaskTrack Logo"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
                    <i class="fas fa-broom fallback-icon"></i>
                    <h2>Password Recovery</h2>
                    <p>Reset your account password</p>
                </a>
            </div>

            <!-- Info Message -->
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>
                <small>Enter your email address and we'll send you a password reset link. Please check your inbox and spam folder.</small>
            </div>

            <!-- Success Message -->
            @if(session('status'))
                <div class="alert alert-success mb-4">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Progress Tracker -->
            <div class="progress-tracker">
                <div class="progress-step">
                    <div class="step-icon done">
                        <i class="fas fa-check"></i>
                    </div>
                    <span>Visit reset page</span>
                </div>
                <div class="progress-step" id="emailStep">
                    <div class="step-icon">1</div>
                    <span>Verify email address</span>
                </div>
                <div class="progress-step">
                    <div class="step-icon">2</div>
                    <span>Check your inbox for link</span>
                </div>
                <div class="progress-step">
                    <div class="step-icon">3</div>
                    <span>Click link and reset password</span>
                </div>
            </div>

            <!-- Reset Form -->
            <form method="POST" action="{{ route('password.email') }}" id="resetForm">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-envelope me-2" style="color: #e94560;"></i>Email Address
                    </label>
                    <input type="email"
                           name="email"
                           id="emailInput"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Enter your registered email"
                           value="{{ old('email') }}"
                           required
                           autofocus>
                    <div class="email-validator" id="emailValidator" style="display: none;">
                        <i class="fas fa-check-circle"></i>
                        <span>Email is valid</span>
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block" style="color: #ff6b6b; margin-top: 8px;">
                            <i class="fas fa-times-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-reset" id="submitBtn">
                        <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                    </button>
                    <a href="{{ route('login') }}" class="btn btn-cancel">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </form>

            <!-- Back Link -->
            <div class="back-link">
                Remember your password?
                <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const emailInput = document.getElementById('emailInput');
        const emailValidator = document.getElementById('emailValidator');
        const submitBtn = document.getElementById('submitBtn');

        // Real-time email validation
        emailInput.addEventListener('input', function() {
            const email = this.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && emailRegex.test(email)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                emailValidator.style.display = 'flex';
                emailValidator.classList.remove('invalid');
                emailValidator.classList.add('valid');
                submitBtn.disabled = false;
            } else if (email) {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
                emailValidator.style.display = 'flex';
                emailValidator.classList.remove('valid');
                emailValidator.classList.add('invalid');
                emailValidator.querySelector('i').className = 'fas fa-times-circle';
                emailValidator.querySelector('span').textContent = 'Invalid email format';
                submitBtn.disabled = true;
            } else {
                this.classList.remove('is-valid', 'is-invalid');
                emailValidator.style.display = 'none';
                submitBtn.disabled = false;
            }
        });

        // Form submission
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
        });
    </script>
</body>
</html>
