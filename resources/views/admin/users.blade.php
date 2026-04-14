@extends('admin.layouts.app')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('page-actions')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-plus-lg me-2"></i>
        Tambah Pengguna
    </button>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-primary">
                        <i class="bi bi-people-fill text-white"></i>
                    </div>
                    <div class="ms-3">
                        <div class="stats-number text-primary">{{ number_format($totalUsers) }}</div>
                        <div class="stats-label">Total Pengguna</div>
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
                        <i class="bi bi-person-check-fill text-white"></i>
                    </div>
                    <div class="ms-3">
                        @php
                            $customerPercentage = $totalUsers > 0 ? ($totalCustomers / $totalUsers * 100) : 0;
                        @endphp
                        <div class="stats-number text-success">{{ number_format($totalCustomers) }}</div>
                        <div class="stats-label">Pelanggan</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $customerPercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-danger">
                        <i class="bi bi-shield-check text-white"></i>
                    </div>
                    <div class="ms-3">
                        @php
                            $adminPercentage = $totalUsers > 0 ? ($totalAdmins / $totalUsers * 100) : 0;
                        @endphp
                        <div class="stats-number text-danger">{{ number_format($totalAdmins) }}</div>
                        <div class="stats-label">Admin</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $adminPercentage }}%"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="stats-icon-wrapper bg-info">
                        <i class="bi bi-person-badge-fill text-white"></i>
                    </div>
                    <div class="ms-3">
                        @php
                            $staffPercentage = $totalUsers > 0 ? ($totalStudioStaff / $totalUsers * 100) : 0;
                        @endphp
                        <div class="stats-number text-info">{{ number_format($totalStudioStaff) }}</div>
                        <div class="stats-label">Petugas Studio</div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $staffPercentage }}%"></div>
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
                    <i class="bi bi-people me-2"></i>
                    Semua Pengguna
                </h5>
            </div>
            <div class="col-auto">
                <form method="GET" action="{{ route('admin.users') }}" class="d-flex align-items-center" id="searchForm">
                    <!-- Role Filter -->
                    <select name="role" class="form-select me-2" style="width: auto;" onchange="this.form.submit()">
                        <option value="">Semua Role</option>
                        <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Pelanggan</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="studio_staff" {{ request('role') === 'studio_staff' ? 'selected' : '' }}>Petugas Studio</option>
                        <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Pemilik</option>
                    </select>
                    
                    <!-- Search Input -->
                    <div class="position-relative">
                        <input type="text" name="search" class="form-control me-2" 
                               placeholder="Cari pengguna..." value="{{ request('search') }}" id="searchInput">
                    </div>
                    
                    <button type="submit" class="btn btn-outline-primary" id="searchBtn">
                        <i class="bi bi-search" id="searchIcon"></i>
                        <span class="spinner-border spinner-border-sm d-none" id="searchSpinner"></span>
                    </button>
                    
                    @if(request('search') || request('role'))
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary ms-1" title="Hapus Filter">
                            <i class="bi bi-x"></i>
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
            <!-- Users Stats -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <small class="text-muted">Total Pengguna:</small>
                            <strong class="text-primary">{{ number_format($users->total()) }}</strong>
                        </div>
                        <div class="me-4">
                            <small class="text-muted">Halaman:</small>
                            <strong>{{ $users->currentPage() }} dari {{ $users->lastPage() }}</strong>
                        </div>
                        @if(request('search'))
                            <div class="me-4">
                                <small class="text-muted">Hasil Pencarian:</small>
                                <strong class="text-success">{{ $users->count() }} ditemukan</strong>
                            </div>
                        @endif
                        @if(request('role'))
                            <div class="me-4">
                                <small class="text-muted">Filter Role:</small>
                                <strong class="text-info">
                                    @switch(request('role'))
                                        @case('customer')
                                            Pelanggan
                                            @break
                                        @case('admin')
                                            Admin
                                            @break
                                        @case('studio_staff')
                                            Petugas Studio
                                            @break
                                        @case('owner')
                                            Pemilik
                                            @break
                                        @default
                                            {{ request('role') }}
                                    @endswitch
                                </strong>
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
                            <th width="20%" class="border-end">Pengguna</th>
                            <th width="20%" class="border-end">Email</th>
                            <th width="10%" class="text-center border-end">Peran</th>
                            <th width="8%" class="text-center border-end">Pemesanan</th>
                            <th width="15%" class="text-center border-end">Bergabung</th>
                            <th width="8%" class="text-center border-end">Status</th>
                            <th width="9%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td class="text-center fw-bold text-dark border-end">{{ $users->firstItem() + $index }}</td>
                                <td class="text-center border-end">
                                    <span class="badge bg-secondary">{{ $user->getFormattedId() }}</span>
                                </td>
                                <td class="border-end">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                             style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <div class="fw-semibold text-truncate">{{ $user->name }}</div>
                                            @if($user->phone)
                                                <small class="text-muted d-block">{{ $user->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="border-end">
                                    <div style="max-width: 180px; overflow: hidden;">
                                        <div class="text-truncate" title="{{ $user->email }}" style="font-size: 0.9rem;">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center border-end">
                                    <span class="badge {{ $user->getRoleBadgeClass() }}">
                                        {{ $user->getRoleDisplayName() }}
                                    </span>
                                </td>
                                <td class="text-center border-end">
                                    <span class="fw-semibold fs-6">{{ $user->bookings_count }}</span>
                                    @if($user->bookings_count > 0)
                                        <div><small class="text-muted">Pemesanan</small></div>
                                    @else
                                        <div><small class="text-muted">tidak ada</small></div>
                                    @endif
                                </td>
                                <td class="text-center border-end">
                                    <div style="min-width: 80px;">
                                        <div class="fw-semibold" style="font-size: 0.85rem;">{{ $user->created_at->format('d M Y') }}</div>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $user->created_at->diffForHumans() }}</small>
                                    </div>
                                </td>
                                <td class="text-center border-end">
                                    <span class="badge bg-success">Aktif</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" 
                                                data-bs-toggle="modal" data-bs-target="#viewUserModal"
                                                onclick="viewUser({{ $user->id }})" 
                                                title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        @if($user->id !== auth()->id())
                                            <button type="button" class="btn btn-outline-warning"
                                                    data-bs-toggle="modal" data-bs-target="#editUserModal"
                                                    onclick="editUser({{ $user->id }})" 
                                                    title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger"
                                                    onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" 
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
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
                    Menampilkan <strong>{{ number_format($users->firstItem()) }}</strong> sampai <strong>{{ number_format($users->lastItem()) }}</strong> dari total <strong class="text-primary">{{ number_format($users->total()) }}</strong> pengguna
                    @if(request('search') || request('role'))
                        <div class="mt-1">
                            @if(request('search'))
                                <span class="badge bg-primary">{{ $users->total() }} hasil untuk "{{ request('search') }}"</span>
                            @endif
                            @if(request('role'))
                                <span class="badge bg-info ms-1">
                                    Filter: 
                                    @switch(request('role'))
                                        @case('customer')
                                            Pelanggan
                                            @break
                                        @case('admin')
                                            Admin
                                            @break
                                        @case('studio_staff')
                                            Petugas Studio
                                            @break
                                        @case('owner')
                                            Pemilik
                                            @break
                                        @default
                                            {{ request('role') }}
                                    @endswitch
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="d-flex align-items-center">
                    <small class="text-muted me-3">Halaman {{ $users->currentPage() }}/{{ $users->lastPage() }}</small>
                    <div class="pagination-wrapper">
                        {{ $users->withQueryString()->links('custom.pagination') }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                @if(request('search'))
                    <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                    <h5 class="text-muted mt-3">Tidak ada hasil pencarian</h5>
                    <p class="text-muted">Tidak ada pengguna yang cocok dengan kata kunci <strong>"{{ request('search') }}"</strong></p>
                    <div class="mt-4">
                        <a href="{{ route('admin.users') }}" class="btn btn-primary me-2">
                            <i class="bi bi-arrow-left me-2"></i>
                            Lihat Semua Pengguna
                        </a>
                        <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('searchInput').focus(); document.getElementById('searchInput').select();">
                            <i class="bi bi-pencil me-2"></i>
                            Coba Kata Kunci Lain
                        </button>
                    </div>
                @else
                    <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                    <h5 class="text-muted mt-3">Belum ada pengguna</h5>
                    <p class="text-muted">Belum ada pengguna yang terdaftar dalam sistem.</p>
                    <div class="mt-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi bi-plus-lg me-2"></i>
                            Tambah Pengguna Pertama
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-person-plus me-2"></i>
                    Tambah Pengguna Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add_name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="add_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="add_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_phone" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="add_phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="add_role" class="form-label">Peran</label>
                        <select class="form-select" id="add_role" name="role" required>
                            <option value="customer">Pelanggan</option>
                            <option value="admin">Admin</option>
                            <option value="studio_staff">Petugas Studio</option>
                            <option value="owner">Pemilik</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="add_password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control" id="add_password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control" id="add_password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>
                        Tambah Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-person me-2"></i>
Detail Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewUserContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>
Edit Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm">
                <div class="modal-body" id="editUserContent">
                    <!-- Content will be loaded dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>
Perbarui Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom styling for users table */
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
    
    .badge {
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        transition: all 0.2s ease-in-out;
    }
    
    .btn-group-sm .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .rounded-circle {
        font-weight: 600;
        font-size: 1.1rem;
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
    }
    
    /* Animation for modal */
    .modal.fade .modal-dialog {
        transform: translate(0, -50px);
        transition: transform 0.3s ease-out;
    }
    
    .modal.show .modal-dialog {
        transform: translate(0, 0);
    }
    
    /* Modal content styling */
    .modal-content {
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-title {
        font-weight: 600;
        color: #495057;
    }
    
    #viewUserContent .table td {
        padding: 0.75rem 0.5rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f4;
    }
    
    #viewUserContent .table td:first-child {
        font-weight: 600;
        color: #495057;
    }
    
    /* Users statistics styling */
    .users-stats {
        background-color: #f8f9fa;
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .users-stats .stat-item {
        display: flex;
        align-items: center;
        margin-right: 1.5rem;
    }
    
    .users-stats .stat-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0d6efd;
    }
    
    .users-stats .stat-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-right: 0.5rem;
    }
    
    /* Pagination loading states */
    .pagination a.loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    .pagination a:hover {
        transform: translateY(-1px);
        transition: transform 0.2s ease;
    }
    
    /* Search loading states */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    /* Search tips */
    .search-tips {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 0.25rem;
        opacity: 0.8;
    }
    
    /* Search input focus state */
    #searchInput:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    /* Responsive table improvements */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        border-radius: 0.375rem;
    }
    
    .table {
        margin-bottom: 0;
        min-width: 800px;
    }
    
    .table th, .table td {
        min-width: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        border-bottom: 1px solid #dee2e6;
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
    
    .table th:nth-child(3), .table td:nth-child(3) {
        white-space: normal;
        min-width: 150px;
    }
    
    .table th:nth-child(4), .table td:nth-child(4) {
        white-space: normal;
        min-width: 180px;
    }
    
    .table th:nth-child(7), .table td:nth-child(7) {
        white-space: normal;
        min-width: 100px;
    }
    
    /* Text truncation for email */
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100%;
    }
    
    /* Better email display */
    .table td:nth-child(4) {
        min-width: 180px;
        max-width: 200px;
    }
    
    .table td:nth-child(4) .text-truncate {
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }
    
    /* Utility classes */
    .min-w-0 {
        min-width: 0;
    }
    
    .flex-shrink-0 {
        flex-shrink: 0;
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
    
    /* Button group improvements */
    .btn-group-sm {
        white-space: nowrap;
    }
    
    .btn-group-sm .btn {
        min-width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Responsive pagination */
    @media (max-width: 768px) {
        .pagination-info {
            flex-direction: column;
            text-align: center;
        }
        
        .pagination-info > div {
            margin-bottom: 0.5rem;
        }
        
        .users-stats {
            padding: 0.75rem;
        }
        
        .users-stats .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .users-stats .me-4 {
            margin-right: 0 !important;
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
        
        /* Hide less important columns on mobile */
        .table th:nth-child(1), .table td:nth-child(1),
        .table th:nth-child(2), .table td:nth-child(2) {
            display: none;
        }
        
        .table th:nth-child(3), .table td:nth-child(3) {
            width: 40%;
        }
        
        .table th:nth-child(4), .table td:nth-child(4) {
            width: 35%;
        }
        
        .table th:nth-child(9), .table td:nth-child(9) {
            width: 25%;
        }
        
        .text-truncate {
            max-width: 100px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
// CSRF Token setup for AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// View User Details
function viewUser(userId) {
    const content = document.getElementById('viewUserContent');
    content.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mt-2 mb-0">Memuat detail pengguna...</p>
        </div>
    `;
    
    fetch(`/api/admin/users/${userId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const user = data.data;
            
            // Helper functions untuk menghindari duplikasi
            function getRoleBadgeClass(role) {
                switch(role) {
                    case 'admin': return 'danger';
                    case 'customer': return 'primary';
                    case 'studio_staff': return 'info';
                    case 'owner': return 'secondary';
                    default: return 'secondary';
                }
            }
            
            function getRoleDisplayName(role) {
                switch(role) {
                    case 'admin': return 'Admin';
                    case 'customer': return 'Pelanggan';
                    case 'studio_staff': return 'Petugas Studio';
                    case 'owner': return 'Pemilik';
                    default: return 'Unknown';
                }
            }
            
            const roleBadgeClass = getRoleBadgeClass(user.role);
            const roleDisplayName = getRoleDisplayName(user.role);
            const formattedId = user.formatted_id || 'USR' + String(user.id).padStart(3, '0');
            const bookingsCount = user.bookings_count || 0;
            const userPhone = user.phone || 'Tidak ada';
            let joinDate;
            try {
                joinDate = new Date(user.created_at).toLocaleDateString('id-ID', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
            } catch (e) {
                joinDate = new Date(user.created_at).toLocaleDateString();
            }
            
            content.innerHTML = `
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4 text-center mb-4">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                                 style="width: 80px; height: 80px; font-size: 2rem;">
                                ${user.name.charAt(0).toUpperCase()}
                            </div>
                            <h5 class="mb-2">${user.name}</h5>
                            <span class="badge bg-${roleBadgeClass} mb-3">
                                ${roleDisplayName}
                            </span>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="table-responsive">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td class="fw-bold text-nowrap" style="width: 35%;">ID Pengguna:</td>
                                        <td><span class="badge bg-secondary">${formattedId}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-nowrap">Email:</td>
                                        <td class="text-break">${user.email}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-nowrap">Telepon:</td>
                                        <td class="text-break">${userPhone}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-nowrap">Status:</td>
                                        <td>
                                            <span class="badge bg-success">Aktif</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-nowrap">Bergabung:</td>
                                        <td>${joinDate}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold text-nowrap">Total Pemesanan:</td>
                                        <td>
                                            <span class="badge bg-info">${bookingsCount}</span>
                                            <small class="text-muted ms-2">Pemesanan</small>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            content.innerHTML = `
                <div class="alert alert-danger d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>Gagal memuat detail pengguna. Silakan coba lagi.</div>
                </div>
            `;
        }
    })
    .catch(error => {
        content.innerHTML = `
            <div class="alert alert-danger d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>Terjadi kesalahan saat memuat data: ${error.message}</div>
            </div>
        `;
    });
}

// Edit User Form
function editUser(userId) {
    const content = document.getElementById('editUserContent');
    content.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mt-2 mb-0">Memuat form edit...</p>
        </div>
    `;
    
    fetch(`/api/admin/users/${userId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const user = data.data;
            content.innerHTML = `
                <div class="mb-3">
                    <label for="edit_name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="edit_name" name="name" value="${user.name}" required>
                </div>
                <div class="mb-3">
                    <label for="edit_email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="edit_email" name="email" value="${user.email}" required>
                </div>
                <div class="mb-3">
                    <label for="edit_phone" class="form-label">Telepon</label>
                    <input type="text" class="form-control" id="edit_phone" name="phone" value="${user.phone || ''}">
                </div>
                <div class="mb-3">
                    <label for="edit_role" class="form-label">Peran</label>
                    <select class="form-select" id="edit_role" name="role" required>
                        <option value="customer" ${user.role === 'customer' ? 'selected' : ''}>Pelanggan</option>
                        <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                        <option value="studio_staff" ${user.role === 'studio_staff' ? 'selected' : ''}>Petugas Studio</option>
                        <option value="owner" ${user.role === 'owner' ? 'selected' : ''}>Pemilik</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="edit_password" class="form-label">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" class="form-control" id="edit_password" name="password">
                </div>
                <div class="mb-3">
                    <label for="edit_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation">
                </div>
                <input type="hidden" id="edit_user_id" value="${user.id}">
            `;
        } else {
            content.innerHTML = `
                <div class="alert alert-danger d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>Gagal memuat form edit. Silakan coba lagi.</div>
                </div>
            `;
        }
    })
    .catch(error => {
        content.innerHTML = `
            <div class="alert alert-danger d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div>Terjadi kesalahan saat memuat form: ${error.message}</div>
            </div>
        `;
    });
}

// Delete User
function deleteUser(userId, userName) {
    Swal.fire({
        title: 'Hapus Pengguna',
        text: `Apakah Anda yakin ingin menghapus pengguna "${userName}"? Tindakan ini tidak dapat dibatalkan.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/api/admin/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    location.reload(); // Refresh page to update user list
                } else {
                    showAlert('danger', data.message);
                }
            })
            .catch(error => {
                showAlert('danger', 'Error deleting user: ' + error.message);
            });
        }
    });
}

// Add User Form Submission
document.getElementById('addUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('/api/admin/users', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data),
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            bootstrap.Modal.getInstance(document.getElementById('addUserModal')).hide();
            this.reset();
            location.reload(); // Refresh page to show new user
        } else {
            showAlert('danger', data.message);
            if (data.errors) {
                // Display validation errors
                let errorMessage = 'Validation errors:<br><br>';
                Object.keys(data.errors).forEach(field => {
                    errorMessage += `• ${data.errors[field].join(', ')}<br>`;
                });
                showSweetAlert('error', 'Validation Error', errorMessage);
            }
        }
    })
    .catch(error => {
        showAlert('danger', 'Error creating user: ' + error.message);
    });
});

