<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Staff Panel') - {{ config('app.name', 'Yujin Foto Studio') }}</title>

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
            /* Staff theme colors - teal/turquoise gradient */
            --primary-gradient: linear-gradient(135deg, #20b2aa 0%, #48cae4 100%);
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
            --primary-color: #20b2aa;
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
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15), 0 0 50px rgba(32, 178, 170, 0.1);
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
            background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
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
            background: linear-gradient(90deg, #20b2aa 0%, #48cae4 25%, #4facfe 50%, #00f2fe 75%, #20b2aa 100%);
            background-size: 300% 100%;
            animation: gradientShift 6s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .top-nav .page-title {
            background: linear-gradient(135deg, #20b2aa 0%, #48cae4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
        }
        
        .top-nav .page-subtitle {
            color: rgba(45, 55, 72, 0.7);
            font-weight: 500;
            position: relative;
            z-index: 2;
        }
        
        .top-nav .user-info {
            background: linear-gradient(135deg, rgba(32, 178, 170, 0.1) 0%, rgba(72, 202, 228, 0.1) 100%);
            border: 1px solid rgba(32, 178, 170, 0.2);
            border-radius: 20px;
            padding: 0.75rem 1.25rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 16px rgba(32, 178, 170, 0.1);
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }
        
        .top-nav .user-info:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(32, 178, 170, 0.15);
            border-color: rgba(32, 178, 170, 0.3);
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
        
        .avatar-circle {
            background: linear-gradient(135deg, #20b2aa 0%, #48cae4 100%);
            box-shadow: 0 4px 16px rgba(32, 178, 170, 0.3);
            transition: all 0.3s ease;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .avatar-circle:hover {
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 6px 20px rgba(32, 178, 170, 0.4);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #20b2aa 0%, #48cae4 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(32, 178, 170, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(32, 178, 170, 0.4);
            background: linear-gradient(135deg, #1a9a92 0%, #3bb5db 100%);
        }
        
        @stack('styles')
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <!-- Sidebar Header -->
                    <div class="sidebar-header">
                        <h4 class="text-white fw-bold mb-2">
                            <i class="bi bi-camera me-2"></i>
                            Yujin Studio
                        </h4>
                        <small class="text-white-50">Staff Panel</small>
                    </div>
                    
                    <!-- Main Navigation -->
                    <div class="nav-section">
                        <div class="nav-section-title">Dashboard</div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('staff.dashboard*') ? 'active' : '' }}" 
                                   href="{{ route('staff.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i>
                                    Halaman Utama
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Schedule Management -->
                    <div class="nav-section">
                        <div class="nav-section-title">Manajemen Jadwal</div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('staff.schedule*') ? 'active' : '' }}" 
                                   href="{{ route('staff.schedule') }}">
                                    <i class="bi bi-calendar2-event"></i>
                                    Jadwal Booking
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
                                <button type="submit" class="nav-link btn btn-link text-start w-100 border-0 p-0" 
                                        style="color: rgba(255, 255, 255, 0.8);">
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
                            <h1 class="h2 mb-0 text-primary fw-bold">@yield('page-title', 'Dashboard Staff')</h1>
                            <small class="text-muted">@yield('page-subtitle', 'Selamat datang di panel staff studio')</small>
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
                                        <small>Staff Studio</small>
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
                confirmButtonText: 'Ya, Lanjutkan!',
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
        
        @if(session('error'))
            showErrorAlert('Error!', '{{ session('error') }}');
        @endif
    </script>

    @stack('scripts')
</body>
</html>
