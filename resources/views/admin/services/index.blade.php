@extends('admin.layouts.app')

@section('title', 'Layanan')
@section('page-title', 'Kelola Layanan')

@section('page-actions')
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>
        Tambah Layanan
    </a>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-primary">
                        <i class="bi bi-camera-reels-fill text-white"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number text-primary">{{ number_format($totalServices) }}</div>
                        <div class="stats-label">Total Layanan</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-success">
                        <i class="bi bi-check-circle-fill text-white"></i>
                    </div>
                    <div class="ms-3">
                        @php
                            $activePercentage = $totalServices > 0 ? ($activeServices / $totalServices * 100) : 0;
                        @endphp
                        <div class="stats-number text-success">{{ number_format($activeServices) }}</div>
                        <div class="stats-label">Layanan Aktif</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $activePercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-warning">
                        <i class="bi bi-folder-fill text-white"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number text-warning">{{ number_format($totalCategories) }}</div>
                        <div class="stats-label">Total Kategori</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-info">
                        <i class="bi bi-calendar-event-fill text-white"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number text-info">{{ number_format($totalBookings) }}</div>
                        <div class="stats-label">Total Booking</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%"></div>
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
                    <i class="bi bi-camera-reels me-2"></i>
                    Semua Layanan
                </h5>
            </div>
            <div class="col-auto">
                <form method="GET" action="{{ route('admin.services.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" 
                           placeholder="Cari layanan..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary ms-1">
                            <i class="bi bi-x"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($services->count() > 0)
            <!-- Services Stats -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <small class="text-muted">Total Layanan:</small>
                            <strong class="text-primary">{{ number_format($services->total()) }}</strong>
                        </div>
                        <div class="me-4">
                            <small class="text-muted">Halaman:</small>
                            <strong>{{ $services->currentPage() }} dari {{ $services->lastPage() }}</strong>
                        </div>
                        @if(request('search'))
                            <div class="me-4">
                                <small class="text-muted">Hasil Pencarian:</small>
                                <strong class="text-success">{{ $services->count() }} ditemukan</strong>
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
                            <th width="6%" class="text-center border-end">ID</th>
                            <th width="20%" class="border-end">Layanan</th>
                            <th width="10%" class="text-center border-end">Gambar</th>
                            <th width="12%" class="text-center border-end">Kategori</th>
                            <th width="12%" class="text-center border-end">Harga</th>
                            <th width="8%" class="text-center border-end">Durasi</th>
                            <th width="10%" class="text-center border-end">Pemesanan</th>
                            <th width="8%" class="text-center border-end">Status</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $index => $service)
                            <tr>
                                <td class="text-center fw-bold text-dark border-end">{{ $services->firstItem() + $index }}</td>
                                <td class="text-center border-end">
                                    @php
                                        $categoryPrefix = strtoupper(substr($service->category->name, 0, 3));
                                        $formattedId = $categoryPrefix . str_pad($service->id, 2, '0', STR_PAD_LEFT);
                                    @endphp
                                    <span class="badge bg-secondary">{{ $formattedId }}</span>
                                </td>
                                <td class="border-end">
                                    <div>
                                        <div class="fw-semibold">{{ $service->name }}</div>
                                        <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                    </div>
                                </td>
                                <td class="text-center border-end">
                                    @if($service->image && file_exists(public_path('storage/'.$service->image)))
                                        <img src="{{ asset('storage/'.$service->image) }}" 
                                             alt="{{ $service->name }}" 
                                             class="rounded border" 
                                             style="width: 50px; height: 50px; object-fit: cover;"
                                             loading="lazy">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center rounded border bg-light" 
                                             style="width: 50px; height: 50px; min-width: 50px;">
                                            <i class="bi bi-image text-muted" style="font-size: 1.2rem;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center border-end">
                                    <span class="badge bg-info">{{ $service->category->name }}</span>
                                </td>
                                <td class="text-center border-end">
                                    <span class="fw-semibold text-success">
                                        Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-center border-end">
                                    <span class="text-muted">{{ $service->duration_minutes }} Menit</span>
                                </td>
                                <td class="text-center border-end">
                                    <span class="fw-semibold fs-6">{{ $service->bookings_count }}</span>
                                    @if($service->bookings_count > 0)
                                        <div><small class="text-muted">pemesanan</small></div>
                                    @else
                                        <div><small class="text-muted">tidak ada</small></div>
                                    @endif
                                </td>
                                <td class="text-center border-end">
                                    @if($service->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.services.show', $service) }}" 
                                           class="btn btn-outline-primary" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.services.edit', $service) }}" 
                                           class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger"
                                                onclick="deleteService('{{ $service->id }}', '{{ $service->name }}')" 
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
                    Menampilkan <strong>{{ number_format($services->firstItem()) }}</strong> sampai <strong>{{ number_format($services->lastItem()) }}</strong> dari total <strong class="text-primary">{{ number_format($services->total()) }}</strong> layanan
                    @if(request('search'))
                        <div class="mt-1">
                            <span class="badge bg-primary">{{ $services->total() }} hasil untuk "{{ request('search') }}"</span>
                        </div>
                    @endif
                </div>
                <div class="d-flex align-items-center">
                    <small class="text-muted me-3">Halaman {{ $services->currentPage() }}/{{ $services->lastPage() }}</small>
                    <div class="pagination-wrapper">
                        {{ $services->withQueryString()->links('custom.pagination') }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-camera-reels text-muted" style="font-size: 4rem;"></i>
                <h5 class="text-muted mt-3">Tidak ada layanan ditemukan</h5>
                @if(request('search'))
                    <p class="text-muted">Tidak ada layanan yang sesuai dengan kriteria pencarian Anda.</p>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Lihat Semua Layanan
                    </a>
                @else
                    <p class="text-muted">Belum ada layanan yang dibuat.</p>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>
                        Tambah Layanan Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
function deleteService(serviceId, serviceName) {
    Swal.fire({
        title: 'Hapus Layanan',
        text: `Apakah Anda yakin ingin menghapus layanan "${serviceName}"? Tindakan ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/services/${serviceId}`;
            
            const csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '_token';
            csrfField.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfField);
            form.appendChild(methodField);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

@endsection

@push('styles')
<style>
    /* Custom styling for services table */
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
    }
    
    @media (max-width: 576px) {
        .card-header .row {
            flex-direction: column;
        }
        
        .card-header .col-auto {
            margin-top: 1rem;
        }
        
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
