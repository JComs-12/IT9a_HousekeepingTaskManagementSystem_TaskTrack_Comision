<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskTrack - Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #1a1a2e;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }
        .register-card {
            background-color: #16213e;
            border: 1px solid #0f3460;
            border-radius: 15px;
            padding: 40px;
        }
        .register-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-logo i {
            font-size: 3rem;
            color: #e94560;
            display: none;
        }
        .register-logo img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 50%;
            background-color: #ffffff;
            margin-bottom: 10px;
        }
        .register-logo h2 {
            font-weight: 700;
            color: #ffffff;
            margin-top: 10px;
        }
        .register-logo p {
            color: #aaaaaa;
            font-size: 0.9rem;
        }
        .form-label {
            color: #ffffff;
            font-weight: 500;
        }
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
        .form-control::placeholder {
            color: #aaaaaa;
        }
        .btn-register {
            background-color: #e94560;
            border-color: #e94560;
            color: #ffffff;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 10px;
        }
        .btn-register:hover {
            background-color: #c73652;
            border-color: #c73652;
            color: #ffffff;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #aaaaaa;
        }
        .login-link a {
            color: #e94560;
            text-decoration: none;
            font-weight: 600;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
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
    <div class="register-container">
        <div class="register-card">

            <!-- Logo -->
            <div class="register-logo">
                <img src="{{ asset('images/logo.png') }}"
                     alt="TaskTrack Logo"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='block';">
                <i class="fas fa-broom"></i>
                <h2>TaskTrack</h2>
                <p>Create your account</p>
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
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Enter your password"
                           required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-lock me-2" style="color: #e94560;"></i>Confirm Password
                    </label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Confirm your password"
                           required>
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
</body>
</html>