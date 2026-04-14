@extends('admin.layouts.app')

@section('title', 'Pemesanan')
@section('page-title', 'Kelola Pemesanan')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.schedule.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-calendar2-event me-2"></i>
            Jadwal Selesai
        </a>
        <button type="button" class="btn btn-outline-secondary" onclick="location.reload()">
            <i class="bi bi-arrow-repeat me-2"></i>
            Refresh
        </button>
    </div>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-primary">
                        <i class="bi bi-calendar-check-fill text-white"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number text-primary">{{ number_format($totalBookings) }}</div>
                        <div class="stats-label">Total Pemesanan</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-success">
                        <i class="bi bi-currency-dollar text-white"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number text-success">{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        <div class="stats-label">Total Pendapatan</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-warning">
                        <i class="bi bi-hourglass-split text-white"></i>
                    </div>
                    <div class="ms-3">
                        @php
                            $pendingPercentage = $totalBookings > 0 ? ($pendingBookings / $totalBookings * 100) : 0;
                        @endphp
                        <div class="stats-number text-warning">{{ number_format($pendingBookings) }}</div>
                        <div class="stats-label">Menunggu</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $pendingPercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-info">
                        <i class="bi bi-check-circle-fill text-white"></i>
                    </div>
                    <div class="ms-3">
                        @php
                            $completedPercentage = $totalBookings > 0 ? ($completedBookings / $totalBookings * 100) : 0;
                        @endphp
                        <div class="stats-number text-info">{{ number_format($completedBookings) }}</div>
                        <div class="stats-label">Selesai</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $completedPercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-check me-2"></i>
                    Semua Pemesanan
                </h5>
            </div>
            <div class="col-auto">
                <form method="GET" action="{{ route('admin.bookings.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" 
                           placeholder="Cari booking, customer..." value="{{ request('search') }}">
                    <select name="status" class="form-select me-2">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <input type="date" name="date_from" class="form-control me-2" 
                           placeholder="Dari tanggal" value="{{ request('date_from') }}">
                    <input type="date" name="date_to" class="form-control me-2" 
                           placeholder="Sampai tanggal" value="{{ request('date_to') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request('search') || request('status') || request('date_from') || request('date_to'))
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary ms-1">
                            <i class="bi bi-x"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($bookings->count() > 0)
            <!-- Booking Stats -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <small class="text-muted">Total Pemesanan:</small>
                            <strong class="text-primary">{{ number_format($bookings->total()) }}</strong>
                        </div>
                        <div class="me-4">
                            <small class="text-muted">Halaman:</small>
                            <strong>{{ $bookings->currentPage() }} dari {{ $bookings->lastPage() }}</strong>
                        </div>
                        @if(request('search') || request('status') || request('date_from') || request('date_to'))
                            <div class="me-4">
                                <small class="text-muted">Hasil Filter:</small>
                                <strong class="text-success">{{ $bookings->count() }} ditemukan</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="4%" class="text-center border-end">No</th>
                            <th width="18%" class="border-end">Booking Info</th>
                            <th width="18%" class="border-end">Pelanggan</th>
                            <th width="12%" class="border-end">Layanan</th>
                            <th width="10%" class="text-center border-end">Tanggal</th>
                            <th width="8%" class="text-center border-end">Status</th>
                            <th width="12%" class="text-center border-end">Pembayaran</th>
                            <th width="10%" class="text-center border-end">Total</th>
                            <th width="8%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $index => $booking)
                            <tr>
                                <td class="text-center fw-bold text-dark border-end">{{ $bookings->firstItem() + $index }}</td>
                                <td class="border-end">
                                    <div>
                                        <div class="fw-semibold text-primary">{{ $booking->booking_number }}</div>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            Dibuat: {{ $booking->created_at->format('d M Y H:i') }}
                                        </small>
                                    </div>
                                </td>
                                <td class="border-end">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 35px; height: 35px; font-size: 0.8rem;">
                                                {{ strtoupper(substr($booking->customer_name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $booking->customer_name }}</div>
                                            <small class="text-muted">{{ Str::limit($booking->user->email ?? $booking->customer_email, 20) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="border-end">
                                    <div>
                                        <div class="fw-semibold">{{ $booking->service->name }}</div>
                                        <small class="text-muted">{{ $booking->service->category->name }}</small>
                                    </div>
                                </td>
                                <td class="text-center border-end">
                                    <div class="fw-semibold">{{ $booking->booking_date->format('d M Y') }}</div>
                                    <small class="text-muted">{{ date('H:i', strtotime($booking->booking_time)) }}</small>
                                </td>
                                <td class="text-center border-end">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'confirmed' => 'Dikonfirmasi',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan'
                                        ];
                                        $statusClass = $statusClasses[$booking->status] ?? 'secondary';
                                        $statusLabel = $statusLabels[$booking->status] ?? ucfirst($booking->status);
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="text-center border-end">
                                    <div class="d-flex flex-column gap-1">
                                        @if($booking->payment_type === 'dp')
                                            <span class="badge bg-info">DP</span>
                                        @else
                                            <span class="badge bg-success">Full Payment</span>
                                        @endif
                                        @if($booking->payment)
                                            @php
                                                $paymentStatusClasses = [
                                                    'pending' => 'warning',
                                                    'paid' => 'success',
                                                    'failed' => 'danger',
                                                    'refunded' => 'secondary'
                                                ];
                                                $verificationStatusClasses = [
                                                    'pending' => 'warning',
                                                    'verified' => 'success',
                                                    'rejected' => 'danger'
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $verificationStatusClasses[$booking->payment->verification_status] ?? 'secondary' }}">
                                                {{ $booking->payment->verification_status == 'verified' ? 'Terverifikasi' : ($booking->payment->verification_status == 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Belum Bayar</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center border-end">
                                    <div class="fw-semibold text-success">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" 
                                           class="btn btn-outline-primary" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button class="btn btn-outline-danger"
                                                onclick="deleteBooking('{{ $booking->id }}')" 
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4 pagination-info">
                <div class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Menampilkan <strong>{{ number_format($bookings->firstItem()) }}</strong> sampai <strong>{{ number_format($bookings->lastItem()) }}</strong> dari total <strong class="text-primary">{{ number_format($bookings->total()) }}</strong> pemesanan
                    @if(request('search') || request('status') || request('date_from') || request('date_to'))
                        <div class="mt-1">
                            <span class="badge bg-primary">{{ $bookings->total() }} hasil filter</span>
                        </div>
                    @endif
                </div>
                <div class="d-flex align-items-center">
                    <small class="text-muted me-3">Halaman {{ $bookings->currentPage() }}/{{ $bookings->lastPage() }}</small>
                    <div class="pagination-wrapper">
                        {{ $bookings->withQueryString()->links('custom.pagination') }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                <h5 class="text-muted mt-3">Tidak ada pemesanan ditemukan</h5>
                @if(request('search') || request('status') || request('date_from') || request('date_to'))
                    <p class="text-muted">Tidak ada pemesanan yang sesuai dengan kriteria pencarian Anda.</p>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Lihat Semua Pemesanan
                    </a>
                @else
                    <p class="text-muted">Belum ada pemesanan yang dibuat.</p>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-primary">
                        <i class="bi bi-camera-reels me-2"></i>
                        Kelola Layanan
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Custom styling for bookings table */
    .table {
        background-color: white;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.08);
        transition: background-color 0.2s ease;
    }
    
    .table thead th {
        font-weight: 600;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        padding: 1rem 0.75rem;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .table tbody tr {
        border-bottom: 1px solid #e9ecef;
    }
    
    .table tbody tr:nth-of-type(even) {
        background-color: rgba(248, 249, 250, 0.5);
    }
    
    .table td {
        vertical-align: middle;
        padding: 0.75rem 0.5rem;
        max-width: 0;
    }
    
    .table td:first-child {
        padding-left: 1rem;
    }
    
    .table td:last-child {
        padding-right: 1rem;
    }
    
    .table-light th {
        background-color: #f8f9fa !important;
        color: #495057 !important;
    }
    
    .border-end {
        border-right: 1px solid #dee2e6 !important;
    }
    
    .table td.border-end {
        border-right: 1px solid #e9ecef;
    }
    
    .table th.border-end {
        border-right: 1px solid #dee2e6;
    }
    
    .badge {
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s ease-in-out;
        min-width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-group-sm .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .pagination {
        margin-bottom: 0;
    }
    
    .pagination .page-link {
        color: #0d6efd;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        margin: 0 0.125rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }
    
    .pagination .page-link:hover {
        background-color: #e7f1ff;
        border-color: #0d6efd;
        transform: translateY(-1px);
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #fff;
        border-color: #dee2e6;
    }
    
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .pagination-wrapper .pagination {
        margin: 0;
        gap: 0.25rem;
    }
    
    .pagination .page-item {
        margin: 0 0.125rem;
    }
    
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        border-radius: 0.375rem;
    }
    
    .pagination .page-item .page-link {
        border-radius: 0.375rem;
        font-size: 0.875rem;
        min-width: 2.5rem;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .pagination .page-item .page-link:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .text-primary {
        color: #007bff !important;
    }
    
    .fw-bold {
        font-weight: 700 !important;
    }
    
    .table-responsive {
        border-radius: 0.375rem;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Stats Cards */
    .stats-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .stats-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    
    .stats-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 0;
    }
    
    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .progress-bar {
        border-radius: 10px;
        transition: width 0.6s ease;
    }
    
    /* Avatar */
    .avatar-sm {
        flex-shrink: 0;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .pagination-info {
            flex-direction: column;
            text-align: center;
        }
        
        .pagination-info > div {
            margin-bottom: 0.5rem;
        }
        
        .table th, .table td {
            padding: 0.5rem 0.25rem;
            font-size: 0.875rem;
        }
        
        .btn-group-sm .btn {
            padding: 0.2rem 0.4rem;
            font-size: 0.8rem;
        }
        
        .card-header .row {
            flex-direction: column;
        }
        
        .card-header .col-auto {
            margin-top: 1rem;
        }
        
        .card-header .d-flex {
            flex-direction: column;
        }
        
        .card-header .form-control,
        .card-header .form-select {
            margin-bottom: 0.5rem;
        }
    }
    
    @media (max-width: 576px) {
        .table th, .table td {
            padding: 0.4rem 0.2rem;
            font-size: 0.8rem;
        }
        
        .badge {
            font-size: 0.7rem;
        }
        
        .btn-group-sm .btn {
            padding: 0.15rem 0.3rem;
            font-size: 0.75rem;
            min-width: 28px;
            height: 28px;
        }
        
        .stats-number {
            font-size: 1.5rem;
        }
        
        .stats-icon-wrapper {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
        
        .stats-card {
            margin-bottom: 1rem;
        }
        
        .stats-card .card-body {
            padding: 1rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function deleteBooking(bookingId) {
    Swal.fire({
        title: 'Hapus Pemesanan?',
        text: 'Apakah Anda yakin ingin menghapus pemesanan ini? Tindakan ini tidak dapat dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/bookings/${bookingId}`;
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add method override for DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
