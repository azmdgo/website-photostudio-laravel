<x-layouts.app :title="'Tentang Kami - ' . config('app.name')" :showNavigation="true" :showFooter="true">
    <style>
        /* Custom animations and effects */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .animate-pulse-slow {
            animation: pulse 3s infinite;
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .hero-image {
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.1) 0%, 
                rgba(147, 51, 234, 0.1) 100%),
                url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300"><defs><linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:%234F46E5;stop-opacity:1" /><stop offset="100%" style="stop-color:%237C3AED;stop-opacity:1" /></linearGradient></defs><rect width="400" height="300" fill="url(%23grad1)"/><g transform="translate(200,150)"><circle cx="0" cy="0" r="60" fill="white" opacity="0.1"/><circle cx="0" cy="0" r="40" fill="white" opacity="0.15"/><circle cx="0" cy="0" r="20" fill="white" opacity="0.2"/></g></svg>') center/cover;
        }
        
        .service-card {
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .contact-card {
            transition: all 0.3s ease;
        }
        
        .contact-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .professional-image {
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.9) 0%, 
                rgba(147, 51, 234, 0.9) 100%),
                url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400"><defs><pattern id="camera-pattern" patternUnits="userSpaceOnUse" width="40" height="40"><rect width="40" height="40" fill="none"/><g opacity="0.1"><path d="M8 12h.01M12 12h.01M16 12h.01M8 16h.01M12 16h.01M16 16h.01M8 20h.01M12 20h.01M16 20h.01" stroke="white" stroke-width="2" stroke-linecap="round"/></g></pattern></defs><rect width="400" height="400" fill="url(%23camera-pattern)"/><g transform="translate(200,200)"><circle cx="0" cy="0" r="80" fill="white" opacity="0.2"/><rect x="-30" y="-20" width="60" height="40" rx="8" fill="white" opacity="0.3"/><circle cx="0" cy="0" r="15" fill="white" opacity="0.4"/><rect x="-40" y="-30" width="80" height="60" rx="10" fill="none" stroke="white" stroke-width="2" opacity="0.5"/></g></svg>') center/cover;
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
    
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Header -->
            <div class="text-center py-16 animate-fadeInUp">
                <h1 class="text-5xl md:text-6xl font-bold gradient-text mb-6">Tentang Yujin Foto Studio</h1>
                <p class="text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">Professional Photography Studio di Palembang yang mengabadikan momen berharga Anda dengan sentuhan artistik dan kualitas terbaik</p>
                <div class="mt-8 flex justify-center">
                    <div class="animate-float">
                        <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-20">
                <!-- Professional Studio Image -->
                <div class="order-2 lg:order-1">
                    <div class="relative">
                        <div class="professional-image rounded-3xl h-96 lg:h-[500px] flex items-center justify-center shadow-2xl overflow-hidden group">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-purple-600/20 group-hover:from-blue-600/30 group-hover:to-purple-600/30 transition-all duration-500"></div>
                            <div class="text-center text-white relative z-10 group-hover:scale-105 transition-transform duration-500">
                                <div class="mb-6 animate-pulse-slow">
                                    <svg class="mx-auto h-32 w-32 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-3xl font-bold mb-2">Yujin Foto Studio</h3>
                                <p class="text-xl text-blue-100 mb-4">Capturing Your Beautiful Moments</p>
                                <div class="flex justify-center space-x-4 text-sm opacity-90">
                                    <span class="bg-white/20 px-3 py-1 rounded-full">Professional</span>
                                    <span class="bg-white/20 px-3 py-1 rounded-full">Creative</span>
                                    <span class="bg-white/20 px-3 py-1 rounded-full">Memorable</span>
                                </div>
                            </div>
                        </div>
                        <!-- Decorative elements -->
                        <div class="absolute -top-4 -left-4 w-24 h-24 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full opacity-20 animate-pulse-slow"></div>
                        <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full opacity-20 animate-pulse-slow animation-delay-1000"></div>
                    </div>
                </div>

                <!-- Enhanced About Content -->
                <div class="order-1 lg:order-2">
                    <div class="bg-white rounded-3xl p-8 shadow-2xl border border-gray-100">
                        <h2 class="text-4xl font-bold gradient-text mb-8">Cerita Kami</h2>
                        <div class="space-y-6 text-gray-600 text-lg leading-relaxed">
                            <div class="relative">
                                <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-blue-500 to-purple-500 rounded-full"></div>
                                <p class="pl-6">
                                    Yujin Foto Studio hadir di Palembang dengan misi untuk mengabadikan momen-momen berharga dalam hidup Anda. 
                                    Sejak didirikan, kami telah melayani ribuan klien dengan profesionalisme dan kualitas terbaik.
                                </p>
                            </div>
                            <div class="relative">
                                <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></div>
                                <p class="pl-6">
                                    Dengan tim fotografer berpengalaman dan peralatan modern, kami siap membantu Anda menciptakan kenangan 
                                    yang indah melalui karya fotografi berkualitas tinggi.
                                </p>
                            </div>
                            <div class="relative">
                                <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-pink-500 to-red-500 rounded-full"></div>
                                <p class="pl-6">
                                    Kepuasan pelanggan adalah prioritas utama kami. Setiap sesi foto dirancang khusus sesuai dengan 
                                    kebutuhan dan visi Anda.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Stats Section -->
                        <div class="mt-8 grid grid-cols-3 gap-4">
                            <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl">
                                <div class="text-2xl font-bold text-blue-600 mb-1">500+</div>
                                <div class="text-sm text-gray-600">Happy Clients</div>
                            </div>
                            <div class="text-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl">
                                <div class="text-2xl font-bold text-purple-600 mb-1">5+</div>
                                <div class="text-sm text-gray-600">Years Experience</div>
                            </div>
                            <div class="text-center p-4 bg-gradient-to-br from-pink-50 to-pink-100 rounded-2xl">
                                <div class="text-2xl font-bold text-pink-600 mb-1">1000+</div>
                                <div class="text-sm text-gray-600">Photo Sessions</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Overview -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Layanan Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Indoor Photography -->
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 ml-3">Indoor Photography</h3>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Sesi foto di dalam studio dengan pencahayaan profesional dan berbagai background menarik. 
                            Cocok untuk portrait, family photo, product photography, dan kebutuhan foto formal.
                        </p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Pencahayaan studio profesional
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Berbagai pilihan background
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Kontrol cuaca tidak berpengaruh
                            </li>
                        </ul>
                    </div>

                    <!-- Outdoor Photography -->
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 ml-3">Outdoor Photography</h3>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Sesi foto di lokasi outdoor dengan suasana natural dan pemandangan indah. 
                            Perfect untuk pre-wedding, family outing, graduation, dan event khusus.
                        </p>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Pencahayaan natural yang indah
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Pemandangan dan lokasi menarik
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Suasana santai dan natural
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Hubungi Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Address -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Alamat Studio</h3>
                        <p class="text-gray-600">
                            Jl. Lintas Sumatera No.135<br>
                            Sukodadi, Kec. Sukarami, Palembang<br>
                            Sumatera Selatan 30154
                        </p>
                    </div>

                    <!-- Phone -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Telepon</h3>
                        <p class="text-gray-600">
                            +62 881-0822-09109<br>
                            (WhatsApp Available)
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
                        <p class="text-gray-600">
                            yujinfotopalembang@gmail.com
                        </p>
                    </div>
                </div>
            </div>

            <!-- Operating Hours -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Jam Operasional</h2>
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Hari Kerja</h3>
                                <div class="space-y-2 text-gray-600">
                                    <div class="flex justify-between">
                                        <span>Senin - Jumat</span>
                                        <span class="font-medium">08:00 - 20:00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Sabtu</span>
                                        <span class="font-medium">10:00 - 18:00</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Hari Libur</h3>
                                <div class="space-y-2 text-gray-600">
                                    <div class="flex justify-between">
                                        <span>Minggu</span>
                                        <span class="font-medium text-red-500">Tutup</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Hari Besar</span>
                                        <span class="font-medium text-red-500">Tutup</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                            <p class="text-sm text-blue-800">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <strong>Info:</strong> Untuk booking di luar jam operasional, silakan hubungi kami via WhatsApp atau email terlebih dahulu.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-16 mb-20 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-10 text-center border border-blue-100 shadow-lg relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400 to-purple-400 opacity-5 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-purple-400 to-pink-400 opacity-5 rounded-full -ml-12 -mb-12"></div>
                
                <div class="relative z-10">
                    <!-- Icon -->
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full mb-6 shadow-md">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">Siap untuk Memulai?</h2>
                    <p class="text-lg text-gray-700 mb-8 max-w-2xl mx-auto leading-relaxed">Pilih layanan yang sesuai dengan kebutuhan Anda dan wujudkan momen berharga menjadi karya fotografi yang menakjubkan!</p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('customer.booking') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Buat Booking Sekarang
                        </a>
                        <a href="{{ route('customer.about') }}" class="inline-flex items-center px-8 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-white hover:border-gray-400 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                    
                    <!-- Subtle decorative line -->
                    <div class="mt-8 flex justify-center">
                        <div class="w-32 h-1 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full opacity-50"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
