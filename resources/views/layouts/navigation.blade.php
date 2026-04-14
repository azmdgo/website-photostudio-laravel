<!-- Enhanced Navigation Bar -->
<nav class="bg-white bg-opacity-95 shadow-xl border-b border-indigo-100 sticky top-0 z-50 transition-all duration-500" id="main-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo Section -->
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ route('customer.dashboard') }}" class="group flex items-center space-x-3 text-xl font-bold transition-all duration-300">
                        <div class="relative w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 group-hover:shadow-2xl">
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-400 via-purple-400 to-pink-400 rounded-2xl blur opacity-70 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <svg class="h-7 w-7 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="hidden sm:block">
                            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent font-bold text-xl tracking-tight">
                                Yujin Foto Studio
                            </div>
                            <div class="text-xs text-gray-500 font-medium tracking-wide">Professional Photography</div>
                        </div>
                    </a>
                </div>

                <!-- Premium Navigation Links -->
                <div class="hidden sm:ml-12 sm:flex sm:items-center sm:space-x-1">
                    @php
                        $navItems = [
                            'dashboard' => ['name' => 'Beranda', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'color' => 'from-blue-500 to-cyan-500'],
                            'services' => ['name' => 'Layanan', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'color' => 'from-emerald-500 to-teal-500'],
                            'booking' => ['name' => 'Pesan Layanan', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'color' => 'from-violet-500 to-purple-500'],
                            'orders' => ['name' => 'Status Pembayaran', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'from-amber-500 to-orange-500'],
                            'about' => ['name' => 'Tentang Kami', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'from-rose-500 to-pink-500']
                        ];
                    @endphp

                    @foreach($navItems as $route => $item)
                        @php
                            $colorMap = [
                                'from-blue-500 to-cyan-500' => ['#3b82f6', '#06b6d4'],
                                'from-emerald-500 to-teal-500' => ['#10b981', '#14b8a6'],
                                'from-violet-500 to-purple-500' => ['#8b5cf6', '#a855f7'],
                                'from-amber-500 to-orange-500' => ['#f59e0b', '#f97316'],
                                'from-rose-500 to-pink-500' => ['#f43f5e', '#ec4899']
                            ];
                            $colors = $colorMap[$item['color']] ?? ['#3b82f6', '#06b6d4'];
                        @endphp
                        
                        <a href="{{ route('customer.' . $route) }}" 
                           class="nav-item group relative px-4 py-2.5 text-sm font-semibold rounded-xl transition-all duration-300 flex items-center justify-center space-x-2.5 {{ request()->routeIs('customer.' . $route) ? 'text-white shadow-lg scale-105' : 'text-gray-600 hover:text-gray-800 hover:bg-white hover:bg-opacity-80 hover:shadow-md hover:scale-105' }}" 
                           data-route="{{ $route }}" 
                           style="{{ request()->routeIs('customer.' . $route) ? 'background: linear-gradient(135deg, ' . $colors[0] . ', ' . $colors[1] . ');' : '' }}">
                            
                            <div class="relative flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('customer.' . $route) ? 'bg-white/20' : 'bg-gradient-to-br ' . $item['color'] . ' group-hover:scale-110' }} transition-all duration-300 flex-shrink-0">
                                <svg class="h-4 w-4 {{ request()->routeIs('customer.' . $route) ? 'text-white' : 'text-white' }} transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"></path>
                                </svg>
                            </div>
                            
                            <span class="font-medium tracking-wide text-center">{{ $item['name'] }}</span>
                            
                            <!-- Active indicator -->
                            @if(request()->routeIs('customer.' . $route))
                                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-white rounded-full shadow-lg animate-pulse"></div>
                            @endif
                            
                            <!-- Hover glow effect -->
                            <div class="absolute inset-0 rounded-xl bg-gradient-to-r {{ $item['color'] }} opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Compact User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-12">
                @php
                    $userGradients = [
                        'from-red-500 to-pink-500',
                        'from-blue-500 to-cyan-500', 
                        'from-purple-500 to-indigo-500',
                        'from-green-500 to-emerald-500',
                        'from-orange-500 to-amber-500',
                        'from-violet-500 to-fuchsia-500'
                    ];
                    $randomGradient = $userGradients[array_rand($userGradients)];
                @endphp
                
                <div class="relative" id="user-dropdown">
                    <!-- User Avatar Button -->
                    <button onclick="toggleUserDropdown()" class="flex items-center space-x-2 p-1 rounded-2xl hover:bg-gray-50 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 ml-4">
                        <div class="relative">
                            <div class="h-10 w-10 rounded-2xl bg-gradient-to-br {{ $randomGradient }} flex items-center justify-center text-white font-bold text-sm shadow-lg hover:scale-105 transition-transform duration-300">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                        </div>
                        <div class="hidden lg:block">
                            <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">Customer</div>
                        </div>
                        <svg class="h-4 w-4 text-gray-500 transition-transform duration-200" id="dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 opacity-0 transform scale-95 transition-all duration-200">
                        <!-- User Info -->
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="h-12 w-12 rounded-2xl bg-gradient-to-br {{ $randomGradient }} flex items-center justify-center text-white font-bold shadow-lg">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                    <div class="text-xs text-blue-600 font-medium">Customer Premium</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Menu Items -->
                        <div class="py-2">
                            <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                                <svg class="h-4 w-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profil Saya
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                                <svg class="h-4 w-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Pengaturan
                            </a>
                        </div>
                        
                        <!-- Logout -->
                        <div class="border-t border-gray-100 pt-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-200">
                                    <svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Keluar dari Akun
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Premium Mobile Menu Button -->
            <div class="flex items-center sm:hidden">
                <button type="button" 
                        id="mobile-menu-button"
                        class="relative inline-flex items-center justify-center p-3 rounded-2xl text-gray-600 hover:text-gray-800 bg-white bg-opacity-80 border border-gray-200 hover:bg-white hover:shadow-lg transition-all duration-300 hover:scale-105"
                        onclick="toggleMobileMenu()">
                    <span class="sr-only">Buka menu</span>
                    <div class="hamburger-icon">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Premium Mobile Menu -->
    <div class="sm:hidden mobile-menu-overlay" id="mobile-menu">
        <div class="mobile-menu-content bg-white bg-opacity-95 shadow-2xl border-t border-indigo-100">
            <div class="px-6 py-4 space-y-2">
                @foreach($navItems as $route => $item)
                    @php
                        $mobileColorMap = [
                            'from-blue-500 to-cyan-500' => ['#3b82f6', '#06b6d4'],
                            'from-emerald-500 to-teal-500' => ['#10b981', '#14b8a6'],
                            'from-violet-500 to-purple-500' => ['#8b5cf6', '#a855f7'],
                            'from-amber-500 to-orange-500' => ['#f59e0b', '#f97316'],
                            'from-rose-500 to-pink-500' => ['#f43f5e', '#ec4899']
                        ];
                        $mobileColors = $mobileColorMap[$item['color']] ?? ['#3b82f6', '#06b6d4'];
                    @endphp
                    
                    <a href="{{ route('customer.' . $route) }}" 
                       class="mobile-nav-link group flex items-center px-4 py-3.5 text-base font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('customer.' . $route) ? 'text-white shadow-lg' : 'text-gray-700 hover:text-gray-900 hover:bg-white hover:bg-opacity-80 hover:shadow-md' }}"
                       style="{{ request()->routeIs('customer.' . $route) ? 'background: linear-gradient(135deg, ' . $mobileColors[0] . ', ' . $mobileColors[1] . ');' : '' }}">
                        
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl mr-4 {{ request()->routeIs('customer.' . $route) ? 'bg-white bg-opacity-20' : 'bg-gradient-to-br ' . $item['color'] . ' group-hover:scale-110' }} transition-all duration-300">
                            <svg class="h-5 w-5 text-white transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"></path>
                            </svg>
                        </div>
                        
                        <span class="flex-1 font-medium tracking-wide">{{ $item['name'] }}</span>
                        
                        @if(request()->routeIs('customer.' . $route))
                            <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                        @else
                            <div class="w-6 h-6 rounded-full bg-gradient-to-br {{ $item['color'] }} opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                        @endif
                    </a>
                @endforeach
            </div>
            
            <div class="border-t border-indigo-100 pt-4 pb-4 bg-gradient-to-r from-gray-50 to-indigo-50">
                <div class="flex items-center px-6 mb-4">
                    <div class="relative">
                        <div class="h-12 w-12 rounded-2xl bg-gradient-to-br {{ $randomGradient }} flex items-center justify-center text-white font-bold shadow-lg">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="text-lg font-bold text-gray-800 tracking-tight">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-gray-500 font-medium">{{ Auth::user()->email }}</div>
                        <div class="text-xs text-indigo-600 font-semibold uppercase tracking-wide">Customer Premium</div>
                    </div>
                </div>
                <div class="px-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full group relative px-6 py-4 text-base font-bold text-white bg-gradient-to-r from-red-500 to-pink-500 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 hover:from-red-600 hover:to-pink-600 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-pink-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative flex items-center justify-center space-x-3">
                                <svg class="h-5 w-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="tracking-wide">Keluar dari Akun</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Premium CSS Styling -->
