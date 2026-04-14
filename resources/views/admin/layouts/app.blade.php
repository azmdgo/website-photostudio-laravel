<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Yujin Foto Studio') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- FontAwesome Icons -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            --secondary-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            --purple-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --blue-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --pink-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --green-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            
            /* Enhanced color palette */
            --primary-color: #dc3545;
            --secondary-color: #4facfe;
            --accent-color: #fa709a;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --border-color: #e2e8f0;
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-light: 0 8px 32px rgba(31, 38, 135, 0.15);
            --shadow-medium: 0 8px 32px rgba(31, 38, 135, 0.25);
            --shadow-heavy: 0 15px 45px rgba(31, 38, 135, 0.35);
        }
        
        /* Glass morphism effect */
        .glass {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-light);
        }
        
        /* Enhanced scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.1));
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.2));
        }
        
        .sidebar {
            min-height: 100vh;
            background: var(--primary-gradient);
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15), 0 0 50px rgba(220, 53, 69, 0.1);
            border-radius: 0 20px 20px 0;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
            pointer-events: none;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 0.875rem 1.25rem;
            margin: 0.25rem 0.5rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.5s ease;
        }
        
        .sidebar .nav-link:hover::before {
            left: 100%;
        }
        
        .sidebar .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .sidebar .nav-link:hover::after {
            width: 80%;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            transform: translateX(8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .sidebar .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            font-size: 1.1rem;
        }
        
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }
        
        .sidebar-header h4 {
            background: linear-gradient(45deg, #fff, #e3f2fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        
        .nav-section {
            margin-bottom: 1.5rem;
        }
        
        .nav-section-title {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin: 1rem 1rem 0.5rem 1rem;
        }
        
        .main-content {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 0;
        }
        
        .top-nav {
background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.9) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 0 0 25px 25px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15), 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .top-nav::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #dc3545 0%, #c82333 25%, #e74c3c 50%, #dc3545 75%, #c82333 100%);
            background-size: 300% 100%;
            animation: gradientShift 6s ease infinite;
        }
        
        .top-nav::after {
            content: '';
            position: absolute;
            top: 0;
            left: -50%;
            width: 200%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: skewX(-20deg);
            animation: shimmer 3s infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%) skewX(-20deg); }
            100% { transform: translateX(100%) skewX(-20deg); }
        }
        
        .top-nav:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 48px rgba(135, 31, 31, 0.2), 0 4px 16px rgba(0, 0, 0, 0.1);
        }
        
        .top-nav .page-title {
            color: #ea6666 !important;
            font-weight: 700;
            text-shadow: none;
            position: relative;
            z-index: 2;
        }
        
        .top-nav .page-subtitle {
            color: rgba(72, 45, 45, 0.7);
            font-weight: 500;
            position: relative;
            z-index: 2;
        }
        
        .top-nav .user-info {
            background: linear-gradient(135deg, rgba(233, 105, 105, 0.1) 0%, rgba(254, 147, 75, 0.1) 100%);
            border: 1px solid rgba(234, 102, 102, 0.2);
            border-radius: 20px;
            padding: 0.75rem 1.25rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 16px rgba(234, 102, 102, 0.1);
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }
        
        .top-nav .user-info:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
            border-color: rgba(102, 126, 234, 0.3);
        }
        
        .top-nav .user-info .fw-semibold {
            color: #2c1a1a;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .top-nav .user-info small {
            color: rgba(72, 45, 45, 0.85);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        
        .top-nav .avatar-circle {
            background: linear-gradient(135deg, #ff3301 0%, #ff0000 100%);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }
        
        .top-nav .avatar-circle:hover {
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 6px 20px rgba(234, 102, 102, 0.425);
        }
        
        .card {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .stats-card {
            background: var(--primary-gradient);
            color: white;
            position: relative;
            overflow: hidden;
            border-radius: 1.5rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .stats-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(40px, -40px);
        }
        
        .stats-card .card-body {
            padding: 1.75rem;
            position: relative;
            z-index: 1;
        }
        
        .stats-card .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .stats-card .stats-label {
            font-size: 0.9rem;
            font-weight: 500;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stats-card .stats-icon {
            font-size: 3rem;
            opacity: 0.6;
            transition: all 0.3s ease;
        }
        
        .stats-card:hover .stats-icon {
            transform: scale(1.1) rotate(5deg);
            opacity: 0.8;
        }
        
        .stats-card-success {
            background: var(--success-gradient);
            color: white;
        }
        
        .stats-card-warning {
            background: var(--warning-gradient);
            color: white;
        }
        
        .stats-card-info {
            background: var(--info-gradient);
            color: white;
        }
        
        .stats-card-purple {
            background: var(--purple-gradient);
            color: white;
        }
        
        .stats-card-blue {
            background: var(--blue-gradient);
            color: white;
        }
        
        .stats-card-pink {
            background: var(--pink-gradient);
            color: white;
        }
        
        .stats-card-green {
            background: var(--green-gradient);
            color: white;
        }
        
        .stats-card-dark {
            background: var(--dark-gradient);
            color: white;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: #667eea !important;
        }
        
        .alert {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .table {
            border-radius: 15px;
            overflow: hidden;
        }
        
        .nav-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            margin: 1.5rem 1rem;
        }
        
        .user-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 0.75rem 1rem;
            margin: 0.5rem;
        }
        
        .logout-btn {
            background: transparent;
            border-radius: 10px;
            margin: 0.5rem;
            transition: all 0.3s ease;
            border: none;
        }
        
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .logout-btn .nav-link {
            background: transparent !important;
            border: none !important;
            padding: 0.875rem 1.25rem !important;
        }
        
        .logout-btn .nav-link:hover {
            background: transparent !important;
        }
        
        .avatar-circle {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        /* Admin Footer Styling */
        .admin-footer {
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        
        
        .admin-footer p {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            color: #6c757d;
            letter-spacing: 0.3px;
            margin: 0;
        }
        
        .admin-footer small {
            font-size: 0.8rem;
            color: #495057;
            font-weight: 600;
        }
        
        /* Responsive improvements */
        @media (max-width: 768px) {
            .sidebar {
                border-radius: 0;
            }
            
            .card {
                margin-bottom: 1rem;
            }
        }
        
        /* Animation for page transitions */
        .main-content {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <div class="sidebar-header">
                        <h4 class="text-white fw-bold mb-2">
                            <i class="bi bi-camera me-2"></i>
                            Yujin Studio
                        </h4>
                        <small class="text-white-50">Admin Panel</small>
                    </div>
                    
                    <!-- Main Navigation -->
                    <div class="nav-section">
                        <div class="nav-section-title">Dashboard</div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" 
                                   href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i>
                                    Halaman Utama
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Booking Management -->
                    <div class="nav-section">
                        <div class="nav-section-title">Manajemen Booking</div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.bookings*') ? 'active' : '' }}" 
                                   href="{{ route('admin.bookings.index') }}">
                                    <i class="bi bi-calendar-check"></i>
                                    Pemesanan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.schedule*') ? 'active' : '' }}" 
                                   href="{{ route('admin.schedule.index') }}">
                                    <i class="bi bi-calendar2-event"></i>
                                    Jadwal Pesanan
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Content Management -->
                    <div class="nav-section">
                        <div class="nav-section-title">Manajemen Konten</div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}" 
                                   href="{{ route('admin.services.index') }}">
                                    <i class="bi bi-camera-reels"></i>
                                    Layanan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
                                   href="{{ route('admin.users') }}">
                                    <i class="bi bi-people"></i>
                                    Pengguna
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Analytics -->
                    <div class="nav-section">
                        <div class="nav-section-title">Analitik</div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.business-intelligence*') ? 'active' : '' }}" 
                                   href="{{ route('admin.business-intelligence') }}">
                                    <i class="bi bi-graph-up"></i>
                                    Business Intelligence
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Settings -->
                    <div class="nav-section">
                        <div class="nav-section-title">Sistem</div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" 
                                   href="{{ route('admin.settings') }}">
                                    <i class="bi bi-gear"></i>
                                    Pengaturan
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Footer Navigation -->
                    <div class="nav-divider"></div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                                <i class="bi bi-box-arrow-up-right"></i>
                                Lihat Website
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="logout-btn">
                                @csrf
                                <button type="submit" class="nav-link w-100 text-start" 
                                        style="color: rgba(255, 255, 255, 0.85); background: transparent; border: none; font-weight: 500;">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top Navigation -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-3 mb-4 top-nav px-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <h1 class="h2 mb-0 fw-bold page-title">@yield('page-title', 'Halaman Utama')</h1>
                            <small class="text-muted">@yield('page-subtitle', 'Selamat datang di panel admin')</small>
                        </div>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="d-flex align-items-center">
                            <div class="user-info me-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                                        <small>Administrator</small>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group">
                                @yield('page-actions')
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                <div class="container-fluid px-0">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="admin-footer">
        <div class="text-end py-3 pe-4">
            <p class="mb-0">
                <small>&copy; {{ date('Y') }} Yujin Foto Studio. All rights reserved.</small>
            </p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Global SweetAlert2 Functions -->
    <script>
        // Global SweetAlert utility functions
        window.showAlert = function(type, title, text, options = {}) {
            const defaultOptions = {
                icon: type,
                title: title,
                text: text,
                showConfirmButton: true,
                confirmButtonText: 'OK',
                timer: type === 'success' ? 3000 : null,
                timerProgressBar: type === 'success',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            };
            
            return Swal.fire(Object.assign(defaultOptions, options));
        };
        
        window.showConfirmDialog = function(title, text, options = {}) {
            const defaultOptions = {
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            };
            
            return Swal.fire(Object.assign(defaultOptions, options));
        };
        
        window.showSuccessAlert = function(title, text = '') {
            return showAlert('success', title, text);
        };
        
        window.showErrorAlert = function(title, text = '') {
            return showAlert('error', title, text);
        };
        
        window.showInfoAlert = function(title, text = '') {
            return showAlert('info', title, text);
        };
        
        window.showWarningAlert = function(title, text = '') {
            return showAlert('warning', title, text);
        };
        
        // Show success message if exists in session
        @if(session('success'))
            showSuccessAlert('Berhasil!', '{{ session('success') }}');
        @endif
        
        // Show error message if exists in session
        @if(session('error'))
            showErrorAlert('Gagal!', '{{ session('error') }}');
        @endif
    </script>
    
    @stack('scripts')
</body>
</html>
