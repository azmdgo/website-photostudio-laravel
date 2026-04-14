@extends('layouts.app')

@section('content')
<!-- Enhanced Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Hero Background with Wallpaper Support -->
    <div class="absolute inset-0">
        <!-- Option 1: Background Image/Wallpaper (uncomment and add your image) -->
        <!-- Photography Studio Wallpaper -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('/images/hero-wallpaper.jpg')"></div>
        
        <!-- Alternative wallpaper options (use one at a time): -->
        <!-- <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/studio-interior.jpg') }}')"></div> -->
        <!-- <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/camera-equipment.jpg') }}')"></div> -->
        <!-- <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/portrait-session.jpg') }}')"></div> -->
        
        <!-- Option 2: Fallback Gradient Background (disabled when wallpaper is active) -->
        <!-- <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-purple-900"></div> -->
        
        <!-- Subtle Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.03"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
        
        <!-- Dark Overlay for Text Readability -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-black/40"></div>
        
        <!-- Optional: Additional Photo Studio Elements -->
        <div class="absolute inset-0 bg-gradient-to-br from-transparent via-blue-900/20 to-purple-900/30"></div>
    </div>
    
    <!-- Animated Elements -->
    <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-screen h-screen bg-gradient-to-r from-blue-600/5 to-purple-600/5 blur-3xl animate-pulse" style="animation-delay: 2s"></div>
    
    <!-- Main Content -->
    <div class="relative z-10 text-center text-white max-w-6xl mx-auto px-4">
        <div class="mb-8 space-y-6">
            <!-- Logo/Brand -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl flex items-center justify-center shadow-2xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold mb-6 leading-tight tracking-tight">
                <span class="bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                    Yujin Foto Studio
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 text-gray-200 max-w-4xl mx-auto leading-relaxed font-light">
                Abadikan momen berharga Anda dengan sentuhan artistik dan profesional. 
                Kami menghadirkan fotografi berkualitas tinggi untuk berbagai kebutuhan dengan teknologi terdepan.
            </p>
        </div>
        
        <!-- Enhanced CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
            <a href="{{ route('customer.services') }}" class="group relative overflow-hidden bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-4 px-8 rounded-full transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl inline-flex items-center space-x-2">
                <span class="relative z-10">Lihat Layanan</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform relative z-10" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
            </a>
            <a href="{{ route('customer.booking') }}" class="group relative overflow-hidden bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-900 font-semibold py-4 px-8 rounded-full transform hover:scale-105 transition-all duration-300 inline-flex items-center space-x-2">
                <svg class="w-5 h-5 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                <span class="relative z-10">Pesan Sekarang</span>
            </a>
        </div>
        
        <!-- Enhanced Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
            <div class="text-center transform hover:scale-105 transition-transform duration-300">
                <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent mb-2">500+</div>
                <div class="text-gray-300 text-lg font-medium">Klien Puas</div>
            </div>
            <div class="text-center transform hover:scale-105 transition-transform duration-300">
                <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">1000+</div>
                <div class="text-gray-300 text-lg font-medium">Foto Berkualitas</div>
            </div>
            <div class="text-center transform hover:scale-105 transition-transform duration-300">
                <div class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-pink-400 to-red-400 bg-clip-text text-transparent mb-2">5+</div>
                <div class="text-gray-300 text-lg font-medium">Tahun Pengalaman</div>
            </div>
        </div>
    </div>
    
    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Enhanced Services Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Layanan <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Utama</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Kami menawarkan berbagai layanan fotografi profesional untuk memenuhi kebutuhan Anda dengan kualitas terbaik
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service 1 -->
            <div class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-4 hover:rotate-1">
                <div class="relative h-64 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    <svg class="w-20 h-20 text-white relative z-10" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                    </svg>
                    <!-- Floating animation -->
                    <div class="absolute top-4 right-4 w-2 h-2 bg-white/30 rounded-full animate-ping"></div>
                    <div class="absolute bottom-4 left-4 w-3 h-3 bg-white/20 rounded-full animate-pulse"></div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Portrait Studio</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Foto portrait profesional dengan pencahayaan studio yang sempurna untuk berbagai keperluan bisnis dan personal.</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-3xl font-bold text-blue-600">Rp 300.000</span>
                            <div class="text-sm text-gray-500 mt-1">60 menit sesi</div>
                        </div>
                        <div class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-medium">
                            Popular
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Service 2 -->
            <div class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-4 hover:rotate-1">
                <div class="relative h-64 bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    <svg class="w-20 h-20 text-white relative z-10" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                    </svg>
                    <div class="absolute top-4 right-4 w-2 h-2 bg-white/30 rounded-full animate-ping"></div>
                    <div class="absolute bottom-4 left-4 w-3 h-3 bg-white/20 rounded-full animate-pulse"></div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Pre-Wedding Outdoor</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Sesi foto pre-wedding romantis di lokasi outdoor yang indah dan instagramable dengan konsep yang unik.</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-3xl font-bold text-purple-600">Rp 800.000</span>
                            <div class="text-sm text-gray-500 mt-1">180 menit sesi</div>
                        </div>
                        <div class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-sm font-medium">
                            Premium
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Service 3 -->
            <div class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden transform hover:-translate-y-4 hover:rotate-1">
                <div class="relative h-64 bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    <svg class="w-20 h-20 text-white relative z-10" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                    <div class="absolute top-4 right-4 w-2 h-2 bg-white/30 rounded-full animate-ping"></div>
                    <div class="absolute bottom-4 left-4 w-3 h-3 bg-white/20 rounded-full animate-pulse"></div>
                </div>
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Family Photo</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Sesi foto keluarga yang hangat dan natural untuk mengabadikan momen berharga bersama dengan suasana yang menyenangkan.</p>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-3xl font-bold text-green-600">Rp 500.000</span>
                            <div class="text-sm text-gray-500 mt-1">90 menit sesi</div>
                        </div>
                        <div class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm font-medium">
                            Keluarga
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-16">
            <a href="{{ route('customer.services') }}" class="group relative inline-flex items-center space-x-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-4 px-8 rounded-full transform hover:scale-105 transition-all duration-300 shadow-xl hover:shadow-2xl overflow-hidden">
                <span class="relative z-10">Lihat Semua Layanan</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform relative z-10" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
            </a>
        </div>
    </div>