// Edit User Form Submission
document.getElementById('editUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const userId = document.getElementById('edit_user_id').value;
    const formData = new FormData();
    
    // Collect form data
    formData.append('name', document.getElementById('edit_name').value);
    formData.append('email', document.getElementById('edit_email').value);
    formData.append('phone', document.getElementById('edit_phone').value);
    formData.append('role', document.getElementById('edit_role').value);
    
    if (document.getElementById('edit_password').value) {
        formData.append('password', document.getElementById('edit_password').value);
        formData.append('password_confirmation', document.getElementById('edit_password_confirmation').value);
    }
    
    const data = Object.fromEntries(formData);
    
    fetch(`/api/admin/users/${userId}`, {
        method: 'PUT',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data),
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            bootstrap.Modal.getInstance(document.getElementById('editUserModal')).hide();
            location.reload(); // Refresh page to show updated user
        } else {
            showAlert('danger', data.message);
            if (data.errors) {
                // Display validation errors
                let errorMessage = 'Validation errors:<br><br>';
                Object.keys(data.errors).forEach(field => {
                    errorMessage += `• ${data.errors[field].join(', ')}<br>`;
                });
                showSweetAlert('error', 'Validation Error', errorMessage);
            }
        }
    })
    .catch(error => {
        showAlert('danger', 'Error updating user: ' + error.message);
    });
});

