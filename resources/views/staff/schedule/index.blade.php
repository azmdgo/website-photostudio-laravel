@extends('staff.layouts.app')

@section('title', 'Jadwal Booking')
@section('page-title', 'Jadwal Booking')
@section('page-subtitle', 'Kelola jadwal booking harian')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">
                    <i class="bi bi-calendar2-event me-2"></i>
                    Jadwal Booking
                </h5>
            </div>
            <div class="col-auto">
                <form method="GET" action="{{ route('staff.schedule') }}" class="d-flex">
                    <input type="date" name="date" class="form-control me-2" 
                           placeholder="Pilih tanggal" value="{{ request('date') }}">
                    <select name="location" class="form-select me-2">
                        <option value="">Semua Lokasi</option>
                        <option value="indoor" {{ request('location') == 'indoor' ? 'selected' : '' }}>Indoor</option>
                        <option value="outdoor" {{ request('location') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                    </select>
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request('date') || request('location'))
                        <a href="{{ route('staff.schedule') }}" class="btn btn-outline-secondary ms-1">
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
                            <small class="text-muted">Total Booking:</small>
                            <strong class="text-primary">{{ number_format($bookings->total()) }}</strong>
                        </div>
                        <div class="me-4">
                            <small class="text-muted">Halaman:</small>
                            <strong>{{ $bookings->currentPage() }} dari {{ $bookings->lastPage() }}</strong>
                        </div>
                        @if(request('date') || request('location'))
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
                            <th width="18%" class="border-end">Customer</th>
                            <th width="15%" class="border-end">Layanan</th>
                            <th width="8%" class="text-center border-end">Lokasi</th>
                            <th width="10%" class="text-center border-end">Tanggal & Waktu</th>
                            <th width="10%" class="text-center border-end">Harga</th>
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
                                    @php
                                        $categoryName = strtolower($booking->service->category->name);
                                        $isIndoor = str_contains($categoryName, 'indoor');
                                        $isOutdoor = str_contains($categoryName, 'outdoor');
                                    @endphp
                                    @if($isIndoor)
                                        <span class="badge bg-info">
                                            <i class="bi bi-house me-1"></i>
                                            Indoor
                                        </span>
                                    @elseif($isOutdoor)
                                        <span class="badge bg-success">
                                            <i class="bi bi-tree me-1"></i>
                                            Outdoor
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center border-end">
                                    <div class="fw-semibold">{{ $booking->booking_date->format('d M Y') }}</div>
                                    <small class="text-muted">{{ date('H:i', strtotime($booking->booking_time)) }}</small>
                                </td>
                                <td class="text-center border-end">
                                    <div class="fw-semibold text-success">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    @if($booking->payment_type === 'dp')
                                        <span class="badge bg-info">DP</span>
                                    @else
                                        <span class="badge bg-success">Full Payment</span>
                                    @endif
                                </td>
                                <td class="text-center border-end">
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
                                    <span class="badge bg-{{ $statusClass }}">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('staff.schedule.show', $booking) }}" 
                                           class="btn btn-outline-primary" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(in_array($booking->status, ['pending', 'confirmed', 'in_progress']))
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success dropdown-toggle" type="button" 
                                                        data-bs-toggle="dropdown" title="Update Status">
                                                    <i class="bi bi-gear"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if($booking->status === 'pending')
                                                        <li>
                                                            <button class="dropdown-item" onclick="updateStatus({{ $booking->id }}, 'confirmed')">
                                                                <i class="bi bi-check-circle text-info me-2"></i>
                                                                Konfirmasi
                                                            </button>
                                                        </li>
                                                    @endif
                                                    @if(in_array($booking->status, ['confirmed']))
                                                        <li>
                                                            <button class="dropdown-item" onclick="updateStatus({{ $booking->id }}, 'in_progress')">
                                                                <i class="bi bi-play-circle text-primary me-2"></i>
                                                                Mulai Sesi
                                                            </button>
                                                        </li>
                                                    @endif
                                                    @if($booking->status === 'in_progress')
                                                        <li>
                                                            <button class="dropdown-item" onclick="updateStatus({{ $booking->id }}, 'completed')">
                                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                                Selesai
                                                            </button>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
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
                    Menampilkan <strong>{{ number_format($bookings->firstItem()) }}</strong> sampai <strong>{{ number_format($bookings->lastItem()) }}</strong> dari total <strong class="text-primary">{{ number_format($bookings->total()) }}</strong> booking
                    @if(request('date') || request('location'))
                        <div class="mt-1">
                            <span class="badge bg-primary">{{ $bookings->total() }} hasil filter</span>
                        </div>
                    @endif
                </div>
                <div class="d-flex align-items-center">
                    <small class="text-muted me-3">Halaman {{ $bookings->currentPage() }}/{{ $bookings->lastPage() }}</small>
                    <div class="pagination-wrapper">
                        {{ $bookings->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x text-muted" style="font-size: 4rem;"></i>
                <h5 class="text-muted mt-3">Tidak ada booking ditemukan</h5>
                @if(request('date') || request('status'))
                    <p class="text-muted">Tidak ada booking yang sesuai dengan filter Anda.</p>
                    <a href="{{ route('staff.schedule') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Lihat Semua Booking
                    </a>
                @else
                    <p class="text-muted">Belum ada booking yang terjadwal.</p>
                @endif
            </div>
        @endif
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
        background-color: rgba(32, 178, 170, 0.08);
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
    
    
    /* Avatar */
    .avatar-sm {
        flex-shrink: 0;
    }
    
    /* Dropdown styling */
    .dropdown-menu {
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
        background-color: rgba(32, 178, 170, 0.1);
        color: #20b2aa;
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
</style>
@endpush

@push('scripts')
<script>
function updateStatus(bookingId, status) {
    const statusLabels = {
        'confirmed': 'konfirmasi',
        'in_progress': 'mulai sesi',
        'completed': 'selesaikan'
    };
    
    const statusLabel = statusLabels[status] || status;
    
    showConfirmDialog(
        'Update Status Booking',
        `Apakah Anda yakin ingin ${statusLabel} booking ini?`
    ).then((result) => {
        if (result.isConfirmed) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/staff/schedule/${bookingId}/status`;
            
            const csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '_token';
            csrfField.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PATCH';
            
            const statusField = document.createElement('input');
            statusField.type = 'hidden';
            statusField.name = 'status';
            statusField.value = status;
            
            form.appendChild(csrfField);
            form.appendChild(methodField);
            form.appendChild(statusField);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endpush
