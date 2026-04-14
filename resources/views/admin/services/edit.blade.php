@extends('admin.layouts.app')

@section('title', 'Edit Layanan')
@section('page-title', 'Kelola Layanan')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Edit Layanan</h1>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Layanan
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Service Category -->
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Kategori Layanan *</label>
                                <select name="category_id" id="category_id" 
                                        class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Service Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Layanan *</label>
                                <input type="text" name="name" id="name" 
                                       value="{{ old('name', $service->name) }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Harga (IDR) *</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="price" id="price" 
                                           value="{{ old('price', $service->price) }}"
                                           step="0.01" min="0"
                                           class="form-control @error('price') is-invalid @enderror"
                                           required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="col-md-6 mb-3">
                                <label for="duration_minutes" class="form-label">Durasi (Menit) *</label>
                                <div class="input-group">
                                    <input type="number" name="duration_minutes" id="duration_minutes" 
                                           value="{{ old('duration_minutes', $service->duration_minutes) }}"
                                           min="1"
                                           class="form-control @error('duration_minutes') is-invalid @enderror"
                                           required>
                                    <span class="input-group-text">Menit</span>
                                    @error('duration_minutes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">Masukkan durasi dalam menit (contoh: 60 untuk 1 jam, 120 untuk 2 jam)</small>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" rows="4"
                      class="form-control @error('description') is-invalid @enderror"
                      placeholder="Masukkan deskripsi layanan...">{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if($service->image && file_exists(public_path('storage/' . $service->image)))
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $service->image) }}" 
                                     alt="{{ $service->name }}"
                                     class="rounded border" 
                                     style="width: 100px; height: 100px; object-fit: cover;">
                                <div class="ms-3">
                                    <small class="text-muted">Gambar saat ini akan diganti jika Anda mengunggah gambar baru.</small>
                                </div>
                            </div>
                        </div>
                        @elseif($service->image)
                        <div class="mb-3">
                            <label class="form-label">Gambar Saat Ini</label>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                File gambar tidak ditemukan. Silakan upload gambar baru.
                                <br><small class="text-muted">Path yang hilang: {{ $service->image }}</small>
                            </div>
                        </div>
                        @endif

                        <!-- Service Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">
                                {{ $service->image ? 'Gambar Baru (Opsional)' : 'Gambar Layanan' }}
                            </label>
                            <input type="file" name="image" id="image" 
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   class="form-control @error('image') is-invalid @enderror">
                            <small class="form-text text-muted">Format yang diterima: JPEG, PNG, JPG, WebP. Ukuran maksimal: 2MB</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="image-preview" class="mt-3" style="display: none;">
                                <label class="form-label">Pratinjau:</label>
                                <div>
                                    <img id="preview-img" src="" alt="Preview" 
                                         class="rounded border" 
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" 
                                       value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                                       class="form-check-input">
                                <label for="is_active" class="form-check-label">
                                    Layanan Aktif
                                </label>
                            </div>
                            <small class="form-text text-muted">Layanan tidak aktif tidak akan tersedia untuk pemesanan</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Perbarui Layanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });
</script>
@endpush
