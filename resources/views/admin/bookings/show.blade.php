@extends('admin.layouts.app')

@section('title', 'Detail Pemesanan')
@section('page-title', 'Booking #' . $booking->booking_number)

@section('page-actions')
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>
        Kembali ke Daftar Pemesanan
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Booking Details Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Detail Pemesanan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold">Nomor Booking:</td>
                                <td>{{ $booking->booking_number }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Nama Pelanggan:</td>
                                <td>{{ $booking->customer_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Email:</td>
                                <td>{{ $booking->customer_email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Telepon:</td>
                                <td>{{ $booking->customer_phone }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Layanan:</td>
                                <td>
                                    {{ $booking->service->name }}
                                    <br>
                                    <small class="text-muted">{{ $booking->service->category->name }}</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold">Tanggal Pelaksanaan:</td>
                                <td>{{ $booking->booking_date->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Waktu Pelaksanaan:</td>
                                <td>{{ date('H:i', strtotime($booking->booking_time)) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Total Harga:</td>
                                <td>
                                    <span class="h5 text-success">
                                        {{ $booking->formatted_total_price }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Metode Pembayaran:</td>
                                <td>
                                    @if($booking->payment_type === 'dp')
                                        <span class="badge bg-info">Down Payment (DP)</span>
                                        <br>
                                        <small class="text-muted">
                                            DP: {{ $booking->formatted_dp_amount }} <br>
                                            Sisa: {{ $booking->formatted_remaining_amount }}
                                        </small>
                                    @else
                                        <span class="badge bg-success">Pembayaran Penuh</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Status Pelaksanaan:</td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info', 
                                            'in_progress' => 'primary',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusClass = $statusClasses[$booking->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }} fs-6">
                                        {{ $booking->status_label }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">Dibuat:</td>
                                <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($booking->notes)
                    <hr>
                    <div>
                        <h6>Catatan Pelanggan:</h6>
                        <p class="text-muted">{{ $booking->notes }}</p>
                    </div>
                @endif
                
                @if($booking->service->category->name === 'Outdoor Photography' && $booking->location_address)
                    <hr>
                    <div>
                        <h6><i class="bi bi-geo-alt me-2"></i>Lokasi Outdoor Session:</h6>
                        <div class="bg-light rounded p-3">
                            <div class="mb-2">
                                <strong>Alamat:</strong>
                                <p class="mb-1">{{ $booking->location_address }}</p>
                            </div>
                            @if($booking->latitude && $booking->longitude)
                                <div class="mb-2">
                                    <strong>Koordinat GPS:</strong>
                                    <p class="mb-1 text-muted">{{ $booking->latitude }}, {{ $booking->longitude }}</p>
                                </div>
                                <div>
                                    <a href="https://maps.google.com/maps?q={{ $booking->latitude }},{{ $booking->longitude }}" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        Lihat di Google Maps
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Information Card -->
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-credit-card me-2"></i>
                    Informasi Pembayaran
                </h5>
                <div class="d-flex gap-2">
                    @if($booking->status === 'confirmed' && $booking->payments->count() === 0)
                        <form action="{{ route('admin.bookings.create-payment', $booking) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle me-1"></i>
                                Buat Pembayaran
                            </button>
                        </form>
                    @endif
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Refresh
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($booking->payments && $booking->payments->count() > 0)
                    <!-- Payment Summary for DP -->
                    @if($booking->payment_type === 'dp')
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="bg-light rounded p-3">
                                    <h6 class="mb-3"><i class="bi bi-info-circle me-2"></i>Ringkasan Pembayaran DP</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted">Total Harga</small>
                                            <div class="fw-bold">{{ $booking->formatted_total_price }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">DP (30%)</small>
                                            <div class="fw-bold text-primary">{{ $booking->formatted_dp_amount }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Sisa Pembayaran</small>
                                            <div class="fw-bold text-warning">{{ $booking->formatted_remaining_amount }}</div>
                                        </div>
                                    </div>
                                    @if($booking->final_payment_deadline)
                                        <div class="mt-2">
                                            <small class="text-muted">Deadline Pelunasan: </small>
                                            <span class="fw-semibold {{ $booking->is_payment_overdue ? 'text-danger' : 'text-info' }}">
                                                {{ $booking->final_payment_deadline->format('d M Y H:i') }}
                                                @if($booking->is_payment_overdue)
                                                    <span class="badge bg-danger ms-1">Terlewat</span>
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Payment List -->
                    <div class="row">
                        @foreach($booking->payments as $payment)
                            <div class="col-md-{{ $booking->payment_type === 'dp' ? '6' : '12' }}">
                                <div class="border rounded p-3 mb-3 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="mb-1">{{ $payment->payment_number }}</h6>
                                            @if($booking->payment_type === 'dp')
                                                <span class="badge {{ $payment->amount == $booking->dp_amount ? 'bg-primary' : 'bg-success' }}">
                                                    {{ $payment->amount == $booking->dp_amount ? 'DP (Down Payment)' : 'Pelunasan' }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-success">{{ $payment->formatted_amount }}</div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <span class="fw-semibold">Status Pembayaran: </span>
                                        @php
                                            $paymentStatusClasses = [
                                                'pending' => 'warning',
                                                'paid' => 'success',
                                                'failed' => 'danger',
                                                'refunded' => 'secondary'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $paymentStatusClasses[$payment->status] ?? 'secondary' }}">
                                            {{ $payment->status_label }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <span class="fw-semibold">Status Verifikasi: </span>
                                        @php
                                            $verificationStatusClasses = [
                                                'pending' => 'warning',
                                                'verified' => 'success',
                                                'rejected' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $verificationStatusClasses[$payment->verification_status] ?? 'secondary' }}">
                                            {{ $payment->verification_status_label }}
                                        </span>
                                    </div>
                                    
                                    @if($payment->payment_method)
                                        <div class="mb-2">
                                            <span class="fw-semibold">Metode: </span>
                                            {{ ucfirst($payment->payment_method) }}
                                        </div>
                                    @endif
                                    
                                    @if($payment->paid_at)
                                        <div class="mb-2">
                                            <span class="fw-semibold">Dibayar: </span>
                                            {{ $payment->paid_at->format('d M Y H:i') }}
                                        </div>
                                    @endif
                                    
                                    @if($payment->verified_at)
                                        <div class="mb-2">
                                            <span class="fw-semibold">Diverifikasi: </span>
                                            {{ $payment->verified_at->format('d M Y H:i') }}
                                            @if($payment->verifiedBy)
                                                oleh {{ $payment->verifiedBy->name }}
                                            @endif
                                        </div>
                                    @endif
                                    
                                    @if($payment->payment_proof)
                                        <div class="mb-2">
                                            <span class="fw-semibold">Bukti Pembayaran: </span>
                                            <br>
                                            <div class="mt-2">
                                                @if(filter_var($payment->payment_proof, FILTER_VALIDATE_URL))
                                                    <!-- Jika URL valid, tampilkan sebagai link -->
                                                    <a href="{{ $payment->payment_proof }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                        <i class="bi bi-link-45deg me-1"></i>
                                                        Lihat Bukti Pembayaran
                                                    </a>
                                                @else
                                                    <!-- Jika bukan URL, tampilkan sebagai teks -->
                                                    <div class="bg-light rounded p-2">
                                                        <small class="text-muted">{{ $payment->payment_proof }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($payment->notes)
                                        <div class="mb-2">
                                            <span class="fw-semibold">Catatan Pembayaran: </span>
                                            <small class="text-muted">{{ $payment->notes }}</small>
                                        </div>
                                    @endif
                                    
                                    @if($payment->verification_notes)
                                        <div class="mb-2">
                                            <span class="fw-semibold">Catatan Verifikasi: </span>
                                            <small class="text-muted">{{ $payment->verification_notes }}</small>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-3 text-center">
                                        @if($payment->status === 'pending')
                                            @if($payment->payment_proof)
                                                <div class="alert alert-info alert-sm mb-2">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    <strong>Bukti pembayaran telah diupload!</strong> Silakan tandai sebagai dibayar.
                                                </div>
                                            @else
                                                <div class="alert alert-warning alert-sm mb-2">
                                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                                    <strong>Menunggu customer mengupload bukti pembayaran</strong>
                                                </div>
                                            @endif
                                            <button class="btn btn-success btn-sm mb-2" onclick="markAsPaid({{ $payment->id }})">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Tandai Dibayar
                                            </button>
                                        @endif
                                        @if($payment->status === 'paid' && $payment->verification_status === 'pending')
                                            @if($payment->payment_proof)
                                                <div class="alert alert-success alert-sm mb-2">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    <strong>Siap untuk verifikasi!</strong> Periksa bukti pembayaran di atas.
                                                </div>
                                            @else
                                                <div class="alert alert-warning alert-sm mb-2">
                                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                                    <strong>Perhatian:</strong> Tidak ada bukti pembayaran yang diupload.
                                                </div>
                                            @endif
                                            <button class="btn btn-primary btn-sm mb-1" onclick="verifyPayment({{ $payment->id }}, 'verified')">
                                                <i class="bi bi-shield-check me-1"></i>
                                                Verifikasi
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="verifyPayment({{ $payment->id }}, 'rejected')">
                                                <i class="bi bi-x-circle me-1"></i>
                                                Tolak
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-credit-card text-muted" style="font-size: 3rem;"></i>
                        <h6 class="text-muted mt-2">Belum Ada Pembayaran</h6>
                        <p class="text-muted">
                            Pembayaran akan dibuat setelah booking dikonfirmasi.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Customer Information Card -->
        @if($booking->user)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-person me-2"></i>
                    Informasi Pelanggan
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                         style="width: 50px; height: 50px;">
                        {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h6 class="mb-1">{{ $booking->user->name }}</h6>
                        <p class="text-muted mb-1">{{ $booking->user->email }}</p>
                        <small class="text-muted">
                            Member since {{ $booking->user->created_at->format('M Y') }}
                        </small>
                    </div>
                </div>
                <hr>
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="h4 text-primary mb-0">{{ $booking->user->bookings()->count() }}</div>
                        <small class="text-muted">Total Bookings</small>
                    </div>
                    <div class="col-md-4">
                        <div class="h4 text-success mb-0">{{ $booking->user->bookings()->where('status', 'completed')->count() }}</div>
                        <small class="text-muted">Completed</small>
                    </div>
                    <div class="col-md-4">
                        <div class="h4 text-warning mb-0">{{ $booking->user->bookings()->where('status', 'pending')->count() }}</div>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Right Sidebar -->
    <div class="col-md-4">
        <!-- Quick Actions Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-gear me-2"></i>
                    Aksi Cepat
                </h5>
            </div>
            <div class="card-body">
                <!-- Update Booking Status -->
                <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Update Status Booking</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" onclick="return confirmStatusUpdate(event)">
                        <i class="bi bi-check-lg me-2"></i>
                        Update Status
                    </button>
                </form>

                <hr>

                <!-- Other Actions -->
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-info" onclick="printBooking()">
                        <i class="bi bi-printer me-2"></i>
                        Print Detail
                    </button>
                    
                    @if($booking->status === 'cancelled')
                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" 
                              onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-trash me-2"></i>
                                Hapus Booking
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Workflow Process Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-list-check me-2"></i>
                    Proses Verifikasi
                </h5>
            </div>
            <div class="card-body">
                <div class="workflow">
                    <!-- Step 1: Booking Verification -->
                    <div class="workflow-step">
                        <div class="d-flex align-items-center mb-2">
                            @if($booking->status === 'pending')
                                <div class="workflow-icon bg-warning">1</div>
                            @else
                                <div class="workflow-icon bg-success">
                                    <i class="bi bi-check"></i>
                                </div>
                            @endif
                            <div class="ms-3">
                                <h6 class="mb-0">Verifikasi Booking</h6>
                                <small class="text-muted">Admin konfirmasi booking</small>
                            </div>
                        </div>
                        @if($booking->status === 'pending')
                            <div class="alert alert-warning alert-sm">
                                <strong>Pending:</strong> Menunggu konfirmasi admin
                            </div>
                        @else
                            <div class="alert alert-success alert-sm">
                                <strong>Selesai:</strong> Booking dikonfirmasi pada {{ $booking->updated_at->format('d M Y H:i') }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Step 2: Payment Creation -->
                    <div class="workflow-step">
                        <div class="d-flex align-items-center mb-2">
                        @if($booking->status === 'pending')
                                <div class="workflow-icon bg-secondary">2</div>
                            @elseif($booking->status === 'confirmed' && $booking->payments->count() === 0)
                                <div class="workflow-icon bg-warning">2</div>
                            @else
                                <div class="workflow-icon bg-success">
                                    <i class="bi bi-check"></i>
                                </div>
                            @endif
                            <div class="ms-3">
                                <h6 class="mb-0">Buat Pembayaran</h6>
                                <small class="text-muted">Admin buat invoice pembayaran</small>
                            </div>
                        </div>
                        @if($booking->status === 'pending')
                            <div class="alert alert-secondary alert-sm">
                                <strong>Menunggu:</strong> Booking harus dikonfirmasi dulu
                            </div>
                        @elseif($booking->status === 'confirmed' && $booking->payments->count() === 0)
                            <div class="alert alert-warning alert-sm">
                                <strong>Pending:</strong> Silakan buat pembayaran
                            </div>
                        @else
                            <div class="alert alert-success alert-sm">
                                <strong>Selesai:</strong> Pembayaran dibuat
                                @if($booking->payment_type === 'dp')
                                    ({{ $booking->payments->count() }} pembayaran)
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <!-- Step 3: Payment Verification -->
                    @if($booking->payments && $booking->payments->count() > 0)
                        <div class="workflow-step">
                            <div class="d-flex align-items-center mb-2">
                                @php
                                    $allPaymentsVerified = $booking->payments->every(function($payment) {
                                        return $payment->verification_status === 'verified';
                                    });
                                    $hasRejectedPayment = $booking->payments->contains(function($payment) {
                                        return $payment->verification_status === 'rejected';
                                    });
                                    $hasPendingPayment = $booking->payments->contains(function($payment) {
                                        return $payment->verification_status === 'pending';
                                    });
                                @endphp
                                
                                @if($hasRejectedPayment)
                                    <div class="workflow-icon bg-danger">
                                        <i class="bi bi-x"></i>
                                    </div>
                                @elseif($allPaymentsVerified)
                                    <div class="workflow-icon bg-success">
                                        <i class="bi bi-check"></i>
                                    </div>
                                @else
                                    <div class="workflow-icon bg-warning">3</div>
                                @endif
                                
                                <div class="ms-3">
                                    <h6 class="mb-0">Verifikasi Pembayaran</h6>
                                    <small class="text-muted">
                                        @if($booking->payment_type === 'dp')
                                            Verifikasi DP dan pelunasan
                                        @else
                                            Admin verifikasi pembayaran
                                        @endif
                                    </small>
                                </div>
                            </div>
                            
                            @if($hasRejectedPayment)
                                <div class="alert alert-danger alert-sm">
                                    <strong>Ditolak:</strong> Ada pembayaran yang ditolak
                                </div>
                            @elseif($allPaymentsVerified)
                                <div class="alert alert-success alert-sm">
                                    <strong>Selesai:</strong> 
                                    @if($booking->payment_type === 'dp')
                                        Semua pembayaran diverifikasi
                                    @else
                                        Pembayaran diverifikasi
                                    @endif
                                </div>
                            @else
                                <div class="alert alert-warning alert-sm">
                                    <strong>Pending:</strong> 
                                    @if($booking->payment_type === 'dp')
                                        Menunggu verifikasi pembayaran ({{ $booking->payments->where('verification_status', 'verified')->count() }}/{{ $booking->payments->count() }} selesai)
                                    @else
                                        Menunggu verifikasi pembayaran
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <!-- Step 4: Booking Completion -->
                    <div class="workflow-step">
                        <div class="d-flex align-items-center mb-2">
                            @if($booking->status === 'completed')
                                <div class="workflow-icon bg-success">
                                    <i class="bi bi-check"></i>
                                </div>
                            @else
                                <div class="workflow-icon bg-secondary">4</div>
                            @endif
                            <div class="ms-3">
                                <h6 class="mb-0">Pelaksanaan Selesai</h6>
                                <small class="text-muted">Sesi foto selesai dilakukan</small>
                            </div>
                        </div>
                        @if($booking->status === 'completed')
                            <div class="alert alert-success alert-sm">
                                <strong>Selesai:</strong> Booking telah selesai dilaksanakan
                                @if($booking->photo_session_completed_at)
                                    pada {{ $booking->photo_session_completed_at->format('d M Y H:i') }}
                                @endif
                            </div>
                        @else
                            <div class="alert alert-secondary alert-sm">
                                <strong>Menunggu:</strong> Pelaksanaan sesi foto belum selesai
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Verification Modal -->
<div class="modal fade" id="verifyPaymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="verifyPaymentForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="verification_status" id="verificationStatus">
                    <div class="mb-3">
                        <label for="verification_notes" class="form-label">Catatan Verifikasi</label>
                        <textarea class="form-control" name="verification_notes" id="verification_notes" 
                                  rows="3" placeholder="Tambahkan catatan verifikasi..."></textarea>
                        <small class="form-text text-muted">Contoh: "Bukti pembayaran valid", "Transfer berhasil dikonfirmasi", "Bukti pembayaran tidak jelas", dll.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="verifySubmitBtn">Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Mark as Paid Modal -->
<div class="modal fade" id="markPaidModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="markPaidForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Tandai Sebagai Dibayar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" name="payment_method" id="payment_method" required>
                            <option value="">Pilih Metode</option>
                            <option value="cash">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="ewallet">E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                        <input type="text" class="form-control" name="payment_proof" id="payment_proof" 
                               placeholder="Link/referensi bukti pembayaran...">
                    </div>
                    <div class="mb-3">
                        <label for="payment_notes" class="form-label">Catatan</label>
                        <textarea class="form-control" name="notes" id="payment_notes" 
                                  rows="3" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tandai Dibayar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.workflow-step {
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #dee2e6;
}

.workflow-step:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.workflow-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 0.875rem;
}

.alert-sm {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    margin-bottom: 0;
}
</style>

<script>
function verifyPayment(paymentId, status) {
    const modal = new bootstrap.Modal(document.getElementById('verifyPaymentModal'));
    const form = document.getElementById('verifyPaymentForm');
    const statusInput = document.getElementById('verificationStatus');
    const submitBtn = document.getElementById('verifySubmitBtn');
    const notesTextarea = document.getElementById('verification_notes');
    
    form.action = `/admin/payments/${paymentId}/verify`;
    statusInput.value = status;
    
    if (status === 'verified') {
        submitBtn.className = 'btn btn-success';
        submitBtn.textContent = 'Verifikasi';
        notesTextarea.placeholder = 'Contoh: "Bukti pembayaran valid dan sesuai", "Transfer berhasil dikonfirmasi"';
    } else {
        submitBtn.className = 'btn btn-danger';
        submitBtn.textContent = 'Tolak';
        notesTextarea.placeholder = 'Contoh: "Bukti pembayaran tidak jelas", "Nominal tidak sesuai", "Bukti pembayaran tidak valid"';
    }
    
    // Clear previous notes
    notesTextarea.value = '';
    
    modal.show();
}

function markAsPaid(paymentId) {
    const modal = new bootstrap.Modal(document.getElementById('markPaidModal'));
    const form = document.getElementById('markPaidForm');
    
    form.action = `/admin/payments/${paymentId}/mark-paid`;
    modal.show();
}

function printBooking() {
    window.print();
}

function confirmStatusUpdate(event) {
    event.preventDefault();
    
    const selectedStatus = document.getElementById('status').value;
    const currentStatus = '{{ $booking->status }}';
    
    if (selectedStatus === currentStatus) {
        Swal.fire({
            title: 'Info',
            text: 'Status booking masih sama. Tidak ada perubahan.',
            icon: 'info',
            confirmButtonText: 'OK'
        });
        return false;
    }
    
    let message = '';
    switch(selectedStatus) {
        case 'pending':
            message = 'Ubah status booking menjadi \"Menunggu Konfirmasi\"?';
            break;
        case 'confirmed':
            message = 'Ubah status booking menjadi \"Dikonfirmasi\"?';
            break;
        case 'completed':
            message = 'Tandai booking sebagai selesai?';
            @if($booking->payment_type === 'dp')
            message += '\n\nIni akan mengaktifkan deadline pelunasan 3 hari dari sekarang.';
            @endif
            break;
        case 'cancelled':
            message = 'Batalkan booking ini? Tindakan ini tidak dapat dibatalkan.';
            break;
        default:
            message = 'Ubah status booking?';
    }
    
    Swal.fire({
        title: 'Konfirmasi',
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d'
    }).then(result => {
        if (result.isConfirmed) {
            event.target.closest('form').submit();
        }
    });
    
    return false;
}

function confirmDelete(event) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Yakin ingin menghapus booking ini? Tindakan ini tidak dapat dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d'
    }).then(result => {
        if (result.isConfirmed) {
            event.target.closest('form').submit();
        }
    });
    
    return false;
}

// Handle Laravel session flash messages
@if(session('success'))
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    });
@endif

@if(session('error'))
    Swal.fire({
        title: 'Error!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'OK'
    });
@endif
</script>

@endsection