</section>

<!-- Enhanced Why Choose Us Section -->
<section class="py-20 bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Mengapa Memilih <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Kami?</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Kami berkomitmen memberikan layanan terbaik dengan kualitas profesional dan pengalaman yang tak terlupakan
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Quality Professional -->
            <div class="text-center group transform hover:scale-105 transition-all duration-300">
                <div class="relative bg-white rounded-2xl w-24 h-24 flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:shadow-2xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 opacity-10 rounded-2xl"></div>
                    <svg class="w-12 h-12 text-blue-600 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kualitas Profesional</h3>
                <p class="text-gray-600 leading-relaxed">Menggunakan peralatan terbaik dan teknik fotografi profesional untuk hasil yang memukau</p>
            </div>
            
            <!-- Experienced Team -->
            <div class="text-center group transform hover:scale-105 transition-all duration-300">
                <div class="relative bg-white rounded-2xl w-24 h-24 flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:shadow-2xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 opacity-10 rounded-2xl"></div>
                    <svg class="w-12 h-12 text-purple-600 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Tim Berpengalaman</h3>
                <p class="text-gray-600 leading-relaxed">Fotografer berpengalaman dengan keahlian dalam berbagai gaya dan konsep fotografi</p>
            </div>
            
            <!-- Satisfactory Results -->
            <div class="text-center group transform hover:scale-105 transition-all duration-300">
                <div class="relative bg-white rounded-2xl w-24 h-24 flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:shadow-2xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-teal-600 opacity-10 rounded-2xl"></div>
                    <svg class="w-12 h-12 text-green-600 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Hasil Memuaskan</h3>
                <p class="text-gray-600 leading-relaxed">Garansi kepuasan dengan hasil foto yang berkualitas tinggi dan sesuai ekspektasi</p>
            </div>
            
            <!-- Best Service -->
            <div class="text-center group transform hover:scale-105 transition-all duration-300">
                <div class="relative bg-white rounded-2xl w-24 h-24 flex items-center justify-center mx-auto mb-6 shadow-xl group-hover:shadow-2xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-500 to-red-600 opacity-10 rounded-2xl"></div>
                    <svg class="w-12 h-12 text-pink-600 relative z-10" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pelayanan Terbaik</h3>
                <p class="text-gray-600 leading-relaxed">Konsultasi gratis dan pelayanan ramah dari awal hingga akhir dengan komitmen penuh</p>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Workflow Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Proses <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Kerja</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Langkah mudah untuk mendapatkan foto profesional yang Anda inginkan
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center relative">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 text-white font-bold text-xl shadow-lg">
                    1
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Konsultasi</h3>
                <p class="text-gray-600">Diskusi kebutuhan dan pilih paket yang sesuai</p>
                <!-- Arrow -->
                <div class="hidden md:block absolute top-8 left-full w-8 h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 transform -translate-x-4"></div>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center relative">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 text-white font-bold text-xl shadow-lg">
                    2
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Pemesanan</h3>
                <p class="text-gray-600">Booking jadwal dan konfirmasi detail acara</p>
                <!-- Arrow -->
                <div class="hidden md:block absolute top-8 left-full w-8 h-0.5 bg-gradient-to-r from-purple-600 to-pink-600 transform -translate-x-4"></div>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center relative">
                <div class="bg-gradient-to-r from-pink-600 to-red-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 text-white font-bold text-xl shadow-lg">
                    3
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Pemotretan</h3>
                <p class="text-gray-600">Sesi foto profesional sesuai dengan konsep</p>
                <!-- Arrow -->
                <div class="hidden md:block absolute top-8 left-full w-8 h-0.5 bg-gradient-to-r from-pink-600 to-red-600 transform -translate-x-4"></div>
            </div>
            
            <!-- Step 4 -->
            <div class="text-center">
                <div class="bg-gradient-to-r from-red-600 to-orange-600 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 text-white font-bold text-xl shadow-lg">
                    4
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Penyerahan</h3>
                <p class="text-gray-600">Editing dan penyerahan hasil foto final</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimoni -->
