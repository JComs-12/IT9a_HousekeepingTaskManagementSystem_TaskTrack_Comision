<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskTrack - Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }
        body {
            background-color: #1a1a2e;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container { width: 100%; max-width: 450px; padding: 20px; }
        .login-card {
            background-color: #16213e;
            border: 1px solid #0f3460;
            border-radius: 15px;
            padding: 40px;
        }
        .login-logo { text-align: center; margin-bottom: 30px; }
        .login-logo img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 50%;
            background-color: #ffffff;
            margin-bottom: 10px;
        }
        /* Fallback icon shown only if logo.png fails to load */
        .login-logo .fallback-icon { font-size: 3rem; color: #e94560; display: none; }
        .login-logo h2 { font-weight: 700; color: #ffffff; margin-top: 6px; }
        .login-logo p  { color: #aaaaaa; font-size: 0.9rem; }

        .form-label { color: #ffffff; font-weight: 500; }
        .form-control {
            background-color: #0f3460;
            border: 1px solid #e94560;
            color: #ffffff;
            border-radius: 8px;
            padding: 12px 15px;
        }
        .form-control:focus {
            background-color: #0f3460;
            border-color: #e94560;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(233,69,96,0.25);
        }
        .form-control::placeholder { color: #aaaaaa; }

        /* Password wrapper keeps the eye btn flush */
        .password-wrapper { position: relative; }
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
        .password-wrapper .toggle-pwd:hover { color: #e94560; }
        .password-wrapper .form-control { padding-right: 42px; }

        .btn-login {
            background-color: #e94560;
            border-color: #e94560;
            color: #ffffff;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 10px;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background-color: #c73652;
            border-color: #c73652;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(233,69,96,0.45);
        }

        /* Remember me — white text */
        .form-check-label { color: #ffffff !important; font-size: 0.88rem; }
        .form-check-input:checked { background-color: #e94560; border-color: #e94560; }

        .forgot-link { color: #aaaaaa; font-size: 0.85rem; text-decoration: none; }
        .forgot-link:hover { color: #e94560; }

        .register-link { text-align: center; margin-top: 20px; color: #aaaaaa; }
        .register-link a { color: #e94560; text-decoration: none; font-weight: 600; }
        .register-link a:hover { text-decoration: underline; }

        .alert-danger {
            background-color: #2d1b1b;
            border-color: #e94560;
            color: #ff6b6b;
            border-radius: 8px;
        }
        .quote {
            text-align: center;
            color: #aaaaaa;
            font-style: italic;
            font-size: 0.85rem;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #0f3460;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">

            <!-- Logo -->
            <div class="login-logo">
                {{--
                    LOGO: The file public/images/logo.png is already in your project.
                    The <img> below points to it via asset(). If you ever move the file,
                    update the path here. The fallback icon shows automatically if the
                    image fails to load (via onerror).
                --}}
                <img src="{{ asset('images/logo.png') }}"
                     alt="TaskTrack Logo"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
                <i class="fas fa-broom fallback-icon"></i>
                <h2>TaskTrack</h2>
                <p>Housekeeping Task Management System</p>
            </div>

            <!-- Session Status -->
            @if(session('status'))
                <div class="alert alert-success mb-3">{{ session('status') }}</div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-envelope me-2" style="color:#e94560;"></i>Email
                    </label>
                    <input type="email" name="email" class="form-control"
                           placeholder="Enter your email"
                           value="{{ old('email') }}" required autofocus>
                </div>

                <!-- Password with eye toggle -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-lock me-2" style="color:#e94560;"></i>Password
                    </label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="loginPassword"
                               class="form-control"
                               placeholder="Enter your password" required>
                        <button type="button" class="toggle-pwd"
                                onclick="toggleLoginPassword()">
                            <i class="fas fa-eye" id="loginPasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                               name="remember" id="remember_me">
                        <label class="form-check-label" for="remember_me">
                            Remember me
                        </label>
                    </div>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </button>
            </form>

            <!-- Register Link -->
            <div class="register-link">
                Don't have an account? <a href="{{ route('register') }}">Register here</a>
            </div>

            <div class="quote">"The best way to get something done is to begin."</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleLoginPassword() {
            const input = document.getElementById('loginPassword');
            const icon  = document.getElementById('loginPasswordIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>