<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskTrack | Staff Task Tracking System</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        :root {
            --primary-color: #e94560;
            --primary-hover: #d13d56;
            --bg-color: #0b0f19;
            --text-main: #ffffff;
            --text-muted: #e2e8f0; /* Brighter for better contrast */
            --card-bg: rgba(255, 255, 255, 0.05);
            --card-border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow-x: hidden;
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Animated Background Gradients */
        .bg-glow-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(233,69,96,0.15) 0%, rgba(11,15,25,0) 70%);
            z-index: -1;
            animation: pulse 8s infinite alternate;
        }

        .bg-glow-2 {
            position: absolute;
            bottom: -10%;
            right: -10%;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(99,102,241,0.1) 0%, rgba(11,15,25,0) 70%);
            z-index: -1;
            animation: pulse 12s infinite alternate-reverse;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.1); opacity: 1; }
        }

        /* Hero Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .delay-100 { animation-delay: 150ms; }
        .delay-200 { animation-delay: 300ms; }
        .delay-300 { animation-delay: 450ms; }

        @keyframes gradientShimmer {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Navbar */
        .navbar {
            background: rgba(11, 15, 25, 0.8) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--card-border);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--text-main) !important;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: var(--text-main) !important;
            font-weight: 500;
            opacity: 0.85;
            position: relative;
            padding-bottom: 5px;
            transition: opacity 0.2s, color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            opacity: 1;
            color: var(--primary-color) !important;
        }

        /* Animated active indicator line */
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .nav-link:hover::after, .nav-link.active::after {
            width: 80%;
        }

        /* Buttons */
        .btn-custom {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border: none;
            color: #fff;
            box-shadow: 0 4px 15px rgba(233,69,96,0.3);
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(233,69,96,0.4);
            color: #fff;
        }

        .btn-outline-custom {
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-main);
        }

        .btn-outline-custom:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            color: #fff;
        }

        /* Hero Section */
        .hero {
            padding: 9rem 0 6rem;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero h1 {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -1.5px;
        }

        .text-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-gradient-primary {
            background: linear-gradient(270deg, #e94560, #ff8a9f, #e94560);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShimmer 4s ease infinite;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-muted); /* Brighter for contrast */
            margin-bottom: 2.5rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        /* Features */
        .features {
            padding: 6rem 0;
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .section-title p {
            font-size: 1.1rem;
            color: var(--text-muted);
        }

        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            backdrop-filter: blur(10px);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: rgba(233,69,96,0.4);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            background: rgba(255, 255, 255, 0.08);
        }

        .icon-box {
            width: 65px;
            height: 65px;
            border-radius: 16px;
            background: rgba(233,69,96,0.15);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .icon-box {
            background: var(--primary-color);
            color: #fff;
            transform: scale(1.1) rotate(5deg);
        }

        .feature-card h4 {
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .feature-card p {
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 0;
            font-size: 1.05rem;
        }

        /* Contact Section */
        .contact-section {
            padding: 6rem 0 3rem;
            background: linear-gradient(180deg, transparent 0%, rgba(233,69,96,0.05) 100%);
            border-top: 1px solid var(--card-border);
        }

        .contact-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .contact-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .contact-text {
            font-size: 1.2rem;
            color: var(--text-main);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Footer */
        footer {
            padding: 2rem 0;
            border-top: 1px solid var(--card-border);
            background-color: #080b13;
            margin-top: auto;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .footer-text {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            margin-right: 1.5rem;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 3rem; }
            .hero p { font-size: 1.1rem; }
        }
    </style>
</head>
<body>

    <!-- Background glow effects -->
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-4 px-lg-5">
            <a class="navbar-brand" href="#home">
                <img src="{{ asset('images/logo.png') }}" alt="TaskTrack Logo" height="35" class="me-2 rounded-circle" onerror="this.style.display='none';">
                TaskTrack
            </a>
            <button class="navbar-toggler navbar-dark border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                </ul>
                <div class="d-flex gap-3 mt-3 mt-lg-0">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary-custom btn-custom">Go to Dashboard</a>
                        @else
                            <a href="{{ url('/staff/dashboard') }}" class="btn btn-primary-custom btn-custom">Go to Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-custom btn-custom">Sign in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary-custom btn-custom">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero text-center">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h1 class="text-gradient animate-fade-in-up">Welcome to<br><span class="text-gradient-primary">TaskTrack</span></h1>
                    <p class="animate-fade-in-up delay-100">TaskTrack empowers staff and managers with fast task assignment, real-time status updates, and smooth communication so every team member can deliver better service with less friction.</p>
                    <div class="d-flex justify-content-center gap-3 mt-4 animate-fade-in-up delay-200">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary-custom btn-custom px-5 py-3 fs-5">Access Dashboard <i class="fas fa-arrow-right ms-2"></i></a>
                            @else
                                <a href="{{ url('/staff/dashboard') }}" class="btn btn-primary-custom btn-custom px-5 py-3 fs-5">Access Dashboard <i class="fas fa-arrow-right ms-2"></i></a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary-custom btn-custom px-5 py-3 fs-5">Get Started <i class="fas fa-arrow-right ms-2"></i></a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-custom btn-custom px-5 py-3 fs-5">Create Account</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about" style="padding: 6rem 0; background: rgba(255,255,255,0.02); border-top: 1px solid var(--card-border); border-bottom: 1px solid var(--card-border);">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1.5rem;">About <span style="color:var(--primary-color)">TaskTrack</span></h2>
                    <p style="font-size: 1.1rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.5rem;">
                        TaskTrack was built for frontline staff and supervisors who need a faster, clearer way to manage daily tasks and room readiness.
                    </p>
                    <p style="font-size: 1.1rem; color: var(--text-muted); line-height: 1.6;">
                        From task assignment to incident reporting, TaskTrack helps teams stay aligned, keeps communication simple, and gives managers the visibility they need without slowing anyone down.
                    </p>
                </div>
                <div class="col-lg-6 text-center">
                    <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 3rem; backdrop-filter: blur(10px);">
                        <i class="fas fa-hotel" style="font-size: 5rem; color: var(--primary-color); margin-bottom: 1.5rem;"></i>
                        <h4 style="font-weight: 700;">Built for Hospitality</h4>
                        <p style="color: var(--text-muted); margin-bottom: 0;">Designed from the ground up to solve the unique challenges faced by modern hotels and resorts.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services" style="padding: 6rem 0;">
        <div class="container-fluid px-4 px-lg-5">
            <div class="section-title">
                <h2>Our Core <span style="color:var(--primary-color)">Services</span></h2>
                <p>We provide a comprehensive suite of tools designed to optimize every facet of your housekeeping operations.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="feature-card d-flex align-items-start gap-4">
                        <div class="icon-box" style="margin-bottom: 0; flex-shrink: 0;">
                            <i class="fas fa-broom"></i>
                        </div>
                        <div>
                            <h4>Task Automation</h4>
                            <p>Automatically generate and assign daily cleaning tasks based on room checkout status and guest requests, ensuring nothing is missed.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card d-flex align-items-start gap-4">
                        <div class="icon-box" style="margin-bottom: 0; flex-shrink: 0;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h4>Performance Analytics</h4>
                            <p>Gain insights into your staff's efficiency and room turnaround times with our built-in analytics and activity logs.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card d-flex align-items-start gap-4">
                        <div class="icon-box" style="margin-bottom: 0; flex-shrink: 0;">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h4>Incident Reporting</h4>
                            <p>Allow staff to instantly log maintenance issues or damages discovered during cleaning directly to the administrative dashboard.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card d-flex align-items-start gap-4">
                        <div class="icon-box" style="margin-bottom: 0; flex-shrink: 0;">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div>
                            <h4>Mobile-Ready Portal</h4>
                            <p>A responsive, mobile-friendly staff portal ensures your team can check tasks and update statuses on-the-go from any device.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features" style="background: rgba(255,255,255,0.02); border-top: 1px solid var(--card-border);">
        <div class="container-fluid px-4 px-lg-5">
            <div class="section-title">
                <h2>Why Choose <span style="color:var(--primary-color)">TaskTrack?</span></h2>
                <p>Everything you need to run a flawless housekeeping operation with precision and accountability.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <h4>Room Management</h4>
                        <p>Easily add, organize, and monitor the status of every room in your facility. Keep track of what needs attention instantly.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Staff Allocation</h4>
                        <p>Assign specific housekeeping staff to specific rooms. Ensure your team knows exactly where to be and what to do.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h4>Real-Time Tracking</h4>
                        <p>Monitor task statuses from Pending, In Progress, to Completed. Administrators receive instant notifications upon completion.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container-fluid px-4 px-lg-5">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="footer-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="TaskTrack Logo" height="30" class="rounded-circle" onerror="this.style.display='none';">
                        TaskTrack
                    </div>
                    <div class="footer-text">
                        &copy; {{ date('Y') }} JComs-12 TaskTrack. All rights reserved.<br>
                        A comprehensive Housekeeping Task Management System.
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="footer-links">
                        <a href="#home">Home</a>
                        <a href="#about">About</a>
                        <a href="#services">Services</a>
                        <a href="#features">Features</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').style.background = 'rgba(11, 15, 25, 0.95)';
                document.querySelector('.navbar').style.setProperty('backdrop-filter', 'blur(12px)', 'important');
                document.querySelector('.navbar').style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.5)';
            } else {
                document.querySelector('.navbar').style.background = 'rgba(11, 15, 25, 0.8)';
                document.querySelector('.navbar').style.boxShadow = 'none';
            }
        });

        // Robust Active Link Highlighting (Scrollspy)
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

        function updateActiveLink() {
            let current = '';
            
            // Find which section is currently in view
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                // Offset by 200px to trigger slightly before the section hits the very top
                if (window.pageYOffset >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });

            // If we are at the very top of the page, force 'home' to be active
            if (window.pageYOffset < 100) {
                current = 'home';
            }

            // Update classes
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        }

        // Run on scroll
        window.addEventListener('scroll', updateActiveLink);
        // Run once on load
        updateActiveLink();

        // Also add click event listeners to update immediately on click
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