<style>
    /* Enhanced Navbar Effects */
    #main-navbar {
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    
    #main-navbar.scrolled {
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-bottom: 1px solid rgba(99, 102, 241, 0.2);
    }
    
    /* Premium Hamburger Animation */
    .hamburger-icon {
        width: 24px;
        height: 18px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        position: relative;
    }
    
    .hamburger-line {
        width: 100%;
        height: 3px;
        background: linear-gradient(45deg, #6366f1, #8b5cf6, #ec4899);
        border-radius: 2px;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        transform-origin: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .hamburger-icon.active .hamburger-line:nth-child(1) {
        transform: rotate(45deg) translate(6px, 6px);
        background: linear-gradient(45deg, #ef4444, #f97316);
    }
    
    .hamburger-icon.active .hamburger-line:nth-child(2) {
        opacity: 0;
        transform: scale(0);
    }
    
    .hamburger-icon.active .hamburger-line:nth-child(3) {
        transform: rotate(-45deg) translate(8px, -8px);
        background: linear-gradient(45deg, #ef4444, #f97316);
    }
    
    /* Enhanced Mobile Menu */
    .mobile-menu-overlay {
        position: fixed;
        top: 64px;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.4), rgba(139, 92, 246, 0.4));
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        z-index: 40;
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    
    .mobile-menu-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .mobile-menu-content {
        transform: translateY(-100%) scale(0.95);
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        max-height: calc(100vh - 64px);
        overflow-y: auto;
        border-radius: 0 0 24px 24px;
    }
    
    .mobile-menu-overlay.active .mobile-menu-content {
        transform: translateY(0) scale(1);
    }
    
    /* Navigation Items Premium Effects */
    .nav-item {
        position: relative;
        overflow: hidden;
    }
    
    .nav-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
    }
    
    .nav-item:hover::before {
        left: 100%;
    }
    
    /* Mobile Navigation Link Premium Animation */
    .mobile-nav-link {
        min-height: 56px;
        position: relative;
        overflow: hidden;
        transform: translateX(-50px);
        opacity: 0;
        animation: slideInMobile 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }
    
    .mobile-nav-link:nth-child(1) { animation-delay: 0.1s; }
    .mobile-nav-link:nth-child(2) { animation-delay: 0.2s; }
    .mobile-nav-link:nth-child(3) { animation-delay: 0.3s; }
    .mobile-nav-link:nth-child(4) { animation-delay: 0.4s; }
    .mobile-nav-link:nth-child(5) { animation-delay: 0.5s; }
    
    @keyframes slideInMobile {
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    /* Floating Elements Animation */
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(180deg); }
    }
    
    /* Pulse Animation Enhancement */
    @keyframes glow {
        0%, 100% { 
            box-shadow: 0 0 5px rgba(99, 102, 241, 0.4), 
                       0 0 10px rgba(99, 102, 241, 0.3), 
                       0 0 15px rgba(99, 102, 241, 0.2);
        }
        50% { 
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.6), 
                       0 0 20px rgba(99, 102, 241, 0.4), 
                       0 0 30px rgba(99, 102, 241, 0.3);
        }
    }
    
    /* Gradient Text Animation */
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Smooth Scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    /* Enhanced Scrollbar */
    .mobile-menu-content::-webkit-scrollbar {
        width: 6px;
    }
    
    .mobile-menu-content::-webkit-scrollbar-track {
        background: rgba(99, 102, 241, 0.1);
        border-radius: 10px;
    }
    
    .mobile-menu-content::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 10px;
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
    }
    
    .mobile-menu-content::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
    }
    
    /* Glassmorphism Effects */
    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* User Dropdown Animations */
    #user-dropdown-menu {
        transform-origin: top right;
    }
    
    #user-dropdown-menu.opacity-100 {
        opacity: 1 !important;
        transform: scale(1) !important;
    }
    
    #user-dropdown-menu.opacity-0 {
        opacity: 0 !important;
        transform: scale(0.95) !important;
    }
    
    /* Arrow rotation */
    #dropdown-arrow {
        transition: transform 0.2s ease;
    }
