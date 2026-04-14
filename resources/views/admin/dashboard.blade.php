@extends('admin.layouts.app')

@section('title', 'Dashboard Admin - Yujin Foto Studio')
@section('page-title', 'Dashboard Admin')

@section('content')
<!-- Welcome Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-gradient-primary text-white">
            <div class="card-body py-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="mb-1">Selamat Datang di Dashboard Admin</h3>
                        <p class="mb-0 text-white-50">Kelola studio foto Anda dengan mudah dan efisien</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="d-flex justify-content-md-end align-items-center">
                            <i class="bi bi-camera-reels" style="font-size: 3rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow-lg border-0 h-100 card-hover" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; transition: transform 0.3s ease;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-75 small mb-2 text-uppercase fw-bold">Total Pengguna</div>
                        <div class="h2 mb-0 fw-bold text-white">{{ number_format($totalUsers, 0, ',', '.') }}</div>
                        <div class="text-white-50 small mt-1">Terdaftar</div>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-people text-white" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow-lg border-0 h-100 card-hover" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 15px; transition: transform 0.3s ease;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-75 small mb-2 text-uppercase fw-bold">Total Pemesanan</div>
                        <div class="h2 mb-0 fw-bold text-white">{{ number_format($totalBookings, 0, ',', '.') }}</div>
                        <div class="text-white-50 small mt-1">Booking</div>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-calendar-check text-white" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow-lg border-0 h-100 card-hover" style="background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%); border-radius: 15px; transition: transform 0.3s ease;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-75 small mb-2 text-uppercase fw-bold">Total Layanan</div>
                        <div class="h2 mb-0 fw-bold text-white">{{ number_format($totalServices, 0, ',', '.') }}</div>
                        <div class="text-white-50 small mt-1">Services</div>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-camera-reels text-white" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow-lg border-0 h-100 card-hover" style="background: linear-gradient(135deg, #17a2b8 0%, #007bff 100%); border-radius: 15px; transition: transform 0.3s ease;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-white-75 small mb-2 text-uppercase fw-bold">Total Pendapatan</div>
                        <div class="h2 mb-0 fw-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        <div class="text-white-50 small mt-1">Revenue</div>
                    </div>
                    <div class="text-white-50">
                        <i class="bi bi-currency-exchange text-white" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Booking Status Chart -->
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow-lg border-0 mb-4" style="border-radius: 15px;">
            <div class="card-header border-0 py-4 bg-gradient-primary text-white" style="border-radius: 15px 15px 0 0;">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold">Ringkasan Status Pemesanan</h6>
                    <i class="bi bi-pie-chart opacity-50"></i>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="chart-container" style="height: 300px;">
                    <canvas id="bookingStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Chart -->
    <div class="col-xl-6 col-lg-5">
        <div class="card shadow-lg border-0 mb-4" style="border-radius: 15px;">
            <div class="card-header border-0 py-4 bg-gradient-success text-white" style="border-radius: 15px 15px 0 0;">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold">Pendapatan Bulanan (6 Bulan Terakhir)</h6>
                    <i class="bi bi-graph-up-arrow opacity-50"></i>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="chart-container" style="height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="card shadow-lg border-0 mb-4" style="border-radius: 15px;">
    <div class="card-header border-0 py-4 bg-gradient-secondary text-white" style="border-radius: 15px 15px 0 0;">
        <div class="d-flex align-items-center">
            <i class="bi bi-clock-history me-2"></i>
            <h6 class="m-0 fw-bold">Aktivitas Terbaru</h6>
        </div>
    </div>
    <div class="card-body p-4">
        <div class="timeline">
            @if($recentBookings->count() > 0)
                @foreach($recentBookings->take(8) as $booking)
                    <div class="timeline-item">
                        <div class="timeline-marker">
                            @php
                                $statusClasses = [
                                    'pending' => 'warning',
                                    'confirmed' => 'info', 
                                    'in_progress' => 'primary',
                                    'completed' => 'success',
                                    'cancelled' => 'danger'
                                ];
                                $statusIcons = [
                                    'pending' => 'hourglass-split',
                                    'confirmed' => 'check-circle',
                                    'in_progress' => 'gear',
                                    'completed' => 'check-circle-fill',
                                    'cancelled' => 'x-circle'
                                ];
                                $statusClass = $statusClasses[$booking->status] ?? 'secondary';
                                $statusIcon = $statusIcons[$booking->status] ?? 'circle';
                            @endphp
                            <i class="bi bi-{{ $statusIcon }} text-{{ $statusClass }}"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-header">
                                <h6 class="mb-1">
                                    @if($booking->status === 'pending')
                                        <span class="badge bg-warning me-2">Pesanan Baru</span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="badge bg-info me-2">Dikonfirmasi</span>
                                    @elseif($booking->status === 'completed')
                                        <span class="badge bg-success me-2">Selesai</span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="badge bg-danger me-2">Dibatalkan</span>
                                    @endif
                                    {{ $booking->booking_number }}
                                </h6>
                                <small class="text-muted">{{ $booking->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="timeline-body">
                                <p class="mb-1">
                                    @if($booking->status === 'pending')
                                        Pesanan baru dibuat oleh <strong>{{ $booking->customer_name }}</strong> untuk layanan <strong>{{ $booking->service->name }}</strong>.
                                    @elseif($booking->status === 'confirmed')
                                        Pesanan <strong>{{ $booking->booking_number }}</strong> telah dikonfirmasi untuk tanggal {{ $booking->booking_date->format('d M Y') }}.
                                    @elseif($booking->status === 'completed')
                                        Pesanan <strong>{{ $booking->booking_number }}</strong> telah selesai dilaksanakan.
                                    @elseif($booking->status === 'cancelled')
                                        Pesanan <strong>{{ $booking->booking_number }}</strong> telah dibatalkan.
                                    @endif
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>{{ $booking->booking_date->format('d M Y') }}
                                        <i class="bi bi-clock ms-2 me-1"></i>{{ $booking->booking_time }}
                                    </small>
                                    <span class="fw-semibold text-primary">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-4">
                    <i class="bi bi-clock-history text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">Belum ada aktivitas terbaru.</p>
                </div>
            @endif
        </div>
        @if($recentBookings->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-eye me-1"></i> Lihat Semua Pesanan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #007bff 100%);
    }
    
    .bg-gradient-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }
    
    .text-white-75 {
        color: rgba(255, 255, 255, 0.75);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    
    .card {
        transition: all 0.3s ease;
    }
    
    /* Timeline Styles */
    .timeline {
        position: relative;
        padding: 0;
        list-style: none;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        padding-left: 3rem;
    }
    
    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 0.75rem;
        top: 2rem;
        width: 2px;
        height: calc(100% + 1rem);
        background: linear-gradient(to bottom, #e9ecef, #dee2e6);
    }
    
    .timeline-marker {
        position: absolute;
        left: 0;
        top: 0.5rem;
        width: 2rem;
        height: 2rem;
        background: #fff;
        border: 3px solid #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .timeline-content {
        background: #f8f9fa;
        border-radius: 0.75rem;
        padding: 1.25rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border-left: 4px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    .timeline-content:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .timeline-header {
        margin-bottom: 0.75rem;
    }
    
    .timeline-body {
        margin-bottom: 0;
    }
    
    .timeline-item .timeline-marker .text-warning {
        color: #ffc107 !important;
    }
    
    .timeline-item .timeline-marker .text-info {
        color: #0dcaf0 !important;
    }
    
    .timeline-item .timeline-marker .text-success {
        color: #198754 !important;
    }
    
    .timeline-item .timeline-marker .text-danger {
        color: #dc3545 !important;
    }
    
    .timeline-item .timeline-marker .text-primary {
        color: #0d6efd !important;
    }
</style>
@endpush

@push('scripts')
<script>
// Booking Status Chart
const bookingStatusData = @json($bookingStats);

// Map status to Indonesian labels
const statusTranslations = {
    'pending': 'Menunggu',
    'confirmed': 'Dikonfirmasi', 
    'in_progress': 'Sedang Berjalan',
    'completed': 'Selesai',
    'cancelled': 'Dibatalkan'
};

// Map status to consistent colors (same as in bookings table)
const statusColors = {
    'pending': '#ffc107',     // warning - yellow
    'confirmed': '#0dcaf0',   // info - cyan
    'in_progress': '#0d6efd', // primary - blue
    'completed': '#198754',   // success - green
    'cancelled': '#dc3545'    // danger - red
};

const statusLabels = bookingStatusData.map(item => statusTranslations[item.status] || item.status);
const statusCounts = bookingStatusData.map(item => item.count);
const backgroundColors = bookingStatusData.map(item => statusColors[item.status] || '#6c757d');

const statusCtx = document.getElementById('bookingStatusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusCounts,
            backgroundColor: backgroundColors,
            borderWidth: 3,
            borderColor: '#fff',
            hoverBorderWidth: 4,
            hoverBorderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true,
                    font: {
                        size: 12,
                        family: 'Inter, sans-serif'
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                        return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                    }
                },
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: '#ddd',
                borderWidth: 1
            }
        },
        cutout: '60%',
        animation: {
            animateRotate: true,
            duration: 1000
        }
    }
});

// Monthly Revenue Chart
const revenueData = @json($monthlyRevenue);
const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
const revenueLabels = revenueData.map(item => months[item.month - 1] + ' ' + item.year);
const revenueAmounts = revenueData.map(item => item.revenue);

const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: revenueLabels.reverse(),
        datasets: [{
            label: 'Revenue (Rp)',
            data: revenueAmounts.reverse(),
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>
@endpush