<section class="py-20 bg-gradient-to-r from-blue-50 to-purple-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Testimoni <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Klien</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Apa kata mereka yang telah menggunakan layanan kami
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                        S
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-900">Sarah Putri</h4>
                        <p class="text-gray-600 text-sm">Pelanggan</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">
                    "Hasil foto pre-wedding kami sangat memuaskan! Tim fotografer sangat profesional dan ramah. 
                    Lokasi yang dipilih juga sangat indah."
                </p>
                <div class="flex text-yellow-400 mt-4">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                        A
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-900">Ahmad Rizki</h4>
                        <p class="text-gray-600 text-sm">Pelanggan</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">
                    "Foto keluarga kami jadi sangat bagus! Anak-anak yang biasanya susah diam jadi sangat kooperatif 
                    karena fotografernya sabar dan kreatif."
                </p>
                <div class="flex text-yellow-400 mt-4">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center text-white font-bold">
                        D
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-900">Dina Maharani</h4>
                        <p class="text-gray-600 text-sm">Pelanggan</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">
                    "Foto wisuda saya jadi sangat bagus! Kualitas foto dan editing sangat memuaskan. 
                    Pasti akan kembali lagi untuk acara lainnya."
                </p>
                <div class="flex text-yellow-400 mt-4">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black/10">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative z-10 max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Siap untuk Mengabadikan Momen Spesial Anda?
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Jangan tunggu lagi! Hubungi kami sekarang untuk konsultasi gratis dan dapatkan penawaran terbaik
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('customer.booking') }}" class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-4 px-8 rounded-full transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl inline-flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                <span>Pesan Sekarang</span>
            </a>
            
            <a href="tel:+628123456789" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-blue-600 font-semibold py-4 px-8 rounded-full transform hover:scale-105 transition-all duration-300 inline-flex items-center space-x-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                </svg>
                <span>Hubungi Kami</span>
            </a>
        </div>
        
        <div class="mt-8 text-blue-100">
            <p class="text-sm">Atau hubungi WhatsApp: <a href="https://wa.me/628123456789" class="text-white hover:underline font-semibold">+62 812-3456-7890</a></p>
        </div>
    </div>
</section>

<!-- Additional CSS for animations -->
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .float-animation {
        animation: float 3s ease-in-out infinite;
    }
    
    .float-animation:nth-child(2) {
        animation-delay: 1s;
    }
    
    .float-animation:nth-child(3) {
        animation-delay: 2s;
    }
    
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom gradient text */
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Hover effects */
    .hover-lift {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    /* Parallax effect */
    .parallax {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

<!-- Additional JavaScript for enhanced interactions -->
<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);
    
    // Observe all sections
    document.querySelectorAll('section').forEach(section => {
        observer.observe(section);
    });
    
    // Add fade-in animation class
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }
    `;
    document.head.appendChild(style);
</script>
@endsection