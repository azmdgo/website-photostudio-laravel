@extends('admin.layouts.app')

@section('title', 'Detail Service')
@section('page-title', 'Kelola Layanan')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <!-- Header -->
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0 text-white">Detail Service</h1>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.services.edit', $service) }}" 
                       class="btn btn-light btn-sm d-flex align-items-center">
                        <i class="bi bi-pencil-square me-1"></i>
                        Edit
                    </a>
                    <a href="{{ route('admin.services.index') }}" 
                       class="btn btn-secondary btn-sm d-flex align-items-center">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="card-body p-4">
            <div class="row g-4">
                <!-- Service Image -->
                <div class="col-lg-6">
                    <h3 class="h5 fw-bold text-dark mb-3">Gambar Service</h3>
                    @if($service->image && file_exists(public_path('storage/' . $service->image)))
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $service->image) }}" 
                                 alt="{{ $service->name }}" 
                                 class="img-fluid rounded shadow" style="height: 300px; width: 100%; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-2">
                                @if($service->is_active)
                                    <span class="badge bg-success rounded-pill">
                                        <i class="bi bi-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill">
                                        <i class="bi bi-x-circle me-1"></i>Tidak Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                    @elseif($service->image)
                        <div class="bg-warning bg-opacity-10 border border-warning rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                            <div class="text-center text-warning">
                                <i class="bi bi-exclamation-triangle" style="font-size: 4rem;"></i>
                                <p class="mt-2 mb-1 fw-bold">File gambar tidak ditemukan</p>
                                <small class="text-muted">{{ $service->image }}</small>
                            </div>
                        </div>
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                            <div class="text-center text-muted">
                                <i class="bi bi-image" style="font-size: 4rem;"></i>
                                <p class="mt-2 mb-0">Tidak ada gambar</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Service Details -->
                <div class="col-lg-6">
                    <div>
                        <h3 class="h5 fw-bold text-dark mb-3">Informasi Layanan</h3>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="bg-light p-3 rounded">
                                    <label class="form-label small fw-medium text-muted mb-1">Nama Service</label>
                                    <p class="h6 fw-bold text-dark mb-0">{{ $service->name }}</p>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="bg-light p-3 rounded">
                                    <label class="form-label small fw-medium text-muted mb-1">Harga</label>
                                    <p class="h6 fw-bold text-success mb-0">
                                        Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="bg-light p-3 rounded">
                                    <label class="form-label small fw-medium text-muted mb-1">Durasi</label>
                                    <p class="h6 text-dark mb-0">{{ $service->duration_minutes }} Menit</p>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="bg-light p-3 rounded">
                                    <label class="form-label small fw-medium text-muted mb-1">Status</label>
                                    @if($service->is_active)
                                        <span class="badge bg-success d-flex align-items-center" style="width: fit-content;">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-danger d-flex align-items-center" style="width: fit-content;">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            @if($service->description)
            <div class="row mt-4">
                <div class="col-12">
                    <h3 class="h5 fw-bold text-dark mb-3">Deskripsi</h3>
                    <div class="bg-light p-4 rounded">
                        <p class="text-dark lh-base mb-0">{{ $service->description }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Metadata Section -->
            <div class="row mt-4 pt-3 border-top">
                <div class="col-md-6">
                    <small class="text-muted">
                        <strong>Dibuat:</strong> {{ $service->created_at->format('d M Y, H:i') }}
                    </small>
                </div>
                <div class="col-md-6">
                    <small class="text-muted">
                        <strong>Diperbarui:</strong> {{ $service->updated_at->format('d M Y, H:i') }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
