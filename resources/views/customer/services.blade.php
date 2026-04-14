<x-layouts.app :title="'Services - ' . config('app.name')" :showNavigation="true" :showFooter="true">
    <div class="py-6 relative overflow-hidden">
        <!-- Animated Background -->
<div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50"></div>
<div class="absolute top-0 left-0 w-48 h-48 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-100 rounded-full mix-blend-multiply filter blur-xl opacity-40 animate-pulse"></div>
        <div class="absolute top-1/2 left-1/2 w-72 h-72 bg-pink-100 rounded-full mix-blend-multiply filter blur-xl opacity-40 animate-pulse"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header -->
            <div class="text-center mb-12 relative">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full mb-4 shadow-md">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h1 class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent hover:from-purple-600 hover:to-blue-600 transition duration-300 transform hover:scale-102 ease-in-out mb-4">
                    Jenis Layanan Foto
                </h1>
                <p class="text-xl text-gray-600 hover:text-gray-700 transition-colors duration-300 max-w-2xl mx-auto leading-relaxed">
                    Pilih jenis layanan fotografi sesuai kebutuhan Anda
                </p>
                <!-- Subtle decorative line -->
                <div class="mt-6 flex justify-center">
                    <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full"></div>
                </div>
            </div>

            <!-- Services Categories -->
            @if($categories->count() > 0)
                <div class="space-y-12">
                    @foreach($categories as $category)
<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:scale-102 ease-in-out border border-gray-100">
                            <!-- Category Header -->
                            <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-600 px-8 py-6 relative">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h2 class="text-3xl font-bold text-white">{{ $category->name }}</h2>
                                        @if($category->description)
                                            <p class="text-blue-100 mt-2">{{ $category->description }}</p>
                                        @endif
                                    </div>
                                    <div class="hidden md:block">
                                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                            @if($category->name == 'Indoor')
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h.01M9 12h.01"/>
                                                </svg>
                                            @else
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Services List -->
                            <div class="p-6">
                                @if($category->services->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                    @foreach($category->services as $service)
                                        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden hover:shadow-lg hover:border-blue-300 transition-all duration-300 transform hover:scale-102 relative group">
                                            <!-- Subtle corner decoration -->
                                            <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-400 opacity-10 rounded-bl-full"></div>
                                            
                                            <!-- Service Image Placeholder -->
                                            <div class="bg-gradient-to-br from-gray-100 to-gray-200 h-40 flex items-center justify-center relative overflow-hidden">
                                                @if($service->image)
                                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                @else
                                                    <div class="text-center">
                                                        <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        <p class="text-gray-500 text-xs">Preview Image</p>
                                                    </div>
                                                @endif
                                            </div>

                                                <!-- Service Details -->
                                                <div class="p-4">
                                                    <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-blue-600 transition-colors duration-300">{{ $service->name }}</h3>
                                                    <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ Str::limit($service->description, 80) }}</p>
                                                    
                                                    <!-- Service Info -->
                                                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-4 mb-4 border border-gray-200">
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div class="text-center">
                                                                <div class="flex items-center justify-center mb-2">
                                                                    {{-- <span class="text-green-600 mr-1 text-sm font-bold">Rp</span> --}}
                                                                    <div class="text-gray-600 text-xs font-semibold uppercase tracking-wide">Harga</div>
                                                                </div>
                                                                <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-3 py-1 rounded-full text-sm font-bold inline-block hover:from-green-600 hover:to-emerald-600 transition-all duration-300 transform hover:scale-105 shadow-sm">{{ $service->formatted_price }}</div>
                                                            </div>
                                                            <div class="text-center">
                                                                <div class="flex items-center justify-center mb-2">
                                                                    <svg class="w-4 h-4 text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                    </svg>
                                                                    <div class="text-gray-600 text-xs font-semibold uppercase tracking-wide">Durasi</div>
                                                                </div>
                                                                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-3 py-1 rounded-full text-sm font-bold inline-block hover:from-blue-600 hover:to-indigo-600 transition-all duration-300 transform hover:scale-105 shadow-sm">{{ $service->duration_minutes }} menit</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Action Buttons -->
                                                    <div class="flex flex-col gap-3">
                                                        <a href="{{ route('customer.booking', ['service' => $service->id]) }}" 
                                                           class="w-full inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-bold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                            Book Sekarang
                                                        </a>
                                                        <button onclick="showServiceDetail({{ $service->id }})" 
                                                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 hover:border-gray-300 transition-all duration-300 shadow-sm hover:shadow-md">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Lihat Detail
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada layanan</h3>
                                        <p class="mt-1 text-sm text-gray-500">Layanan untuk kategori {{ $category->name }} sedang dalam pengembangan.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-gray-400 to-gray-500 rounded-full mb-4 shadow-md">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada layanan tersedia</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Layanan fotografi sedang dalam pengembangan. Silakan hubungi kami untuk informasi lebih lanjut.</p>
                    <a href="{{ route('customer.about') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
            @endif

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

    <!-- Service Detail Modal (Placeholder) -->
    <div id="serviceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-lg w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Detail Layanan</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div id="modalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function showServiceDetail(serviceId) {
            document.getElementById('serviceModal').classList.remove('hidden');
            // In a real application, you would fetch service details via AJAX
            document.getElementById('modalContent').innerHTML = '<p class="text-gray-600">Detail layanan akan ditampilkan di sini...</p>';
        }

        function closeModal() {
            document.getElementById('serviceModal').classList.add('hidden');
        }
    </script>
</x-layouts.app>
