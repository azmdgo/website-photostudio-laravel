@extends('staff.layouts.app')

@section('title', 'Dashboard Staff - Yujin Foto Studio')
@section('page-title', 'Dashboard Staff')

@section('content')
<!-- Welcome Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-gradient-primary text-white">
            <div class="card-body py-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3 class="mb-1">Selamat Datang di Panel Staff</h3>
                        <p class="mb-0 text-white-50">Kelola jadwal dan booking studio foto dengan efisien</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="d-flex justify-content-md-end align-items-center">
                            <i class="bi bi-calendar-event" style="font-size: 3rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <!-- Today's Bookings -->
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow-lg border-0 mb-4" style="border-radius: 15px;">
            <div class="card-header border-0 py-4 bg-gradient-primary text-white" style="border-radius: 15px 15px 0 0;">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold">Jadwal Hari Ini ({{ date('d M Y') }})</h6>
                    <i class="bi bi-calendar-day opacity-50"></i>
                </div>
            </div>
            <div class="card-body p-4">
                @if($todayBookings->count() > 0)
                    <div class="timeline">
                        @foreach($todayBookings as $booking)
                            <div class="timeline-item mb-3">
                                <div class="timeline-marker">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'warning',
                                            'confirmed' => 'info', 
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $statusIcons = [
                                            'pending' => 'hourglass-split',
                                            'confirmed' => 'check-circle',
                                            'completed' => 'check-circle-fill',
                                            'cancelled' => 'x-circle'
                                        ];
                                        $statusClass = $statusClasses[$booking->status] ?? 'secondary';
                                        $statusIcon = $statusIcons[$booking->status] ?? 'circle';
                                    @endphp
                                    <i class="bi bi-{{ $statusIcon }} text-{{ $statusClass }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $booking->booking_time }} - {{ $booking->service->name }}</h6>
                                            <p class="mb-1 text-muted">{{ $booking->customer_name }}</p>
                                            <small class="text-muted">{{ $booking->service->category->name }}</small>
                                        </div>
                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                        <h6 class="text-muted mt-3">Tidak ada jadwal hari ini</h6>
                        <p class="text-muted">Hari ini cukup santai!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Booking Status Chart -->
    <div class="col-xl-6 col-lg-5">
        <div class="card shadow-lg border-0 mb-4" style="border-radius: 15px;">
            <div class="card-header border-0 py-4 bg-gradient-secondary text-white" style="border-radius: 15px 15px 0 0;">
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
</div>