</style>

<script>
    // Premium Mobile Menu Toggle
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.querySelector('.hamburger-icon');
        const body = document.body;
        
        mobileMenu.classList.toggle('active');
        hamburgerIcon.classList.toggle('active');
        
        if (mobileMenu.classList.contains('active')) {
            body.style.overflow = 'hidden';
            // Add blur effect to navbar when menu is open
            document.getElementById('main-navbar').style.backdropFilter = 'blur(30px)';
        } else {
            body.style.overflow = '';
            document.getElementById('main-navbar').style.backdropFilter = 'blur(20px)';
        }
    }
    
    // Enhanced click outside handler
    document.addEventListener('click', function(event) {
        const mobileMenu = document.getElementById('mobile-menu');
        const menuButton = document.getElementById('mobile-menu-button');
        const hamburgerIcon = document.querySelector('.hamburger-icon');
        
        if (!mobileMenu.contains(event.target) && !menuButton.contains(event.target) && mobileMenu.classList.contains('active')) {
            mobileMenu.classList.remove('active');
            hamburgerIcon.classList.remove('active');
            document.body.style.overflow = '';
            document.getElementById('main-navbar').style.backdropFilter = 'blur(20px)';
        }
    });
    
    // Enhanced resize handler
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 640) {
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.querySelector('.hamburger-icon');
            
            if (mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                hamburgerIcon.classList.remove('active');
                document.body.style.overflow = '';
                document.getElementById('main-navbar').style.backdropFilter = 'blur(20px)';
            }
        }
    });
    
    // User Dropdown Functions
    function toggleUserDropdown() {
        const dropdownMenu = document.getElementById('user-dropdown-menu');
        const arrow = document.getElementById('dropdown-arrow');
        
        if (dropdownMenu.classList.contains('hidden')) {
            // Show dropdown
            dropdownMenu.classList.remove('hidden');
            setTimeout(() => {
                dropdownMenu.classList.remove('opacity-0', 'scale-95');
                dropdownMenu.classList.add('opacity-100', 'scale-100');
            }, 10);
            arrow.style.transform = 'rotate(180deg)';
        } else {
            // Hide dropdown
            dropdownMenu.classList.add('opacity-0', 'scale-95');
            dropdownMenu.classList.remove('opacity-100', 'scale-100');
            setTimeout(() => {
                dropdownMenu.classList.add('hidden');
            }, 200);
            arrow.style.transform = 'rotate(0deg)';
        }
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('user-dropdown');
        const dropdownMenu = document.getElementById('user-dropdown-menu');
        const arrow = document.getElementById('dropdown-arrow');
        
        if (!dropdown.contains(event.target) && !dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.add('opacity-0', 'scale-95');
            dropdownMenu.classList.remove('opacity-100', 'scale-100');
            setTimeout(() => {
                dropdownMenu.classList.add('hidden');
            }, 200);
            arrow.style.transform = 'rotate(0deg)';
        }
    });
    
    // Premium scroll effects
    let ticking = false;
    let lastScrollY = window.scrollY;
    
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(updateNavbar);
            ticking = true;
        }
    });
    
    function updateNavbar() {
        const navbar = document.getElementById('main-navbar');
        const currentScrollY = window.scrollY;
        
        if (currentScrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        // Add parallax effect to logo on scroll
        const logo = navbar.querySelector('.w-12.h-12');
        if (logo) {
            const scrollPercent = Math.min(currentScrollY / 100, 1);
            logo.style.transform = `scale(${1 - scrollPercent * 0.1}) rotate(${scrollPercent * 5}deg)`;
        }
        
        lastScrollY = currentScrollY;
        ticking = false;
    }
    
    // Add hover effects for navigation items
    document.addEventListener('DOMContentLoaded', function() {
        const navItems = document.querySelectorAll('.nav-item');
        
        navItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.05)';
                this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.1)';
            });
            
            item.addEventListener('mouseleave', function() {
                if (!this.classList.contains('scale-105')) {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                }
            });
        });
        
        // Add floating animation to user avatar
        const userAvatar = document.querySelector('.h-10.w-10.rounded-2xl');
        if (userAvatar) {
            setInterval(() => {
                userAvatar.style.animation = 'float 3s ease-in-out infinite';
            }, 100);
        }
        
        // Add subtle animations on load
        const navbar = document.getElementById('main-navbar');
        navbar.style.transform = 'translateY(-100%)';
        navbar.style.opacity = '0';
        
        setTimeout(() => {
            navbar.style.transition = 'all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            navbar.style.transform = 'translateY(0)';
            navbar.style.opacity = '1';
        }, 100);
    });
</script>
