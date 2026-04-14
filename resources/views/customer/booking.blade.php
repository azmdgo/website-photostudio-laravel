<x-layouts.app :title="'Booking - ' . config('app.name')" :showNavigation="true" :showFooter="true">
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12 relative">
                <!-- Background decoration -->
                <div class="absolute inset-0 bg-gradient-to-r from-purple-50 via-blue-50 to-indigo-50 rounded-3xl opacity-50 blur-3xl"></div>
                <div class="relative">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-purple-600 to-blue-600 rounded-full mb-6 shadow-lg animate-pulse">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h1 class="text-5xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                        Buat Booking Baru
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        Isi formulir di bawah untuk membuat booking foto session yang menakjubkan
                    </p>
                    <!-- Decorative elements -->
                    <div class="flex justify-center mt-6 space-x-2">
                        <div class="w-3 h-3 bg-purple-400 rounded-full animate-bounce"></div>
                        <div class="w-3 h-3 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-3 h-3 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 relative">
                <!-- Decorative elements -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400 to-blue-400 opacity-5 rounded-bl-full"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-blue-400 to-indigo-400 opacity-5 rounded-tr-full"></div>
                
                <form action="{{ route('customer.booking.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Form Header -->
                    <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-600 px-8 py-6 relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>
                        <div class="relative flex items-center">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-white">Informasi Booking</h2>
                        </div>
                    </div>

                    <div class="px-8 pb-8 relative">
                        <!-- Service Selection -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-6">
                            <div>
                                <label for="service_id" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    Pilih Layanan <span class="text-red-500">*</span>
                                </label>
                                <select name="service_id" id="service_id" required 
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 @error('service_id') border-red-500 @enderror transition-all duration-300 hover:border-purple-300 bg-white shadow-sm">
                                    <option value="">-- Pilih Layanan --</option>
                                    @foreach($categories as $category)
                                        @if($category->services->count() > 0)
                                            <optgroup label="{{ $category->name }}">
                                                @foreach($category->services as $service)
                                                    <option value="{{ $service->id }}" 
                                                            data-price="{{ $service->price }}" 
                                                            data-duration="{{ $service->duration_minutes }}"
                                                            data-category="{{ $category->name }}"
                                                            {{ old('service_id', $selectedService?->id) == $service->id ? 'selected' : '' }}>
                                                        {{ $service->name }} - {{ $service->formatted_price }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                                @error('service_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Service Info Display -->
                            <div id="serviceInfo" class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-xl p-6 border border-purple-200 shadow-md {{ $selectedService ? 'block' : 'hidden' }} transition-all duration-300">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="font-bold text-gray-900 text-lg">Detail Layanan</h3>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center p-3 bg-white/60 rounded-lg">
                                        <span class="text-gray-600 font-medium">Harga:</span>
                                        <span id="servicePrice" class="font-bold text-purple-600 text-lg">{{ $selectedService?->formatted_price ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-white/60 rounded-lg">
                                        <span class="text-gray-600 font-medium">Durasi:</span>
                                        <span id="serviceDuration" class="font-bold text-blue-600">{{ $selectedService?->duration_minutes ?? '-' }} menit</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date and Time -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                            <div>
                                <label for="booking_date" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Tanggal Booking <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="booking_date" id="booking_date" required
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('booking_date') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('booking_date') border-red-500 @enderror transition-all duration-300 hover:border-blue-300 bg-white shadow-sm">
                                @error('booking_date')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="booking_time" class="block text-sm font-bold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Waktu Pelaksanaan <span class="text-red-500">*</span>
                                </label>
                                <select name="booking_time" id="booking_time" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('booking_time') border-red-500 @enderror transition-all duration-300 hover:border-indigo-300 bg-white shadow-sm">
                                    <option value="">-- Pilih Waktu --</option>
                                    @foreach(['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'] as $time)
                                        <option value="{{ $time }}" {{ old('booking_time') == $time ? 'selected' : '' }}>
                                            {{ $time }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('booking_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pelanggan</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="customer_name" id="customer_name" required
                                           value="{{ old('customer_name', auth()->user()->name) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('customer_name') border-red-500 @enderror">
                                    @error('customer_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" name="customer_phone" id="customer_phone" required
                                           value="{{ old('customer_phone') }}"
                                           placeholder="contoh: 08123456789"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('customer_phone') border-red-500 @enderror">
                                    @error('customer_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="customer_email" id="customer_email" required
                                       value="{{ old('customer_email', auth()->user()->email) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('customer_email') border-red-500 @enderror">
                                @error('customer_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Special Requests -->
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Permintaan Khusus (Opsional)
                            </label>
                            <textarea name="notes" id="notes" rows="4"
                                      placeholder="Tuliskan permintaan khusus atau catatan untuk fotografer..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location Information (for outdoor services) -->
                        <div id="locationSection" class="mt-8 hidden">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Lokasi Pemotretan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="location_address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat Lokasi <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="location_address" id="location_address" rows="3" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                              placeholder="Masukkan alamat lengkap lokasi pemotretan...">{{ old('location_address') }}</textarea>
                                    @error('location_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                                        Latitude (Opsional)
                                    </label>
                                    <input type="number" name="latitude" id="latitude" step="any" 
                                           value="{{ old('latitude') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Contoh: -6.2088">
                                    @error('latitude')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                                        Longitude (Opsional)
                                    </label>
                                    <input type="number" name="longitude" id="longitude" step="any" 
                                           value="{{ old('longitude') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Contoh: 106.8456">
                                    @error('longitude')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Map Container -->
                            <div class="md:col-span-2 mt-6">
                                <div class="flex items-center justify-between mb-3">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Pilih Lokasi di Peta
                                    </label>
                                    <div class="space-x-2">
                                        <button type="button" id="getCurrentLocation" 
                                                class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            Lokasi Saya
                                        </button>
                                        <button type="button" id="searchLocation" 
                                                class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                            </svg>
                                            Cari Alamat
                                        </button>
                                    </div>
                                </div>
                                <div id="mapContainer" class="border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                                    <div id="locationMap" style="height: 300px;"></div>
                                </div>
                            </div>
                            
                            <p class="mt-4 text-sm text-gray-600 md:col-span-2">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                💡 <strong>Tips:</strong> Klik pada peta untuk memilih lokasi, atau gunakan tombol "Lokasi Saya" untuk menggunakan GPS Anda. Koordinat akan otomatis terisi.
                            </p>
                        </div>

                        <!-- Payment Method -->
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Metode Pembayaran</h3>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="radio" name="payment_type" id="payment_full" value="full" 
                                           class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" 
                                           {{ old('payment_type', 'full') == 'full' ? 'checked' : '' }} required>
                                    <label for="payment_full" class="ml-3 block text-sm font-medium text-gray-700">
                                        <span class="font-semibold">Pembayaran Tunai (Penuh)</span>
                                        <p class="text-gray-600 text-sm mt-1">Bayar seluruh biaya saat sesi foto selesai</p>
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="radio" name="payment_type" id="payment_dp" value="dp" 
                                           class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500" 
                                           {{ old('payment_type') == 'dp' ? 'checked' : '' }}>
                                    <label for="payment_dp" class="ml-3 block text-sm font-medium text-gray-700">
                                        <span class="font-semibold">Down Payment (DP)</span>
                                        <p class="text-gray-600 text-sm mt-1">Bayar DP 30% sekarang, sisanya setelah foto selesai</p>
                                    </label>
                                </div>
                            </div>
                            @error('payment_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Price Display -->
                        <div id="totalPriceSection" class="mt-8 bg-gray-50 rounded-lg p-4 {{ $selectedService ? 'block' : 'hidden' }}">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-medium text-gray-900">Total Harga:</span>
                                    <span id="totalPrice" class="text-2xl font-bold text-blue-600">{{ $selectedService?->formatted_price ?? 'Rp 0' }}</span>
                                </div>
                                
                                <!-- DP Information (hidden by default) -->
                                <div id="dpInfo" class="hidden border-t pt-3 space-y-2">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">DP (30%):</span>
                                        <span id="dpAmount" class="font-medium text-green-600">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Sisa Pembayaran:</span>
                                        <span id="remainingAmount" class="font-medium text-orange-600">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-3">* Harga belum termasuk biaya tambahan jika ada</p>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mt-6">
                            <div class="flex items-start">
                                <input type="checkbox" name="agree_terms" id="agree_terms" required
                                       class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="agree_terms" class="ml-2 text-sm text-gray-700">
                                    Saya setuju dengan <a href="#" class="text-blue-600 hover:text-blue-500 underline">syarat dan ketentuan</a> 
                                    yang berlaku di Yujin Foto Studio <span class="text-red-500">*</span>
                                </label>
                            </div>
                            @error('agree_terms')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-end">
                            <a href="{{ route('customer.services') }}" 
                               class="px-8 py-4 border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 text-center font-semibold transition-all duration-300 hover:border-gray-400 hover:shadow-md transform hover:scale-105">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Kembali ke Layanan
                            </a>
                            <button type="submit" 
                                    class="px-10 py-4 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl hover:from-purple-700 hover:to-blue-700 focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 font-bold shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Buat Booking
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Booking Information -->
            <div class="mt-12 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-200 shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-blue-900">Informasi Penting</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white/60 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-blue-800">Booking akan dikonfirmasi secara otomatis</span>
                        </div>
                    </div>
                    <div class="bg-white/60 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-blue-800">Pembatalan dapat dilakukan maksimal 24 jam sebelum jadwal</span>
                        </div>
                    </div>
                    <div class="bg-white/60 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-blue-800">Mohon datang 15 menit sebelum jadwal untuk persiapan</span>
                        </div>
                    </div>
                    <div class="bg-white/60 rounded-xl p-4 border border-blue-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-blue-800">Hasil foto akan dikirim dalam 3-7 hari kerja</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Leaflet.js CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    
    <!-- Custom CSS for disabled options -->
    <style>
        select option:disabled {
            background-color: #e5e5e5 !important;
            color: #999 !important;
            font-style: italic;
        }
        
        /* Additional styling for booking time select */
        #booking_time option:disabled {
            background-color: #f3f4f6 !important;
            color: #6b7280 !important;
            cursor: not-allowed;
        }
        
        /* Map styling */
        .leaflet-container {
            font-family: inherit;
        }
        
        .map-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8fafc;
            color: #6b7280;
        }
        
        .location-marker {
            background-color: #dc2626;
            border: 3px solid #ffffff;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .search-box {
            background: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            margin: 8px;
            z-index: 1000;
        }
    </style>

    <script>
        let currentPrice = 0;
        let bookedTimes = [];
        let currentDate = '';
        let currentServiceId = '';
        
        // Map variables
        let map = null;
        let marker = null;
        let isMapInitialized = false;
        
        // Service selection handler
        document.getElementById('service_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const serviceInfo = document.getElementById('serviceInfo');
            const totalPriceSection = document.getElementById('totalPriceSection');
            const locationSection = document.getElementById('locationSection');
            
            if (selectedOption.value) {
                currentPrice = parseInt(selectedOption.dataset.price);
                const duration = selectedOption.dataset.duration;
                const category = selectedOption.dataset.category;
                
                // Update service info
                document.getElementById('servicePrice').textContent = formatPrice(currentPrice);
                document.getElementById('serviceDuration').textContent = duration + ' menit';
                document.getElementById('totalPrice').textContent = formatPrice(currentPrice);
                
                // Show/hide location fields based on service category
                if (category === 'Outdoor Photography') {
                    locationSection.classList.remove('hidden');
                    document.getElementById('location_address').required = true;
                    
                    // Initialize map if not already initialized
                    if (!isMapInitialized) {
                        setTimeout(() => initializeMap(), 100); // Small delay to ensure container is visible
                    }
                } else {
                    locationSection.classList.add('hidden');
                    document.getElementById('location_address').required = false;
                    // Clear location fields when hidden
                    document.getElementById('location_address').value = '';
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
                }
                
                // Update payment info based on current selection
                updatePaymentInfo();
                
                // Trigger availability check if date is already selected
                const bookingDate = document.getElementById('booking_date').value;
                if (bookingDate) {
                    document.getElementById('booking_date').dispatchEvent(new Event('change'));
                }
                
                serviceInfo.classList.remove('hidden');
                totalPriceSection.classList.remove('hidden');
            } else {
                currentPrice = 0;
                serviceInfo.classList.add('hidden');
                totalPriceSection.classList.add('hidden');
                locationSection.classList.add('hidden');
                document.getElementById('location_address').required = false;
            }
        });
        
        // Payment type change handler
        document.querySelectorAll('input[name="payment_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                updatePaymentInfo();
            });
        });
        
        // Update payment information
        function updatePaymentInfo() {
            const paymentType = document.querySelector('input[name="payment_type"]:checked')?.value;
            const dpInfo = document.getElementById('dpInfo');
            
            if (paymentType === 'dp' && currentPrice > 0) {
                const dpAmount = Math.round(currentPrice * 0.3);
                const remainingAmount = currentPrice - dpAmount;
                
                document.getElementById('dpAmount').textContent = formatPrice(dpAmount);
                document.getElementById('remainingAmount').textContent = formatPrice(remainingAmount);
                dpInfo.classList.remove('hidden');
            } else {
                dpInfo.classList.add('hidden');
            }
        }

        // Format price function
        function formatPrice(price) {
            return 'Rp ' + parseInt(price).toLocaleString('id-ID');
        }

        // Initialize map for location selection
        function initializeMap() {
            if (isMapInitialized) return;
            
            try {
                // Default location (Jakarta)
                const defaultLat = -6.2088;
                const defaultLng = 106.8456;
                
                // Initialize map
                map = L.map('locationMap').setView([defaultLat, defaultLng], 13);
                
                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 18,
                }).addTo(map);
                
                // Add click event listener to map
                map.on('click', function(e) {
                    setLocationOnMap(e.latlng.lat, e.latlng.lng);
                    reverseGeocode(e.latlng.lat, e.latlng.lng);
                });
                
                isMapInitialized = true;
                
                // Load existing coordinates if available
                const existingLat = document.getElementById('latitude').value;
                const existingLng = document.getElementById('longitude').value;
                if (existingLat && existingLng) {
                    setLocationOnMap(parseFloat(existingLat), parseFloat(existingLng));
                }
                
            } catch (error) {
                console.error('Error initializing map:', error);
                document.getElementById('locationMap').innerHTML = 
                    '<div class="map-loading">Error loading map. Please refresh the page.</div>';
            }
        }
        
        // Set location marker on map
        function setLocationOnMap(lat, lng) {
            // Update form fields
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
            
            // Remove existing marker
            if (marker) {
                map.removeLayer(marker);
            }
            
            // Add new marker
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);
            
            // Add drag event to marker
            marker.on('dragend', function(e) {
                const position = e.target.getLatLng();
                setLocationOnMap(position.lat, position.lng);
                reverseGeocode(position.lat, position.lng);
            });
            
            // Center map on marker
            map.setView([lat, lng], map.getZoom());
        }
        
        // Reverse geocoding to get address from coordinates
        function reverseGeocode(lat, lng) {
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.display_name) {
                        // Update address field with geocoded address
                        const addressField = document.getElementById('location_address');
                        if (!addressField.value.trim()) {
                            addressField.value = data.display_name;
                        }
                    }
                })
                .catch(error => console.error('Reverse geocoding error:', error));
        }
        
        // Get current location using GPS
        function getCurrentLocation() {
            if (navigator.geolocation) {
                const button = document.getElementById('getCurrentLocation');
                const originalText = button.innerHTML;
                
                // Show loading state
                button.innerHTML = '<svg class="w-3 h-3 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mencari...';
                button.disabled = true;
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        setLocationOnMap(lat, lng);
                        reverseGeocode(lat, lng);
                        
                        // Restore button
                        button.innerHTML = originalText;
                        button.disabled = false;
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Lokasi Ditemukan!',
                            text: 'Lokasi Anda berhasil ditemukan dan diset pada peta.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    function(error) {
                        // Restore button
                        button.innerHTML = originalText;
                        button.disabled = false;
                        
                        let errorMessage = 'Tidak dapat mengakses lokasi Anda.';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage = 'Akses lokasi ditolak. Silakan aktifkan lokasi di browser Anda.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = 'Informasi lokasi tidak tersedia.';
                                break;
                            case error.TIMEOUT:
                                errorMessage = 'Timeout dalam mendapatkan lokasi.';
                                break;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Lokasi',
                            text: errorMessage
                        });
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Geolocation Not Supported',
                    text: 'Browser Anda tidak mendukung fitur geolocation.'
                });
            }
        }
        
        // Search location by address
        function searchLocation() {
            Swal.fire({
                title: 'Cari Lokasi',
                input: 'text',
                inputLabel: 'Masukkan alamat atau nama tempat',
                inputPlaceholder: 'Contoh: Monas Jakarta, atau nama jalan...',
                showCancelButton: true,
                confirmButtonText: 'Cari',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silakan masukkan alamat yang ingin dicari!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const address = result.value;
                    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1&countrycodes=id`;
                    
                    // Show loading
                    Swal.fire({
                        title: 'Mencari Lokasi...',
                        html: 'Sedang mencari lokasi yang Anda maksud.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                    });
                    
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                const location = data[0];
                                const lat = parseFloat(location.lat);
                                const lng = parseFloat(location.lon);
                                
                                setLocationOnMap(lat, lng);
                                
                                // Update address field
                                document.getElementById('location_address').value = location.display_name;
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Lokasi Ditemukan!',
                                    text: `Lokasi "${address}" berhasil ditemukan dan diset pada peta.`,
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Lokasi Tidak Ditemukan',
                                    text: 'Tidak dapat menemukan lokasi yang Anda cari. Coba gunakan alamat yang lebih spesifik.',
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Geocoding error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mencari lokasi. Silakan coba lagi.',
                            });
                        });
                }
            });
        }

        // Handle date change to fetch booked times
        document.getElementById('booking_date').addEventListener('change', function() {
            const date = this.value;
            const serviceId = document.getElementById('service_id').value;

            if (serviceId && date) {
                fetch(`/customer/booking/check-availability?service_id=${serviceId}&booking_date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        bookedTimes = data.booked_times;
                        currentDate = date;
                        currentServiceId = serviceId;
                        updateBookingTimes();
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        // Update booking time options based on availability
        function updateBookingTimes() {
            const bookingTimeSelect = document.getElementById('booking_time');
            bookingTimeSelect.innerHTML = '<option value="">-- Pilih Waktu --</option>';

            ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'].forEach(time => {
                const option = document.createElement('option');
                option.value = time;
                
                if (bookedTimes.includes(time)) {
                    option.textContent = `${time} (Sudah Dipesan)`;
                    option.disabled = true;
                    option.style.backgroundColor = '#d3d3d3'; // greyed out
                    option.style.color = '#666'; // greyed out text
                } else {
                    option.textContent = time;
                }

                bookingTimeSelect.appendChild(option);
            });
        }
        
        // Handle booking time selection to show alert for booked times
        document.getElementById('booking_time').addEventListener('change', function() {
            const selectedTime = this.value;
            
            if (bookedTimes.includes(selectedTime)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Waktu Tidak Tersedia',
                    text: 'Maaf, pada jam berikut sudah ada yang melakukan booking. Silakan pilih waktu lain.',
                    confirmButtonText: 'OK'
                });
                // Reset selection
                this.value = '';
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const serviceId = document.getElementById('service_id').value;
            const bookingDate = document.getElementById('booking_date').value;
            const bookingTime = document.getElementById('booking_time').value;
            const agreeTerms = document.getElementById('agree_terms').checked;
            const paymentType = document.querySelector('input[name="payment_type"]:checked')?.value;

            if (!serviceId || !bookingDate || !bookingTime || !agreeTerms || !paymentType) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Mohon lengkapi semua field yang wajib diisi',
                });
                return false;
            }

            // Check if booking date is not in the past
            const selectedDate = new Date(bookingDate);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tanggal booking tidak boleh di masa lalu',
                });
                return false;
            }
            
            if (bookedTimes.includes(bookingTime)) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Waktu tersebut sudah dibooking. Silakan pilih waktu lain.',
                });
                return false;
            }
        });

        // Initialize payment info and check availability on page load
        document.addEventListener('DOMContentLoaded', function() {
            const serviceSelect = document.getElementById('service_id');
            if (serviceSelect.value) {
                serviceSelect.dispatchEvent(new Event('change'));
            }
            const bookingDate = document.getElementById('booking_date');
            if(bookingDate.value) {
                bookingDate.dispatchEvent(new Event('change'));
            }
            
            // Add event listeners for map buttons
            document.getElementById('getCurrentLocation').addEventListener('click', getCurrentLocation);
            document.getElementById('searchLocation').addEventListener('click', searchLocation);
        });
    </script>
</x-layouts.app>
