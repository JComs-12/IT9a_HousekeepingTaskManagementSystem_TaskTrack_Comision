<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaskTrack - Staff Portal</title>

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
            --sidebar-bg: rgba(11, 15, 25, 0.85);
        }
        * { font-family: 'Inter', sans-serif; }
        body { 
            background-color: var(--bg-color); 
            color: var(--text-main); 
            display: flex; min-height: 100vh; 
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Gradients */
        .bg-glow-1 {
            position: fixed;
            top: -20%;
            left: -10%;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(233,69,96,0.08) 0%, rgba(11,15,25,0) 70%);
            z-index: -1;
            animation: pulse 8s infinite alternate;
        }

        .bg-glow-2 {
            position: fixed;
            bottom: -20%;
            right: -10%;
            width: 70vw;
            height: 70vw;
            background: radial-gradient(circle, rgba(99,102,241,0.05) 0%, rgba(11,15,25,0) 70%);
            z-index: -1;
            animation: pulse 12s infinite alternate-reverse;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.1); opacity: 1; }
        }

        .sidebar {
            width: 260px; min-height: 100vh;
            background: var(--sidebar-bg);
            backdrop-filter: blur(12px); 
            border-right: 1px solid var(--card-border);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; z-index: 1000;
        }
        .sidebar-brand {
            padding: 18px 20px; border-bottom: 1px solid var(--card-border);
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-brand .brand-logo {
            width: 36px; height: 36px; object-fit: cover; border-radius: 50%; flex-shrink: 0; background-color: transparent;
        }
        .sidebar-brand .brand-icon {
            font-size: 1.5rem; color: var(--primary-color); display: none; flex-shrink: 0;
        }
        .sidebar-brand span { font-size: 1.3rem; font-weight: 800; color: var(--text-main); letter-spacing: -0.5px; }

        .sidebar-nav { padding: 20px 0; flex: 1; }
        .sidebar-label {
            font-size: 0.7rem; font-weight: 600; color: var(--text-muted); opacity: 0.7;
            text-transform: uppercase; letter-spacing: 1.5px; padding: 10px 20px 6px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 12px; padding: 12px 20px;
            color: var(--text-muted) !important; text-decoration: none;
            font-size: 0.95rem; font-weight: 500; transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background: rgba(255, 255, 255, 0.05); color: var(--text-main) !important; border-left-color: var(--primary-color);
        }
        .sidebar-link i { width: 20px; text-align: center; color: var(--primary-color); }

        .sidebar-footer { padding: 20px; border-top: 1px solid var(--card-border); }
        .user-info {
            display: flex; align-items: center; gap: 12px; padding: 10px;
            border-radius: 12px; background: rgba(255, 255, 255, 0.05); margin-bottom: 12px;
        }
        .user-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background-color: var(--primary-color);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 700; color: #ffffff;
            flex-shrink: 0; overflow: hidden;
        }
        .user-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .user-name { font-size: 0.9rem; font-weight: 600; color: var(--text-main); }
        .user-role { font-size: 0.75rem; color: var(--text-muted); opacity: 0.8; }

        .sidebar-footer-links { display: flex; flex-direction: column; gap: 4px; }
        .sidebar-footer-link {
            display: flex; align-items: center; gap: 10px; padding: 8px 12px;
            color: var(--text-muted) !important; text-decoration: none;
            font-size: 0.9rem; border-radius: 8px; transition: all 0.2s;
        }
        .sidebar-footer-link:hover { background: rgba(255, 255, 255, 0.05); color: var(--text-main) !important; }
        .sidebar-footer-link i { width: 16px; text-align: center; color: var(--primary-color); }

        .main-wrapper { margin-left: 260px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .top-bar {
            background: rgba(11, 15, 25, 0.7); backdrop-filter: blur(12px); border-bottom: 1px solid var(--card-border);
            padding: 16px 30px; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 999;
        }
        .top-bar-title { font-size: 1.1rem; font-weight: 600; color: var(--text-main); }
        .main-content  { padding: 30px; flex: 1; }

        .card { 
            background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; 
            backdrop-filter: blur(10px); box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background: rgba(255, 255, 255, 0.02); border-bottom: 1px solid var(--card-border);
            color: var(--text-main); font-weight: 600; border-radius: 16px 16px 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .btn { transition: all 0.3s; border-radius: 8px; font-weight: 500; }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); color: #ffffff; }
        .btn-primary:hover { background-color: var(--primary-hover); border-color: var(--primary-hover); color: #ffffff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(233,69,96,0.3); }
        .btn-warning:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(255,193,7,0.35); }
        .btn-danger:hover  { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220,53,69,0.35); }

        .table { color: var(--text-main); margin-bottom: 0; }
        .table thead th { background: rgba(255,255,255,0.05) !important; color: var(--text-muted) !important; border-bottom: 1px solid var(--card-border) !important; font-weight: 600; padding: 1rem; }
        .table-striped tbody tr:nth-of-type(odd) td  { background: rgba(255,255,255,0.02) !important; color: var(--text-main) !important; }
        .table-striped tbody tr:nth-of-type(even) td { background: transparent !important; color: var(--text-main) !important; }
        .table td, .table th { border-color: var(--card-border); color: var(--text-main) !important; padding: 1rem; vertical-align: middle; }
        .table tbody tr { transition: background-color 0.2s; }
        .table tbody tr:hover td { background: rgba(255,255,255,0.08) !important; }

        .form-control, .form-select {
            background-color: rgba(11, 15, 25, 0.5); border: 1px solid var(--card-border);
            color: var(--text-main); border-radius: 8px; padding: 0.6rem 1rem;
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(11, 15, 25, 0.8); border-color: var(--primary-color);
            color: var(--text-main); box-shadow: 0 0 0 0.2rem rgba(233,69,96,0.25);
        }
        .form-control::placeholder { color: rgba(255, 255, 255, 0.3); }
        .form-label { color: var(--text-main) !important; font-weight: 500; }
        p, h1, h2, h3, h4, h5, h6, label, span { color: var(--text-main); }
        .text-muted { color: var(--text-muted) !important; opacity: 0.8; }
        .alert { border-radius: 10px; backdrop-filter: blur(5px); }
        .alert-success { background: rgba(25, 135, 84, 0.1); border: 1px solid rgba(25, 135, 84, 0.3); color: #75b798; }
        .alert-danger  { background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); color: #ff6b6b; }
        .modal-backdrop { z-index: 99998 !important; }
        .modal          { z-index: 99999 !important; }
        .modal-content {
            background: var(--sidebar-bg); backdrop-filter: blur(15px);
            border: 1px solid var(--card-border); border-radius: 16px;
        }
        .modal-header, .modal-footer { border-color: var(--card-border); }
    </style>
</head>
<body>
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-brand">
            {{--
                LOGO in staff sidebar — same file: public/images/logo.png
            --}}
            <img src="{{ asset('images/logo.png') }}"
                 class="brand-logo" alt="TaskTrack"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='inline-block';">
            <i class="fas fa-broom brand-icon"></i>
            <span>TaskTrack</span>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-label">Staff Menu</div>

            <a href="{{ route('staff.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('staff.tasks') }}"
               class="sidebar-link {{ request()->routeIs('staff.tasks') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i> My Tasks
                @if(Auth::user()->unreadNotifications->where('type', 'App\Notifications\NewTaskAssigned')->count() > 0)
                    <span style="width: 10px; height: 10px; background-color: #e94560; border-radius: 50%; margin-left: auto; box-shadow: 0 0 5px #e94560;"></span>
                @endif
            </a>
            <a href="{{ route('staff.reports.index') }}"
               class="sidebar-link {{ request()->routeIs('staff.reports.*') ? 'active' : '' }}">
                <i class="fas fa-flag"></i> My Reports
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('staff.profile.edit') }}" class="user-info" style="text-decoration: none; color: inherit; cursor: pointer;">
                <div class="user-avatar">
                    @if(Auth::user()->avatar)
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">Staff Member</div>
                </div>
            </a>

            <div class="sidebar-footer-links">
                <a href="{{ route('staff.profile.edit') }}" class="sidebar-footer-link">
                    <i class="fas fa-user"></i> Profile
                </a>
                <button type="button"
                        class="sidebar-footer-link w-100 border-0 bg-transparent text-start"
                        data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>
    </div>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <div class="top-bar">
            <span class="top-bar-title">@yield('page-title', 'Staff Portal')</span>
            <span style="color:#aaaaaa;font-size:0.85rem;">
                <i class="fas fa-clock me-1" style="color:#e94560;"></i>
                {{ now()->format('D, M d Y') }}
            </span>
        </div>

        <div class="px-4 pt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <div class="main-content">
            {{ $slot }}
        </div>
    </div>

    <!-- LOGOUT MODAL -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">
                        <i class="fas fa-sign-out-alt me-2" style="color:var(--primary-color);"></i>Confirm Logout
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted" style="font-size:0.95rem;margin-bottom:0;">
                        Are you sure you want to logout?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>Yes, Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>