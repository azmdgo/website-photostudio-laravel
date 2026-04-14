<x-layouts.app :title="'Dashboard - ' . config('app.name')" :showNavigation="true" :showFooter="true">
    <!-- Hero Section with Background -->
    <div class="relative bg-gradient-to-br from-blue-50 via-white to-purple-50 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-10 left-10 w-64 h-64 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
            <div class="absolute top-32 right-20 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-2000"></div>
            <div class="absolute bottom-20 left-32 w-80 h-80 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-4000"></div>
        </div>
        
        <div class="relative py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Welcome Hero Section -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl p-8 mb-8 border border-white/20">
                    <div class="flex flex-col lg:flex-row items-center justify-between">
                        <div class="flex-1 mb-6 lg:mb-0">
                            <div class="flex items-center mb-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4 shadow-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">Selamat Datang, {{ $user->name }}! 👋</h1>
                                    <p class="text-lg text-gray-600 mt-2">Siap untuk menangkap momen berharga Anda bersama Yujin Foto Studio</p>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap gap-3 mt-6">
                                <a href="{{ route('customer.booking') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Buat Booking Baru
                                </a>
                                <a href="{{ route('customer.services') }}" class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7l2 2-2 2M5 5l2 2-2 2"/>
                                    </svg>
                                    Lihat Layanan
                                </a>
                            </div>
                        </div>
                        
                        <!-- Hero Image/Illustration -->
                        <div class="flex-shrink-0 lg:ml-8">
                            <div class="relative">
                                <div class="w-80 h-80 bg-gradient-to-br from-blue-100 to-purple-100 rounded-3xl flex items-center justify-center shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-300">
                                    <div class="w-64 h-64 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-2xl flex items-center justify-center">
                                        <svg class="w-32 h-32 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="absolute -top-4 -right-4 w-20 h-20 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                    <span class="text-2xl">📸</span>
                                </div>
                                <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-pink-400 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                    <span class="text-xl">✨</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Enhanced Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Bookings Card -->
                <div class="group bg-white/90 backdrop-blur-sm overflow-hidden shadow-xl rounded-2xl border border-white/20 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Total Booking</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $totalBookings }}</p>
                                </div>
                            </div>
                            <div class="text-4xl">📋</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-blue-600 font-medium">Semua pemesanan Anda</span>
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Bookings Card -->
                <div class="group bg-white/90 backdrop-blur-sm overflow-hidden shadow-xl rounded-2xl border border-white/20 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Menunggu</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $pendingBookings }}</p>
                                </div>
                            </div>
                            <div class="text-4xl">⏳</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-100 px-6 py-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-orange-600 font-medium">Konfirmasi admin</span>
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Completed Bookings Card -->
                <div class="group bg-white/90 backdrop-blur-sm overflow-hidden shadow-xl rounded-2xl border border-white/20 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Selesai</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $completedBookings }}</p>
                                </div>
                            </div>
                            <div class="text-4xl">✅</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-green-50 to-emerald-100 px-6 py-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-green-600 font-medium">Sesi foto selesai</span>
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Enhanced Quick Actions -->
                <div class="lg:col-span-1">
                    <div class="bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-900">Aksi Cepat ⚡</h2>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <a href="{{ route('customer.services') }}" class="group block w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <div class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7l2 2-2 2M5 5l2 2-2 2"/>
                                    </svg>
                                    Lihat Layanan 🔍
                                </div>
                            </a>
                            
                            <a href="{{ route('customer.booking') }}" class="group block w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <div class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Buat Booking Baru 🎆
                                </div>
                            </a>
                            
                            <a href="{{ route('customer.orders') }}" class="group block w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <div class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Status Pemesanan 📋
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Enhanced Studio Info -->
                    <div class="bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl mt-6 border border-white/20">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-900">Info Studio 🏢</h2>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-600">Alamat</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">Palembang, Sumatera Selatan</span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-600">Telepon</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">+62 881-0822-09109</span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.633a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-600">Email</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">yujinfotostudio@gmail.com</span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-600">Jam Buka</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">06:00 - 20:00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Recent Bookings -->
                <div class="lg:col-span-2">
                    <div class="bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl border border-white/20">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-lg font-semibold text-gray-900">Booking Terbaru 🕒</h2>
                                </div>
                                <a href="{{ route('customer.orders') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-500 font-medium transition-colors duration-200">
                                    Lihat Semua
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($recentBookings->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentBookings as $booking)
                                        <div class="group bg-gradient-to-r from-white to-gray-50 border border-gray-200 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <div class="flex items-center mb-3">
                                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-purple-100 rounded-xl flex items-center justify-center mr-4">
                                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">{{ $booking->service->name }}</h3>
                                                            <p class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full inline-block">{{ $booking->service->category->name }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center text-sm text-gray-600 space-x-4">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                            {{ $booking->booking_date->format('d M Y') }}
                                                        </div>
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            {{ date('H:i', strtotime($booking->booking_time)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right ml-4">
                                                    <span class="inline-flex px-3 py-2 text-xs font-semibold rounded-xl shadow-sm
                                                        @if($booking->status == 'pending') bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800
                                                        @elseif($booking->status == 'confirmed') bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800
                                                        @elseif($booking->status == 'completed') bg-gradient-to-r from-green-100 to-green-200 text-green-800
                                                        @else bg-gradient-to-r from-red-100 to-red-200 text-red-800 @endif">
                                                        @if($booking->status == 'pending') ⏳
                                                        @elseif($booking->status == 'confirmed') 🔄
                                                        @elseif($booking->status == 'completed') ✅
                                                        @else ❌ @endif
                                                        {{ $booking->status_label }}
                                                    </span>
                                                    <p class="text-lg font-bold text-gray-900 mt-2 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">{{ $booking->formatted_total_price }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="relative">
                                        <div class="w-24 h-24 mx-auto bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <div class="absolute top-2 right-8 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center animate-bounce">
                                            <span class="text-lg">📷</span>
                                        </div>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada booking 📅</h3>
                                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Mulai perjalanan fotografi Anda dengan membuat booking pertama. Kami siap membantu menangkap momen berharga Anda!</p>
                                    <a href="{{ route('customer.booking') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-2xl hover:from-blue-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Buat Booking Baru 🎆
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Custom CSS for Animation Delays -->
    <style>
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        /* Smooth transitions for hover effects */
        .group:hover .group-hover\:animate-pulse {
            animation: pulse 1s infinite;
        }
        
        /* Custom gradient text */
        .bg-clip-text {
            background-clip: text;
            -webkit-background-clip: text;
        }
        
        /* Enhanced backdrop blur support */
        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
        
        /* Loading animation for cards */
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .group:hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 1.5s ease-in-out;
            pointer-events: none;
        }
        
        .group {
            position: relative;
            overflow: hidden;
        }
    </style>
</x-layouts.app>
