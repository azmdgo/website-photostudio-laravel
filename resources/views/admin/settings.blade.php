@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-gear me-2"></i>
                    System Settings
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_name" class="form-label">Studio Name</label>
                                <input type="text" class="form-control" id="site_name" name="site_name" 
                                       value="Yujin Foto Studio" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_email" class="form-label">Studio Email</label>
                                <input type="email" class="form-control" id="site_email" name="site_email" 
                                       value="info@yujinfotostudio.com" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_phone" class="form-label">Studio Phone</label>
                                <input type="text" class="form-control" id="site_phone" name="site_phone" 
                                       value="+62 812-3456-7890">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="business_hours" class="form-label">Business Hours</label>
                                <input type="text" class="form-control" id="business_hours" name="business_hours" 
                                       value="09:00 - 18:00">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="site_address" class="form-label">Studio Address</label>
                        <textarea class="form-control" id="site_address" name="site_address" 
                                  rows="3">Jl. Fotografi No. 123, Jakarta Selatan, DKI Jakarta 12345</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="site_description" class="form-label">Studio Description</label>
                        <textarea class="form-control" id="site_description" name="site_description" 
                                  rows="4">Yujin Foto Studio adalah studio fotografi profesional yang menyediakan layanan foto wedding, prewedding, portrait, dan event photography dengan kualitas terbaik.</textarea>
                    </div>

                    <hr>

                    <h6 class="mb-3">Booking Settings</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_bookings_per_day" class="form-label">Max Bookings Per Day</label>
                                <input type="number" class="form-control" id="max_bookings_per_day" name="max_bookings_per_day" 
                                       value="5" min="1" max="20" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="booking_advance_days" class="form-label">Booking Advance Days</label>
                                <input type="number" class="form-control" id="booking_advance_days" name="booking_advance_days" 
                                       value="30" min="1" max="365" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input type="hidden" name="auto_confirm_bookings" value="0">
                                <input class="form-check-input" type="checkbox" id="auto_confirm_bookings" name="auto_confirm_bookings" value="1" checked>
                                <label class="form-check-label" for="auto_confirm_bookings">
                                    Auto Confirm Bookings
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input type="hidden" name="email_notifications" value="0">
                                <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" value="1" checked>
                                <label class="form-check-label" for="email_notifications">
                                    Email Notifications
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-2"></i>
                            Save Settings
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
                    System Info
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Laravel Version:</span>
                    <span class="fw-semibold">{{ app()->version() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">PHP Version:</span>
                    <span class="fw-semibold">{{ PHP_VERSION }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Environment:</span>
                    <span class="badge bg-{{ app()->environment() === 'production' ? 'success' : 'warning' }}">
                        {{ ucfirst(app()->environment()) }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Debug Mode:</span>
                    <span class="badge bg-{{ config('app.debug') ? 'danger' : 'success' }}">
                        {{ config('app.debug') ? 'On' : 'Off' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-shield-check me-2"></i>
                    Maintenance Mode
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    Put the website in maintenance mode to perform updates or maintenance.
                </p>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-warning" onclick="toggleMaintenance()">
                        <i class="bi bi-tools me-2"></i>
                        Enable Maintenance
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="clearCache()">
                        <i class="bi bi-arrow-clockwise me-2"></i>
                        Clear Cache
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleMaintenance() {
    if (confirm('Are you sure you want to enable maintenance mode? This will make the website unavailable to users.')) {
        // In a real implementation, this would make an AJAX call to enable maintenance mode
        alert('Maintenance mode would be enabled here. This is a demo.');
    }
}

function clearCache() {
    if (confirm('Are you sure you want to clear all cache?')) {
        // In a real implementation, this would make an AJAX call to clear cache
        alert('Cache would be cleared here. This is a demo.');
    }
}
</script>
@endpush
