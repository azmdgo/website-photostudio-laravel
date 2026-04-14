{{-- Content untuk Detail Jadwal --}}
        {{-- Informasi Jadwal --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-info-circle me-2"></i>
                    Informasi Jadwal
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-hash me-2"></i>
                            <strong>Nomor Booking:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
        <span class="fw-bold fs-5">{{ $booking->booking_number }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-flag me-2"></i>
                            <strong>Status:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
                            @if($booking->status === 'confirmed')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Dikonfirmasi
                                </span>
                            @elseif($booking->status === 'pending')
                                <span class="badge bg-warning fs-6">
                                    <i class="bi bi-clock me-1"></i>
                                    Menunggu
                                </span>
                            @elseif($booking->status === 'cancelled')
                                <span class="badge bg-danger fs-6">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Dibatalkan
                                </span>
                            @elseif($booking->status === 'completed')
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-check-all me-1"></i>
                                    Selesai
                                </span>
                            @else
                                <span class="badge bg-secondary fs-6">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-calendar3 me-2"></i>
                            <strong>Tanggal:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
        <span>{{ $booking->booking_date->format('d M Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-clock me-2"></i>
                            <strong>Waktu:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
        <span>{{ date('H:i', strtotime($booking->booking_time)) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Detail Layanan --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-camera me-2"></i>
                    Detail Layanan
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-tag me-2"></i>
                            <strong>Kategori:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
                            <span class="fw-semibold">{{ $booking->service->category->name ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-box me-2"></i>
                            <strong>Paket:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
                            <span class="fw-semibold">{{ $booking->package_name ?? $booking->service->name }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-stopwatch me-2"></i>
                            <strong>Durasi:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
                            <span class="fw-semibold">{{ $booking->duration ?? $booking->service->duration ?? '60' }} menit</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-cash me-2"></i>
                            <strong>Harga:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
        <span>{{ $booking->formatted_total_price ?? 'Rp ' . number_format($booking->total_price ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-geo-alt me-2"></i>
                            <strong>Tipe Lokasi:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
                            @if($booking->service->is_outdoor ?? $booking->is_outdoor ?? false)
                                <span class="badge bg-warning fs-6">
                                    <i class="bi bi-sun me-1"></i>
                                    Outdoor
                                </span>
                            @elseif($booking->service->category->name && (str_contains(strtolower($booking->service->category->name), 'outdoor') || str_contains(strtolower($booking->service->name ?? ''), 'outdoor')))
                                <span class="badge bg-warning fs-6">
                                    <i class="bi bi-sun me-1"></i>
                                    Outdoor
                                </span>
                            @else
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-house me-1"></i>
                                    Indoor/Studio
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Deskripsi Layanan --}}
                    @if($booking->service->description)
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Deskripsi Layanan:</strong>
                        </div>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">{{ $booking->service->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Informasi Lokasi (hanya untuk Outdoor) --}}
        @if(
            ($booking->service->is_outdoor ?? false) || 
            ($booking->is_outdoor ?? false) || 
            (isset($booking->service->category->name) && str_contains(strtolower($booking->service->category->name), 'outdoor')) ||
            (isset($booking->service->name) && str_contains(strtolower($booking->service->name), 'outdoor')) ||
            !empty($booking->location_address) || 
            !empty($booking->location_latitude) || 
            !empty($booking->location_longitude)
        )
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-geo-alt me-2"></i>
                    Informasi Lokasi (Outdoor)
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-house-door me-2"></i>
                            <strong>Alamat Lengkap:</strong>
                        </div>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">
                                {{ $booking->location_address ?? $booking->address ?? $booking->venue_address ?? $booking->customer_address ?? $booking->booking_address ?? 'Alamat belum diisi' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-geo me-2"></i>
                            <strong>Latitude (GPS):</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
                            <span class="fw-semibold font-monospace">
                                {{ $booking->location_latitude ?? $booking->latitude ?? $booking->venue_latitude ?? 'Tidak ada' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-geo me-2"></i>
                            <strong>Longitude (GPS):</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
                            <span class="fw-semibold font-monospace">
                                {{ $booking->location_longitude ?? $booking->longitude ?? $booking->venue_longitude ?? 'Tidak ada' }}
                            </span>
                        </div>
                    </div>
                    
                    @php
                        $lat = $booking->location_latitude ?? $booking->latitude ?? $booking->venue_latitude ?? null;
                        $lng = $booking->location_longitude ?? $booking->longitude ?? $booking->venue_longitude ?? null;
                    @endphp
                    
                    @if($lat && $lng)
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-map me-2"></i>
                            <strong>Lihat di Peta:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
                            <a href="https://www.google.com/maps?q={{ $lat }},{{ $lng }}" 
                               target="_blank" 
                               class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-geo-alt me-2"></i>
                                Buka di Google Maps
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    @if($booking->location_notes ?? $booking->notes ?? $booking->venue_notes ?? $booking->address_notes)
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-sticky me-2"></i>
                            <strong>Catatan Lokasi:</strong>
                        </div>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">
                                {{ $booking->location_notes ?? $booking->venue_notes ?? $booking->address_notes ?? $booking->notes }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
        
        {{-- Informasi Pembayaran --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-credit-card me-2"></i>
                    Informasi Pembayaran
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-cash me-2"></i>
                            <strong>Total Harga:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
                            <span class="fw-bold fs-5">{{ $booking->formatted_total_price ?? 'Rp ' . number_format($booking->total_price ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-wallet me-2"></i>
                            <strong>Metode Pembayaran:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
                            @if($booking->payment_type === 'dp')
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-percent me-1"></i>
                                    Sistem DP
                                </span>
                            @elseif($booking->payment_type === 'full')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-all me-1"></i>
                                    Pembayaran Penuh
                                </span>
                            @else
                                <span class="badge bg-secondary fs-6">
                                    {{ ucfirst($booking->payment_type ?? 'Belum ditentukan') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    @if($booking->payment_type === 'dp')
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-cash me-2"></i>
                            <strong>Jumlah DP:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
        <span>{{ $booking->formatted_dp_amount ?? 'Rp ' . number_format($booking->dp_amount ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-cash me-2"></i>
                            <strong>Sisa Pembayaran:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
        <span>{{ $booking->formatted_remaining_amount ?? 'Rp ' . number_format(($booking->total_price ?? 0) - ($booking->dp_amount ?? 0), 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle me-2"></i>
                            <strong>Status Pembayaran:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
                            @if($booking->payment_status === 'paid')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Lunas
                                </span>
                            @elseif($booking->payment_status === 'partial')
                                <span class="badge bg-warning fs-6">
                                    <i class="bi bi-clock me-1"></i>
                                    Sebagian
                                </span>
                            @elseif($booking->payment_status === 'pending')
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-hourglass me-1"></i>
                                    Menunggu
                                </span>
                            @else
                                <span class="badge bg-secondary fs-6">
                                    {{ ucfirst($booking->payment_status ?? 'Belum dibayar') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Informasi Klien --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-person me-2"></i>
                    Informasi Klien
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-person-circle me-2"></i>
                            <strong>Nama:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
    <span>{{ $booking->customer_name ?? $booking->user->name }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-envelope me-2"></i>
                            <strong>Email:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
    <span>{{ $booking->customer_email ?? $booking->user->email }}</span>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-telephone me-2"></i>
                            <strong>Telepon:</strong>
                        </div>
                        <div class="bg-light p-2 rounded">
    @if($booking->customer_phone ?? $booking->user->phone)
        <span>{{ $booking->customer_phone ?? $booking->user->phone }}</span>
    @else
        <span class="text-muted fst-italic">Tidak disediakan</span>
    @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Catatan Tambahan --}}
        @if($booking->notes)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-sticky me-2"></i>
                    Catatan Tambahan
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning border-start border-warning border-4 rounded-0 mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    {{ $booking->notes }}
                </div>
            </div>
        </div>
        @endif
