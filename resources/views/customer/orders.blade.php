<x-layouts.app :title="'Status Pemesanan - ' . config('app.name')" :showNavigation="true" :showFooter="true">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12 relative">
                <!-- Background decoration -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50 via-purple-50 to-pink-50 rounded-3xl opacity-50 blur-3xl"></div>
                <div class="relative">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full mb-6 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-5xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-4">
                        Status Pemesanan & Pembayaran
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        Lihat dan kelola booking foto session Anda dengan mudah dan nyaman
                    </p>
                    <!-- Decorative elements -->
                    <div class="flex justify-center mt-6 space-x-2">
                        <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse"></div>
                        <div class="w-3 h-3 bg-purple-400 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                        <div class="w-3 h-3 bg-pink-400 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            </div>

        @if($bookings->count() > 0)
            <!-- Orders List -->
            <div class="space-y-8">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 hover:shadow-2xl hover:border-blue-300 transition-all duration-500 transform hover:-translate-y-1 relative group">
                        <!-- Decorative corner elements -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-400 to-purple-400 opacity-10 rounded-bl-full"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-pink-400 to-orange-400 opacity-10 rounded-tr-full"></div>
                        
                        <!-- Order Header with Numbering -->
                        <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 px-6 py-5 border-b border-gray-200 relative">
                            <!-- Subtle pattern overlay -->
                            <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent"></div>
                            <div class="flex items-center justify-between relative">
                                <div class="flex items-center space-x-4">
                                    <!-- Order Number Badge -->
                                    <div class="flex items-center justify-center w-14 h-14 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full font-bold text-lg shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                        <span class="relative">
                                            {{ $loop->iteration }}
                                            <div class="absolute inset-0 bg-white/20 rounded-full animate-ping"></div>
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">
                                            {{ $booking->service->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <span class="font-medium">Booking #{{ $booking->booking_number }}</span>
                                        </p>
                                    </div>
                                </div>
                                <!-- Status Badge -->
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <span class="inline-flex px-5 py-3 text-sm font-bold rounded-full shadow-lg transform transition-all duration-300 hover:scale-105
                                            @if($booking->status == 'pending') bg-gradient-to-r from-yellow-400 to-orange-400 text-white
                                            @elseif($booking->status == 'confirmed') bg-gradient-to-r from-blue-500 to-indigo-500 text-white
                                            @elseif($booking->status == 'completed') bg-gradient-to-r from-green-500 to-emerald-500 text-white
                                            @else bg-gradient-to-r from-red-500 to-pink-500 text-white @endif">
                                            @if($booking->status == 'pending')
                                                <svg class="w-4 h-4 mr-2 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                            @elseif($booking->status == 'confirmed')
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                            @elseif($booking->status == 'completed')
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                            {{ $booking->status_label }}
                                        </span>
                                        <!-- Glowing effect -->
                                        <div class="absolute inset-0 rounded-full blur-md opacity-30
                                            @if($booking->status == 'pending') bg-gradient-to-r from-yellow-400 to-orange-400
                                            @elseif($booking->status == 'confirmed') bg-gradient-to-r from-blue-500 to-indigo-500
                                            @elseif($booking->status == 'completed') bg-gradient-to-r from-green-500 to-emerald-500
                                            @else bg-gradient-to-r from-red-500 to-pink-500 @endif"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Content -->
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between">
                                <!-- Order Info -->
                                <div class="flex-1">
                                    
                                    <!-- Key Information Cards -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                                        <!-- Basic Info Card -->
                                        <div class="bg-gradient-to-br from-slate-50 to-gray-100 rounded-xl p-5 border border-gray-200 shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 relative overflow-hidden">
                                            <!-- Background pattern -->
                                            <div class="absolute top-0 right-0 w-20 h-20 bg-blue-400 opacity-5 rounded-full -mr-10 -mt-10"></div>
                                            <div class="relative">
                                                <div class="flex items-center mb-4">
                                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                        </svg>
                                                    </div>
                                                    <h4 class="font-bold text-gray-900 text-lg">Informasi Dasar</h4>
                                                </div>
                                            </div>
                                            <div class="space-y-2 text-sm">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Kategori:</span>
                                                    <span class="font-medium text-gray-900">{{ $booking->service->category->name }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Durasi:</span>
                                                    <span class="font-medium text-gray-900">{{ $booking->service->duration_minutes }} menit</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Schedule Card -->
                                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                            <div class="flex items-center mb-3">
                                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <h4 class="font-semibold text-blue-900">Jadwal Session</h4>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-lg font-bold text-blue-900">{{ $booking->booking_date->format('d M Y') }}</p>
                                                <p class="text-2xl font-bold text-blue-800 mt-1">{{ date('H:i', strtotime($booking->booking_time)) }}</p>
                                                <p class="text-sm text-blue-700 mt-1">
                                                    @php
                                                        $days = [
                                                            'Sunday' => 'Minggu',
                                                            'Monday' => 'Senin',
                                                            'Tuesday' => 'Selasa',
                                                            'Wednesday' => 'Rabu',
                                                            'Thursday' => 'Kamis',
                                                            'Friday' => 'Jumat',
                                                            'Saturday' => 'Sabtu'
                                                        ];
                                                        $englishDay = $booking->booking_date->format('l');
                                                        $indonesianDay = $days[$englishDay] ?? $englishDay;
                                                    @endphp
                                                    {{ $indonesianDay }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <!-- Payment Card -->
                                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                            <div class="flex items-center mb-3">
                                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                <h4 class="font-semibold text-green-900">Pembayaran</h4>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-2xl font-bold text-green-900">{{ $booking->formatted_total_price }}</p>
                                                <div class="mt-2">
                                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                                        @if($booking->payment_type == 'full') bg-green-100 text-green-800
                                                        @else bg-blue-100 text-blue-800 @endif">
                                                        {{ $booking->payment_type_label }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($booking->service->category->name === 'Outdoor Photography' && $booking->location_address)
                                        <div class="mt-4 p-4 bg-green-50 rounded-lg border border-green-200">
                                            <h4 class="font-medium text-green-900 mb-2">📍 Lokasi Outdoor Session</h4>
                                            <div class="text-sm text-green-800">
                                                <p class="font-medium mb-1">{{ $booking->location_address }}</p>
                                                @if($booking->latitude && $booking->longitude)
                                                    <p class="text-green-700">Koordinat: {{ $booking->latitude }}, {{ $booking->longitude }}</p>
                                                    <a href="https://maps.google.com/maps?q={{ $booking->latitude }},{{ $booking->longitude }}" 
                                                       target="_blank" 
                                                       class="inline-flex items-center text-green-600 hover:text-green-800 text-sm mt-1">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                        Lihat di Google Maps
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($booking->payment_type == 'dp')
                                        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                                            <h4 class="font-medium text-blue-900 mb-2">Detail Pembayaran DP</h4>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                <div>
                                                    <p class="text-blue-700">DP (30%): <span class="font-semibold">{{ $booking->formatted_dp_amount }}</span></p>
                                                </div>
                                                <div>
                                                    <p class="text-orange-700">Sisa Pembayaran: <span class="font-semibold">{{ $booking->formatted_remaining_amount }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($booking->notes)
                                        <div class="mt-6">
                                            <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-200 shadow-md hover:shadow-lg transition-all duration-300 relative overflow-hidden">
                                                <!-- Background decoration -->
                                                <div class="absolute top-0 right-0 w-16 h-16 bg-amber-400 opacity-5 rounded-full -mr-8 -mt-8"></div>
                                                <div class="absolute bottom-0 left-0 w-12 h-12 bg-orange-400 opacity-5 rounded-full -ml-6 -mb-6"></div>
                                                
                                                <div class="relative">
                                                    <div class="flex items-center mb-3">
                                                        <div class="w-10 h-10 bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg flex items-center justify-center mr-3 shadow-lg">
                                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                            </svg>
                                                        </div>
                                                        <h4 class="font-bold text-gray-900 text-lg">Catatan Khusus</h4>
                                                    </div>
                                                    
                                                    <div class="bg-white/60 rounded-lg p-4 border border-amber-100">
                                                        <p class="text-gray-700 leading-relaxed italic">
                                                            "{{ $booking->notes }}"
                                                        </p>
                                                    </div>
                                                    
                                                    <!-- Small decorative element -->
                                                    <div class="flex justify-end mt-2">
                                                        <div class="flex space-x-1">
                                                            <div class="w-2 h-2 bg-amber-400 rounded-full opacity-60"></div>
                                                            <div class="w-2 h-2 bg-orange-400 rounded-full opacity-60"></div>
                                                            <div class="w-2 h-2 bg-amber-400 rounded-full opacity-60"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Payment Information -->
                                    @if($booking->payments && $booking->payments->count() > 0)
                                        <div class="mt-6 p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                                            <div class="flex items-center mb-4">
                                                <svg class="w-6 h-6 text-gray-700 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <h4 class="text-lg font-bold text-gray-900">Riwayat Pembayaran</h4>
                                            </div>
                                            
                                            @if($booking->payment_type === 'dp' && $booking->final_payment_deadline)
                                                <div class="mb-4 p-3 {{ $booking->is_payment_overdue ? 'bg-red-50 border-red-200' : 'bg-blue-50 border-blue-200' }} border rounded-lg">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 {{ $booking->is_payment_overdue ? 'text-red-600' : 'text-blue-600' }} mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                        </svg>
                                                        <span class="text-sm {{ $booking->is_payment_overdue ? 'text-red-800' : 'text-blue-800' }} font-medium">
                                                            {{ $booking->is_payment_overdue ? 'Deadline Terlewat!' : 'Deadline Pelunasan' }}
                                                        </span>
                                                    </div>
                                                    <p class="text-xs {{ $booking->is_payment_overdue ? 'text-red-700' : 'text-blue-700' }} mt-1">
                                                        Batas waktu: {{ $booking->final_payment_deadline->format('d M Y H:i') }}
                                                        @if(!$booking->is_payment_overdue)
                                                            ({{ abs($booking->days_until_payment_deadline) }} hari lagi)
                                                        @else
                                                            (Terlambat {{ abs($booking->days_until_payment_deadline) }} hari)
                                                        @endif
                                                    </p>
                                                </div>
                                            @endif
                                            
                                            @foreach($booking->payments as $payment)
                                                <div class="mb-4 p-4 border-2 rounded-xl {{ $loop->index % 2 == 0 ? 'bg-white border-blue-200' : 'bg-blue-50 border-blue-300' }} shadow-sm">
                                                    <div class="flex justify-between items-center mb-3">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                                                {{ $loop->iteration }}
                                                            </div>
                                                            <div>
                                                                <h5 class="font-bold text-gray-900 text-lg">
                                                                    {{ $payment->payment_number }}
                                                                </h5>
                                                                @if($booking->payment_type === 'dp')
                                                                    <span class="text-xs px-3 py-1 rounded-full font-bold {{ $payment->amount == $booking->dp_amount ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                                                        {{ $payment->amount == $booking->dp_amount ? 'DP (Down Payment)' : 'Pelunasan' }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <p class="font-bold text-xl text-gray-900">{{ $payment->formatted_amount }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="grid grid-cols-2 gap-4 text-sm mb-3">
                                                        <div>
                                                            <p class="text-gray-600">Status Pembayaran:</p>
                                                            @php
                                                                $paymentStatusClasses = [
                                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                                    'paid' => 'bg-green-100 text-green-800',
                                                                    'failed' => 'bg-red-100 text-red-800',
                                                                    'refunded' => 'bg-gray-100 text-gray-800',
                                                                ];
                                                            @endphp
                                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $paymentStatusClasses[$payment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                                {{ $payment->status_label }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Status Verifikasi:</p>
                                                            @php
                                                                $verificationStatusClasses = [
                                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                                    'verified' => 'bg-green-100 text-green-800',
                                                                    'rejected' => 'bg-red-100 text-red-800',
                                                                ];
                                                            @endphp
                                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $verificationStatusClasses[$payment->verification_status] ?? 'bg-gray-100 text-gray-800' }}">
                                                                {{ $payment->verification_status_label }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    
                                                    @if($payment->payment_method)
                                                        <div class="text-sm mb-2">
                                                            <p class="text-gray-600">Metode Pembayaran:</p>
                                                            <p class="font-medium capitalize">{{ $payment->payment_method }}</p>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($payment->paid_at)
                                                        <div class="text-sm mb-2">
                                                            <p class="text-gray-600">Dibayar Pada:</p>
                                                            <p class="font-medium">{{ $payment->paid_at->format('d M Y H:i') }}</p>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($payment->verification_status === 'rejected' && $payment->verification_notes)
                                                        <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded">
                                                            <p class="text-sm text-red-800">
                                                                <span class="font-medium">Catatan Penolakan:</span> {{ $payment->verification_notes }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($payment->status === 'pending')
                                                        <div class="mt-4 pt-3 border-t border-gray-200">
                                                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 flex items-center">
                                                                <svg class="w-4 h-4 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                                </svg>
                                                                <span class="text-sm text-yellow-800 font-medium">Menunggu Pembayaran</span>
                                                            </div>
                                                            <p class="text-xs text-yellow-700 mt-1">Silakan lakukan pembayaran sesuai instruksi di bawah ini.</p>
                                                            <div class="flex flex-col sm:flex-row gap-2 mt-3">
                                                                <button onclick="showPaymentInfo()" class="inline-flex items-center px-4 py-2 border border-green-500 text-sm font-bold rounded-lg text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-md transform transition duration-150 hover:scale-105">
                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                    </svg>
                                                                    📱 Cara Bayar
                                                                </button>
                                                                <button onclick="showUploadModal({{ $payment->id }})" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md transform transition duration-150 hover:scale-105">
                                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                                    </svg>
                                                                    Upload Bukti
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @elseif($payment->status === 'paid' && $payment->verification_status === 'pending')
                                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 flex items-center mt-4">
                                                            <svg class="w-4 h-4 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                            </svg>
                                                            <span class="text-sm text-blue-800 font-medium">Pembayaran Sedang Diverifikasi</span>
                                                        </div>
                                                    @elseif($payment->verification_status === 'verified')
                                                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 flex items-center mt-4">
                                                            <svg class="w-4 h-4 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                            </svg>
                                                            <span class="text-sm text-green-800 font-medium">Pembayaran Terverifikasi</span>
                                                        </div>
                                                        @if($booking->payment_type === 'dp' && $payment->amount == $booking->dp_amount)
                                                            <p class="text-xs text-orange-700 mt-1 font-medium">Catatan: Masih ada sisa pembayaran yang perlu dilunasi.</p>
                                                        @endif
                                                    @elseif($payment->verification_status === 'rejected')
                                                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 flex items-center mt-4">
                                                            <svg class="w-4 h-4 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                            </svg>
                                                            <span class="text-sm text-red-800 font-medium">Pembayaran Ditolak</span>
                                                        </div>
                                                        <p class="text-xs text-red-700 mt-1">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                    @elseif($booking->status === 'confirmed')
                                        <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-sm text-blue-800 font-medium">Booking Dikonfirmasi</span>
                                            </div>
                                            <p class="text-xs text-blue-700 mt-1">Admin sedang memproses pembayaran untuk booking Anda.</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="mt-6 lg:mt-0 lg:ml-6">
                                    <div class="bg-white rounded-lg p-4 border-2 border-dashed border-gray-300 min-w-[200px]">
                                        <h4 class="font-semibold text-gray-900 mb-3 text-center">Status Booking</h4>
                                        <div class="flex flex-col items-center space-y-3">
                                            @if($booking->status === 'pending')
                                                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                                <span class="text-sm text-yellow-800 font-medium text-center">Menunggu konfirmasi admin</span>
                                            @elseif($booking->status === 'confirmed')
                                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                                <span class="text-sm text-blue-800 font-medium text-center">Booking dikonfirmasi</span>
                                            @elseif($booking->status === 'completed')
                                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                                <span class="text-sm text-green-800 font-medium text-center">Sesi foto selesai</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($bookings->hasPages())
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-lg p-4 shadow-md border border-gray-200">
                        {{ $bookings->links() }}
                    </div>
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="mt-4 text-2xl font-medium text-gray-900">Belum ada pemesanan</h3>
                <p class="mt-2 text-lg text-gray-600">Anda belum membuat booking apapun. Mulai dengan menjelajahi layanan fotografi kami.</p>
                <div class="mt-8">
                    <a href="{{ route('customer.services') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                        Lihat Layanan
                    </a>
                </div>
            </div>
        @endif
        </div>
    </div>

<!-- Upload Payment Proof Modal -->
<div id="uploadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <form id="uploadForm" method="POST">
                @csrf
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Upload Bukti Pembayaran</h3>
                    <p class="text-sm text-gray-600">Silakan upload bukti pembayaran Anda untuk diverifikasi oleh admin.</p>
                </div>
                
                <div class="mb-4">
                    <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                        Bukti Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="payment_proof" 
                           id="payment_proof" 
                           required
                           placeholder="Link gambar atau referensi pembayaran..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Contoh: Link Google Drive, nomor referensi transfer, dll.</p>
                </div>
                
                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan (Opsional)
                    </label>
                    <textarea name="notes" 
                              id="notes" 
                              rows="3"
                              placeholder="Catatan tambahan mengenai pembayaran..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeUploadModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Upload Bukti
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function showUploadModal(paymentId) {
    const modal = document.getElementById('uploadModal');
    const form = document.getElementById('uploadForm');
    
    form.action = `/customer/payment/${paymentId}/upload-proof`;
    modal.classList.remove('hidden');
}

function showPaymentInfo() {
    Swal.fire({
        title: '💳 Cara Pembayaran',
        html: `
            <div class="text-left space-y-4">
                <div class="border-l-4 border-green-500 pl-4">
                    <h4 class="font-bold text-green-800">📱 E-Wallet</h4>
                    <div class="mt-2 space-y-2">
                        <div class="flex justify-between items-center">
                            <span><strong>DANA:</strong> 0881082209109</span>
                            <button onclick="copyToClipboard('0881082209109')" class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">Copy</button>
                        </div>
                        <div class="flex justify-between items-center">
                            <span><strong>GoPay:</strong> 0881082209109</span>
                            <button onclick="copyToClipboard('0881082209109')" class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200">Copy</button>
                        </div>
                    </div>
                </div>
                
                <div class="border-l-4 border-blue-500 pl-4">
                    <h4 class="font-bold text-blue-800">🏦 Transfer Bank</h4>
                    <div class="mt-2 space-y-2">
                        <div class="flex justify-between items-center">
                            <span><strong>BCA:</strong> 0338822553</span>
                            <button onclick="copyToClipboard('0338822553')" class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded hover:bg-blue-200">Copy</button>
                        </div>
                        <div class="flex justify-between items-center">
                            <span><strong>BNI:</strong> 0677789993</span>
                            <button onclick="copyToClipboard('0677789993')" class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded hover:bg-blue-200">Copy</button>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded text-sm">
                    <strong>📝 Catatan:</strong><br/>
                    • Setelah transfer, upload bukti pembayaran<br/>
                    • Sertakan nomor booking dalam berita transfer<br/>
                    • Admin akan verifikasi dalam 1x24 jam
                </div>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Mengerti',
        width: '500px',
        customClass: {
            popup: 'text-sm'
        }
    });
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        Swal.fire({
            icon: 'success',
            title: '✅ Disalin!',
            text: `Nomor ${text} telah disalin ke clipboard.`,
            timer: 1500,
            showConfirmButton: false
        });
    }, function(err) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Gagal menyalin. Silakan coba lagi.',
        });
    });
}

function closeUploadModal() {
    const modal = document.getElementById('uploadModal');
    const form = document.getElementById('uploadForm');
    
    modal.classList.add('hidden');
    form.reset();
}

// Close modal when clicking outside
document.getElementById('uploadModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUploadModal();
    }
});
</script>

</x-layouts.app>
