@extends('admin.layouts.app')

@section('title', 'Jadwal Pesanan')
@section('page-title', 'Jadwal Pesanan')
@section('page-subtitle', 'Kelola jadwal pesanan yang telah selesai')

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-calendar-check me-2"></i>
            Lihat Semua Booking
        </a>
        <a href="{{ route('admin.schedule.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-clockwise me-2"></i>
            Reset
        </a>
    </div>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-success">
                        <i class="bi bi-check-circle-fill text-white"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number text-success">{{ number_format($totalCompleted) }}</div>
                        <div class="stats-label">Total Selesai</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-info">
                        <i class="bi bi-calendar-week text-white"></i>
                    </div>
                    <div class="ms-3">
                        @php
                            $weekPercentage = $totalCompleted > 0 ? ($weekCompleted / $totalCompleted * 100) : 0;
                        @endphp
                        <div class="stats-number text-info">{{ number_format($weekCompleted) }}</div>
                        <div class="stats-label">Minggu Ini</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $weekPercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-warning">
                        <i class="bi bi-calendar-month text-white"></i>
                    </div>
                    <div class="ms-3">
                        @php
                            $monthPercentage = $totalCompleted > 0 ? ($monthCompleted / $totalCompleted * 100) : 0;
                        @endphp
                        <div class="stats-number text-warning">{{ number_format($monthCompleted) }}</div>
                        <div class="stats-label">Bulan Ini</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $monthPercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-purple">
                        <i class="bi bi-credit-card text-white"></i>
                    </div>
                    <div class="ms-3">
                        @php
                            $dpPercentage = $totalCompleted > 0 ? ($dpBookings / $totalCompleted * 100) : 0;
                        @endphp
                        <div class="stats-number text-purple">{{ number_format($dpBookings) }}</div>
                        <div class="stats-label">Down Payment</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-purple" role="progressbar" style="width: {{ $dpPercentage }}%"></div>
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
                    <i class="bi bi-calendar2-event me-2"></i>
                    Jadwal Pesanan
                </h5>
            </div>
            <div class="col-auto">
                <form method="GET" action="{{ route('admin.schedule.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" 
                           placeholder="Cari booking, customer..." value="{{ request('search') }}">
                    <input type="date" name="date_from" class="form-control me-2" 
                           placeholder="Dari tanggal" value="{{ request('date_from') }}">
                    <input type="date" name="date_to" class="form-control me-2" 
                           placeholder="Sampai tanggal" value="{{ request('date_to') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request('search') || request('date_from') || request('date_to'))
                        <a href="{{ route('admin.schedule.index') }}" class="btn btn-outline-secondary ms-1">
                            <i class="bi bi-x"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($bookings->count() > 0)
            <!-- Schedule Stats -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <small class="text-muted">Total Pesanan Selesai:</small>
                            <strong class="text-primary">{{ number_format($bookings->total()) }}</strong>
                        </div>
                        <div class="me-4">
                            <small class="text-muted">Halaman:</small>
                            <strong>{{ $bookings->currentPage() }} dari {{ $bookings->lastPage() }}</strong>
                        </div>
                        @if(request('search') || request('date_from') || request('date_to'))
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
                            <th width="20%" class="border-end">Booking Info</th>
                            <th width="18%" class="border-end">Nama Pelanggan</th>
                            <th width="15%" class="border-end">Layanan</th>
                            <th width="12%" class="text-center border-end">Tanggal & Waktu</th>
                            <th width="12%" class="text-center border-end">Pembayaran</th>
                            <th width="10%" class="text-center border-end">Status</th>
                            <th width="9%" class="text-center">Aksi</th>
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
                                            Selesai: {{ $booking->photo_session_completed_at ? $booking->photo_session_completed_at->format('d M Y H:i') : '-' }}
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
                                            <small class="text-muted">{{ Str::limit($booking->customer_email, 20) }}</small>
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
                                    <div class="fw-semibold text-success">{{ $booking->formatted_total_price }}</div>
                                    @if($booking->payment_type === 'dp')
                                        <span class="badge bg-info">DP</span>
                                    @else
                                        <span class="badge bg-success">Full Payment</span>
                                    @endif
                                </td>
                                <td class="text-center border-end">
                                    <div class="d-flex flex-column gap-1">
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Selesai
                                        </span>
                                        @if($booking->payments->count() > 0)
                                            @php
                                                $allVerified = $booking->payments->every(function($payment) {
                                                    return $payment->verification_status === 'verified';
                                                });
                                            @endphp
                                            @if($allVerified)
                                                <span class="badge bg-success">Lunas</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-outline-primary btn-sm" 
                                            onclick="showScheduleDetails({{ $booking->id }})" 
                                            title="Lihat Detail Jadwal">
                                        <i class="bi bi-eye me-1"></i>
                                        Detail
                                    </button>
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
                    Menampilkan <strong>{{ number_format($bookings->firstItem()) }}</strong> sampai <strong>{{ number_format($bookings->lastItem()) }}</strong> dari total <strong class="text-primary">{{ number_format($bookings->total()) }}</strong> pesanan selesai
                    @if(request('search') || request('date_from') || request('date_to'))
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
                <h5 class="text-muted mt-3">Tidak ada pesanan selesai ditemukan</h5>
                @if(request('search') || request('date_from') || request('date_to'))
                    <p class="text-muted">Tidak ada pesanan yang sesuai dengan kriteria pencarian Anda.</p>
                    <a href="{{ route('admin.schedule.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Lihat Semua Pesanan
                    </a>
                @else
                    <p class="text-muted">Pesanan yang telah selesai akan ditampilkan di sini.</p>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary">
                        <i class="bi bi-calendar-check me-2"></i>
                        Lihat Semua Booking
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Schedule Details Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Jadwal Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="scheduleModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Custom styling for schedule table */
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
    
    .bg-purple {
        background-color: #6f42c1 !important;
    }
    
    .text-purple {
        color: #6f42c1 !important;
    }
    
    .progress-bar.bg-purple {
        background-color: #6f42c1 !important;
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
        
        .card-header .form-control {
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
// Create URL template with placeholder
const scheduleShowUrlTemplate = "{{ route('admin.schedule.show', ['booking' => ':bookingId']) }}";

function showScheduleDetails(bookingId) {
    const modal = new bootstrap.Modal(document.getElementById('scheduleModal'));
    const modalBody = document.getElementById('scheduleModalBody');
    
    // Show loading spinner
    modalBody.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    
    modal.show();
    
    // Generate URL by replacing placeholder with actual booking ID
    const url = scheduleShowUrlTemplate.replace(':bookingId', bookingId);
    
    // Fetch booking details via AJAX
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(html => {
        modalBody.innerHTML = html;
    })
    .catch(error => {
        console.error('Error loading schedule details:', error);
        modalBody.innerHTML = `
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Gagal memuat detail jadwal. Silakan coba lagi.
            </div>
        `;
    });
}
</script>
@endpush
