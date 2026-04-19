<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TaskTrack - Staff Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background-color: #0f0f1a; color: #ffffff; display: flex; min-height: 100vh; }

        .sidebar {
            width: 260px; min-height: 100vh;
            background-color: #16213e; border-right: 1px solid #0f3460;
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; z-index: 1000;
        }
        .sidebar-brand {
            padding: 18px 20px; border-bottom: 1px solid #0f3460;
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-brand .brand-logo {
            width: 36px; height: 36px; object-fit: cover; border-radius: 50%; flex-shrink: 0; background-color: #ffffff;
        }
        .sidebar-brand .brand-icon {
            font-size: 1.5rem; color: #e94560; display: none; flex-shrink: 0;
        }
        .sidebar-brand span { font-size: 1.3rem; font-weight: 700; color: #ffffff; }

        .sidebar-nav { padding: 20px 0; flex: 1; }
        .sidebar-label {
            font-size: 0.7rem; font-weight: 600; color: #aaaaaa;
            text-transform: uppercase; letter-spacing: 1.5px; padding: 10px 20px 6px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 12px; padding: 12px 20px;
            color: #aaaaaa !important; text-decoration: none;
            font-size: 0.9rem; font-weight: 500; transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            background-color: #0f3460; color: #ffffff !important; border-left-color: #e94560;
        }
        .sidebar-link i { width: 20px; text-align: center; color: #e94560; }

        .sidebar-footer { padding: 20px; border-top: 1px solid #0f3460; }
        .user-info {
            display: flex; align-items: center; gap: 12px; padding: 10px;
            border-radius: 10px; background-color: #0f3460; margin-bottom: 12px;
        }
        .user-avatar {
            width: 40px; height: 40px; border-radius: 50%;
            background-color: #e94560;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; font-weight: 700; color: #ffffff;
            flex-shrink: 0; overflow: hidden;
        }
        .user-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .user-name { font-size: 0.85rem; font-weight: 600; color: #ffffff; }
        .user-role { font-size: 0.75rem; color: #aaaaaa; }

        .sidebar-footer-links { display: flex; flex-direction: column; gap: 4px; }
        .sidebar-footer-link {
            display: flex; align-items: center; gap: 10px; padding: 8px 12px;
            color: #aaaaaa !important; text-decoration: none;
            font-size: 0.85rem; border-radius: 8px; transition: all 0.2s;
        }
        .sidebar-footer-link:hover { background-color: #0f3460; color: #ffffff !important; }
        .sidebar-footer-link i { width: 16px; text-align: center; color: #e94560; }

        .main-wrapper { margin-left: 260px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .top-bar {
            background-color: #16213e; border-bottom: 1px solid #0f3460;
            padding: 16px 30px; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 999;
        }
        .top-bar-title { font-size: 1rem; font-weight: 600; color: #ffffff; }
        .main-content  { padding: 30px; flex: 1; }

        .card { background-color: #16213e; border: 1px solid #0f3460; border-radius: 12px; }
        .card-header {
            background-color: #0f3460; border-bottom: 1px solid #e94560;
            color: #ffffff; font-weight: 600; border-radius: 12px 12px 0 0 !important;
        }

        .btn { transition: all 0.2s; }
        .btn-primary { background-color: #e94560; border-color: #e94560; color: #ffffff; }
        .btn-primary:hover { background-color: #c73652; border-color: #c73652; color: #ffffff; transform: translateY(-1px); }
        .btn-warning:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(255,193,7,0.35); }
        .btn-danger:hover  { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(220,53,69,0.35); }

        .table { color: #ffffff; }
        .table thead th { background-color: #0f3460 !important; color: #ffffff !important; }
        .table-striped tbody tr:nth-of-type(odd) td  { background-color: #1a1a2e !important; color: #ffffff !important; }
        .table-striped tbody tr:nth-of-type(even) td { background-color: #16213e !important; color: #ffffff !important; }
        .table td, .table th { border-color: #0f3460; color: #ffffff !important; }
        .table tbody tr { transition: background-color 0.18s; }
        .table tbody tr:hover td { background-color: #1e2d50 !important; }

        .form-control, .form-select {
            background-color: #0f3460; border: 1px solid #1a4a8a;
            color: #ffffff; border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            background-color: #0f3460; border-color: #e94560;
            color: #ffffff; box-shadow: 0 0 0 0.2rem rgba(233,69,96,0.25);
        }
        .form-control::placeholder { color: #aaaaaa; }
        .form-label { color: #ffffff !important; font-weight: 500; }
        p, h1, h2, h3, h4, h5, h6, label, span { color: #ffffff; }
        .text-muted { color: #aaaaaa !important; }
        .alert-success { background-color: #0d3320; border-color: #198754; color: #75b798; }
        .alert-danger  { background-color: #2d1b1b; border-color: #dc3545; color: #f1aeb5; }
        .modal-backdrop { z-index: 99998 !important; }
        .modal          { z-index: 99999 !important; }
    </style>
</head>
<body>

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
            </a>
            <a href="{{ route('staff.reports.index') }}"
               class="sidebar-link {{ request()->routeIs('staff.reports.*') ? 'active' : '' }}">
                <i class="fas fa-flag"></i> My Reports
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    @if(Auth::user()->avatar)
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                    <div class="user-role">Staff</div>
                </div>
            </div>

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
            <div class="modal-content" style="background-color:#16213e;border:1px solid #0f3460;">
                <div class="modal-header" style="border-bottom:1px solid #0f3460;">
                    <h6 class="modal-title">
                        <i class="fas fa-sign-out-alt me-2" style="color:#e94560;"></i>Confirm Logout
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p style="color:#aaaaaa;font-size:0.9rem;margin-bottom:0;">
                        Are you sure you want to logout?
                    </p>
                </div>
                <div class="modal-footer" style="border-top:1px solid #0f3460;">
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