<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskTrack - Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
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
        }
        * {
            font-family: 'Inter', sans-serif;
        }
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

        .register-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            z-index: 1;
        }
        .register-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 40px;
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .register-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-logo i {
            font-size: 3rem;
            color: var(--primary-color);
            display: none;
        }
        .register-logo img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 50%;
            background-color: transparent;
            margin-bottom: 10px;
        }
        .register-logo h2 {
            font-weight: 800;
            color: var(--text-main);
            margin-top: 10px;
            letter-spacing: -0.5px;
        }
        .register-logo p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        .form-label {
            color: var(--text-main);
            font-weight: 500;
        }
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
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }
        .btn-register {
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
        .btn-register:hover {
            background-color: var(--primary-hover);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(233,69,96,0.4);
        }
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
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: var(--text-muted);
        }
        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .login-link a:hover {
            color: var(--primary-hover);
        }
        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ff6b6b;
            border-radius: 10px;
            backdrop-filter: blur(5px);
        }
        .quote {
            text-align: center;
            color: rgba(255, 255, 255, 0.4);
            font-style: italic;
            font-size: 0.85rem;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--card-border);
        }
    </style>
</head>
<body>
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>

    <div class="register-container">
        <div class="register-card">

            <!-- Logo -->
            <div class="register-logo">
                <a href="{{ url('/') }}" style="text-decoration: none; color: inherit;">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="TaskTrack Logo"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
                    <i class="fas fa-broom"></i>
                    <h2>TaskTrack</h2>
                    <p>Create your account</p>
                </a>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-user me-2" style="color: #e94560;"></i>Name
                    </label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Enter your full name"
                           value="{{ old('name') }}"
                           required autofocus>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-envelope me-2" style="color: #e94560;"></i>Email
                    </label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Enter your email"
                           value="{{ old('email') }}"
                           required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-lock me-2" style="color: #e94560;"></i>Password
                    </label>
                    <div class="password-wrapper">
                        <input type="password"
                               name="password"
                               id="registerPassword"
                               class="form-control"
                               placeholder="Enter your password"
                               required>
                        <button type="button" class="toggle-pwd" onclick="toggleRegisterPassword()">
                            <i class="fas fa-eye" id="registerPasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-lock me-2" style="color: #e94560;"></i>Confirm Password
                    </label>
                    <div class="password-wrapper">
                        <input type="password"
                               name="password_confirmation"
                               id="registerConfirmPassword"
                               class="form-control"
                               placeholder="Confirm your password"
                               required>
                        <button type="button" class="toggle-pwd" onclick="toggleRegisterConfirmPassword()">
                            <i class="fas fa-eye" id="registerConfirmPasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Register Button -->
                <button type="submit" class="btn btn-register">
                    <i class="fas fa-user-plus me-2"></i>Register
                </button>

            </form>

            <!-- Login Link -->
            <div class="login-link">
                Already have an account?
                <a href="{{ route('login') }}">Login here</a>
            </div>

            <!-- Quote -->
            <div class="quote">
                "The best way to get something done is to begin."
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleRegisterPassword() {
            const input = document.getElementById('registerPassword');
            const icon  = document.getElementById('registerPasswordIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function toggleRegisterConfirmPassword() {
            const input = document.getElementById('registerConfirmPassword');
            const icon  = document.getElementById('registerConfirmPasswordIcon');
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