// Initialize tooltips and search functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Search form handling
    const searchForm = document.getElementById('searchForm');
    const searchBtn = document.getElementById('searchBtn');
    const searchIcon = document.getElementById('searchIcon');
    const searchSpinner = document.getElementById('searchSpinner');
    const searchInput = document.getElementById('searchInput');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            // Show loading state
            searchIcon.classList.add('d-none');
            searchSpinner.classList.remove('d-none');
            searchBtn.disabled = true;
            
            // If search is empty, don't show loading (it's just clearing)
            if (!searchInput.value.trim()) {
                searchIcon.classList.remove('d-none');
                searchSpinner.classList.add('d-none');
                searchBtn.disabled = false;
            }
        });
        
        // Clear search with Enter key when input is empty
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter' && !this.value.trim()) {
                window.location.href = '{{ route("admin.users") }}';
            }
        });
        
        // Auto-focus search input with Ctrl+F or Cmd+F
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                window.location.href = '{{ route("admin.users") }}';
            }
        });
    }
    
    // Global keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl+F or Cmd+F to focus search (prevent default browser search)
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }
        
        // Escape key to clear search when not focused on input
        if (e.key === 'Escape' && document.activeElement !== searchInput) {
            if (searchInput && searchInput.value) {
                searchInput.value = '';
                window.location.href = '{{ route("admin.users") }}';
            }
        }
    });
    
    // Show search tips
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.setAttribute('title', 'Cari berdasarkan nama, email, atau telepon. Tekan Escape untuk membersihkan.');
        });
        
        searchInput.addEventListener('blur', function() {
            this.removeAttribute('title');
        });
    }
    
    // Add loading state to pagination links
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Show loading cursor
            document.body.style.cursor = 'wait';
            
            // Add loading class to clicked link
            this.classList.add('loading');
            
            // Reset cursor after a delay (fallback)
            setTimeout(() => {
                document.body.style.cursor = 'default';
            }, 3000);
        });
    });
});

// Helper function to show alerts
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert alert at the top of the main content
    const mainContent = document.querySelector('.main-content .container-fluid');
    mainContent.insertBefore(alertDiv, mainContent.firstChild);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>
@endpush
