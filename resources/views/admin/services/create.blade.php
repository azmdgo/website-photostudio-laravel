@extends('admin.layouts.app')

@section('title', 'Tambah Layanan')
@section('page-title', 'Kelola Layanan')

@section('page-actions')
    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>
        Kembali ke Layanan
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-plus-circle me-2"></i>
                    Informasi Layanan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required
                               placeholder="contoh: Paket Fotografi Pernikahan">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required
                                  placeholder="Jelaskan apa yang termasuk dalam layanan ini...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Layanan</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <div class="form-text">Unggah gambar untuk layanan (opsional). Format yang diterima: JPG, PNG, WebP</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price') }}" required
                                           min="0" step="1000" placeholder="500000">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">Masukkan jumlah tanpa desimal</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
<label for="duration_minutes" class="form-label">Durasi (Menit) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" 
                                       id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" required
                                       min="60" max="1440" placeholder="120">
                                @error('duration_minutes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Berapa menit layanan ini berlangsung?</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Layanan Aktif
                            </label>
                            <small class="form-text text-muted d-block">
                                Hanya layanan aktif yang dapat dipesan oleh pelanggan
                            </small>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-lg me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>
                            Buat Layanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Tips
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="alert-heading">Panduan Layanan</h6>
                    <ul class="mb-0 small">
                        <li>Gunakan nama yang jelas dan deskriptif</li>
                        <li>Sertakan apa yang termasuk dalam deskripsi</li>
                        <li>Tetapkan harga yang kompetitif</li>
                        <li>Realistis dengan perkiraan durasi</li>
                        <li>Layanan tidak aktif tidak akan muncul untuk pelanggan</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6 class="alert-heading">Catatan Harga</h6>
                    <p class="mb-0 small">
                        Pertimbangkan semua biaya termasuk peralatan, perjalanan, waktu editing, dan margin keuntungan saat menetapkan harga.
                    </p>
                </div>
            </div>
        </div>

        @if($categories->count() == 0)
        <div class="card mt-3">
            <div class="card-body text-center">
                <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                <h6 class="mt-2">Tidak Ada Kategori Tersedia</h6>
                <p class="text-muted small">
                    Anda perlu membuat kategori layanan terlebih dahulu sebelum menambahkan layanan.
                </p>
                <a href="#" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus-lg me-1"></i>
                    Tambah Kategori
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Auto-generate slug from name (for future use)
document.getElementById('name').addEventListener('input', function() {
    // You can add slug generation logic here if needed
});

// Format price input
document.getElementById('price').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    this.value = value;
});
</script>

@endsection