<!-- Completed Bookings with Interactive Filter -->
<div class="card shadow-lg border-0 mb-4" style="border-radius: 15px;">
    <div class="card-header border-0 py-4 bg-gradient-success text-white" style="border-radius: 15px 15px 0 0;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <h6 class="m-0 fw-bold" id="scheduleTitle">Jadwal Selesai Bulan Ini</h6>
            </div>
            <div class="d-flex align-items-center gap-2">
                <!-- Filter Buttons -->
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-light btn-sm filter-btn" data-filter="today">
                        <i class="bi bi-calendar-day me-1"></i>
                        Hari Ini
                    </button>
                    <button type="button" class="btn btn-light btn-sm filter-btn" data-filter="week">
                        <i class="bi bi-calendar-week me-1"></i>
                        Minggu Ini
                    </button>
                    <button type="button" class="btn btn-light btn-sm filter-btn active" data-filter="month">
                        <i class="bi bi-calendar-month me-1"></i>
                        Bulan Ini
                    </button>
                </div>
                <a href="{{ route('staff.schedule') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-eye me-1"></i>
                    Lihat Semua
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-4">
        <!-- Loading Indicator -->
        <div id="loadingIndicator" class="text-center py-4" style="display: none;">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mt-2">Memuat data...</p>
        </div>
        
        <!-- Table Content -->
        <div id="tableContent">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bookingTableBody">
                        @foreach($monthBookings->where('status', 'completed') as $booking)
                            <tr data-date="{{ $booking->booking_date->format('Y-m-d') }}">
                                <td>
                                    <span class="fw-semibold">{{ $booking->booking_date->format('d M') }}</span>
                                    <br><small class="text-muted">{{ $booking->booking_date->format('l') }}</small>
                                </td>
                                <td>{{ $booking->booking_time }}</td>
                                <td>{{ $booking->customer_name }}</td>
                                <td>
                                    <div>{{ $booking->service->name }}</div>
                                    <small class="text-muted">{{ $booking->service->category->name }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Selesai
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('staff.schedule.show', $booking) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Empty State -->
            <div class="text-center py-4" id="emptyState" style="display: none;">
                <i class="bi bi-calendar-check text-muted" style="font-size: 3rem;"></i>
                <h6 class="text-muted mt-3" id="emptyTitle">Belum ada booking yang selesai bulan ini</h6>
                <p class="text-muted" id="emptyDescription">Booking yang sudah selesai pembayaran akan tampil di sini</p>
            </div>
        </div>
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
        background: linear-gradient(135deg, #20b2aa 0%, #48cae4 100%);
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
        background-color: rgba(32, 178, 170, 0.05);
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
    
    /* Filter Button Styles */
    .filter-btn {
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }
    
    .filter-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
    }
    
    .filter-btn.active {
        background: white;
        border-color: white;
        color: #198754;
        font-weight: 600;
    }
    
    .filter-btn.active:hover {
        background: white;
        color: #198754;
    }
    
    /* Loading animation */
    .spinner-border {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
    'completed': 'Selesai',
    'cancelled': 'Dibatalkan'
};

// Map status to consistent colors (same as in bookings table)
const statusColors = {
    'pending': '#ffc107',     // warning - yellow
    'confirmed': '#0dcaf0',   // info - cyan
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

// Interactive Filter Functionality
const filterButtons = document.querySelectorAll('.filter-btn');
const scheduleTitle = document.getElementById('scheduleTitle');
const loadingIndicator = document.getElementById('loadingIndicator');
const tableContent = document.getElementById('tableContent');
const emptyTitle = document.getElementById('emptyTitle');
const emptyDescription = document.getElementById('emptyDescription');

// Get all booking data with dates
const weekBookings = @json($weekBookings->where('status', 'completed')->values());
const todayBookings = @json($todayBookings->where('status', 'completed')->values());
const monthBookings = @json($monthBookings->where('status', 'completed')->values());

// Combine all data and remove duplicates
const allRawBookings = [...weekBookings, ...todayBookings, ...monthBookings];
const allBookingData = allRawBookings.filter((booking, index, self) => 
    index === self.findIndex(b => b.id === booking.id)
);

// Helper function to get date ranges
function getDateRange(filter) {
    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    
    switch(filter) {
        case 'today':
            return {
                start: today,
                end: new Date(today.getTime() + 24 * 60 * 60 * 1000 - 1)
            };
        case 'week':
            const startOfWeek = new Date(today);
            startOfWeek.setDate(today.getDate() - today.getDay());
            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(startOfWeek.getDate() + 6);
            endOfWeek.setHours(23, 59, 59, 999);
            return {
                start: startOfWeek,
                end: endOfWeek
            };
        case 'month':
            const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
            const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            endOfMonth.setHours(23, 59, 59, 999);
            return {
                start: startOfMonth,
                end: endOfMonth
            };
        default:
            return null;
    }
}

// Filter bookings based on date range
function filterBookings(filter) {
    const dateRange = getDateRange(filter);
    if (!dateRange) return allBookingData;
    
    console.log(`Filtering for ${filter}:`, dateRange);
    
    const filtered = allBookingData.filter(booking => {
        const bookingDate = new Date(booking.booking_date);
        const isInRange = bookingDate >= dateRange.start && bookingDate <= dateRange.end;
        return isInRange;
    });
    
    console.log('Filtered results:', filtered.length, 'bookings');
    return filtered;
}

// Update table content
function updateTableContent(filteredBookings, filter) {
    const tableBody = document.getElementById('bookingTableBody');
    const emptyState = document.getElementById('emptyState');
    const tableResponsive = document.querySelector('.table-responsive');
    
    console.log('Updating table with filter:', filter, 'bookings:', filteredBookings.length);
    
    // Update title
    const titles = {
        'today': 'Jadwal Selesai Hari Ini',
        'week': 'Jadwal Selesai Minggu Ini',
        'month': 'Jadwal Selesai Bulan Ini'
    };
    if (scheduleTitle) {
        scheduleTitle.textContent = titles[filter] || 'Jadwal Selesai';
    }
    
    // Update empty state messages
    const emptyMessages = {
        'today': {
            title: 'Belum ada booking yang selesai hari ini',
            description: 'Booking yang sudah selesai pembayaran hari ini akan tampil di sini'
        },
        'week': {
            title: 'Belum ada booking yang selesai minggu ini',
            description: 'Booking yang sudah selesai pembayaran minggu ini akan tampil di sini'
        },
        'month': {
            title: 'Belum ada booking yang selesai bulan ini',
            description: 'Booking yang sudah selesai pembayaran bulan ini akan tampil di sini'
        }
    };
    
    if (filteredBookings.length === 0) {
        // Show empty state, hide table
        if (tableResponsive) tableResponsive.style.display = 'none';
        if (emptyState) {
            emptyState.style.display = 'block';
            const emptyTitle = emptyState.querySelector('#emptyTitle');
            const emptyDescription = emptyState.querySelector('#emptyDescription');
            if (emptyTitle) emptyTitle.textContent = emptyMessages[filter].title;
            if (emptyDescription) emptyDescription.textContent = emptyMessages[filter].description;
        }
    } else {
        // Show table, hide empty state
        if (tableResponsive) tableResponsive.style.display = 'block';
        if (emptyState) emptyState.style.display = 'none';
        
        if (tableBody) {
            // Clear existing rows
            tableBody.innerHTML = '';
            
            // Generate new rows
            filteredBookings.forEach(booking => {
                const date = new Date(booking.booking_date);
                const formattedDate = date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
                const dayName = date.toLocaleDateString('id-ID', { weekday: 'long' });
                
                const row = document.createElement('tr');
                row.setAttribute('data-date', booking.booking_date);
                row.innerHTML = `
                    <td>
                        <span class="fw-semibold">${formattedDate}</span>
                        <br><small class="text-muted">${dayName}</small>
                    </td>
                    <td>${booking.booking_time}</td>
                    <td>${booking.customer_name}</td>
                    <td>
                        <div>${booking.service.name}</div>
                        <small class="text-muted">${booking.service.category.name}</small>
                    </td>
                    <td>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            Selesai
                        </span>
                    </td>
                    <td>
                        <a href="/staff/schedule/${booking.id}" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }
    }
}

// Handle filter button clicks
filterButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const filter = this.dataset.filter;
        
        console.log('Filter button clicked:', filter);
        console.log('Button element:', this);
        
        // Show loading
        if (loadingIndicator) {
            loadingIndicator.style.display = 'block';
        }
        if (tableContent) {
            tableContent.style.display = 'none';
        }
        
        // Update active button
        filterButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
        
        // Process filter immediately
        try {
            const filteredBookings = filterBookings(filter);
            console.log('About to update table with', filteredBookings.length, 'bookings');
            updateTableContent(filteredBookings, filter);
            
            // Hide loading
            if (loadingIndicator) {
                loadingIndicator.style.display = 'none';
            }
            if (tableContent) {
                tableContent.style.display = 'block';
            }
        } catch (error) {
            console.error('Error filtering bookings:', error);
            // Hide loading even on error
            if (loadingIndicator) {
                loadingIndicator.style.display = 'none';
            }
            if (tableContent) {
                tableContent.style.display = 'block';
            }
        }
    });
});

// Initialize with default filter (week) on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, initializing filter...');
    
    // Ensure initial state is correct
    loadingIndicator.style.display = 'none';
    tableContent.style.display = 'block';
    
    // Log initial data for debugging
    console.log('Initial data available:', {
        weekBookings: weekBookings.length,
        todayBookings: todayBookings.length,
        monthBookings: monthBookings.length,
        allBookingData: allBookingData.length
    });
});
</script>
@endpush
