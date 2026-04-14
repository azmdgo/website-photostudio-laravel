<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Staff\StaffController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('home');
})->name('home');

// Public pages
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Contact form submission
Route::post('/contact', function () {
    // Handle contact form submission here
    return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
})->name('contact.submit');

// Dashboard route - redirect based on authentication
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return redirect()->route('customer.dashboard');
    }
    return redirect()->route('login')->with('message', 'Silakan login terlebih dahulu untuk mengakses dashboard.');
})->name('dashboard');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Registration
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Customer Routes (Protected)
Route::middleware(['auth', 'verified'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/services', [DashboardController::class, 'services'])->name('services');
    Route::get('/booking', [DashboardController::class, 'booking'])->name('booking');
    Route::post('/booking', [DashboardController::class, 'storeBooking'])->name('booking.store');
    Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
    Route::get('/about', [DashboardController::class, 'about'])->name('about');
    
    // Check time slot availability
    Route::get('/booking/check-availability', [DashboardController::class, 'checkAvailability'])->name('booking.check-availability');
    
    // Payment proof upload
    Route::post('/payment/{payment}/upload-proof', [DashboardController::class, 'uploadPaymentProof'])->name('payment.upload-proof');
});

// Owner Routes (Protected) - Requires owner role
Route::middleware(['auth', 'owner'])->prefix('owner')->name('owner.')->group(function () {
    // Owner Dashboard
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
    
    // Business Intelligence Dashboard
    Route::get('/business-intelligence', [OwnerController::class, 'businessIntelligence'])->name('business-intelligence');
    Route::get('/business-intelligence/service-category-data', [OwnerController::class, 'getServiceCategoryData'])->name('business-intelligence.service-category-data');
    Route::get('/business-intelligence/revenue-data', [OwnerController::class, 'getRevenueData'])->name('business-intelligence.revenue-data');
    Route::get('/business-intelligence/customer-growth-data', [OwnerController::class, 'getCustomerGrowthData'])->name('business-intelligence.customer-growth-data');
    Route::get('/business-intelligence/service-data', [OwnerController::class, 'getServiceData'])->name('business-intelligence.service-data');
    Route::get('/business-intelligence/status-data', [OwnerController::class, 'getStatusData'])->name('business-intelligence.status-data');
    Route::get('/business-intelligence/cancellation-reason-data', [OwnerController::class, 'getCancellationReasonData'])->name('business-intelligence.cancellation-reason-data');
    Route::get('/business-intelligence/ai-insights', [OwnerController::class, 'getAIInsights'])->name('business-intelligence.ai-insights');
    Route::get('/business-intelligence/export-pdf', [OwnerController::class, 'exportBusinessReport'])->defaults('format', 'pdf')->name('business-intelligence.export-pdf');
    Route::get('/business-intelligence/export-excel', [OwnerController::class, 'exportBusinessReport'])->defaults('format', 'excel')->name('business-intelligence.export-excel');
});

// Admin Routes (Protected) - Requires admin role
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard.alt');
    
    // Admin Settings & Users
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    
    // Business Intelligence Dashboard
    Route::get('/business-intelligence', [AdminController::class, 'businessIntelligence'])->name('business-intelligence');
    Route::get('/business-intelligence/service-category-data', [AdminController::class, 'getServiceCategoryData'])->name('business-intelligence.service-category-data');
    Route::get('/business-intelligence/revenue-data', [AdminController::class, 'getRevenueData'])->name('business-intelligence.revenue-data');
    Route::get('/business-intelligence/customer-growth-data', [AdminController::class, 'getCustomerGrowthData'])->name('business-intelligence.customer-growth-data');
    Route::get('/business-intelligence/service-data', [AdminController::class, 'getServiceData'])->name('business-intelligence.service-data');
    Route::get('/business-intelligence/status-data', [AdminController::class, 'getStatusData'])->name('business-intelligence.status-data');
    Route::get('/business-intelligence/cancellation-reason-data', [AdminController::class, 'getCancellationReasonData'])->name('business-intelligence.cancellation-reason-data');
    Route::get('/business-intelligence/ai-insights', [AdminController::class, 'getAIInsights'])->name('business-intelligence.ai-insights');
    Route::get('/business-intelligence/export/{format}', [AdminController::class, 'exportBusinessReport'])->name('business-intelligence.export');
    Route::get('/business-intelligence/export-pdf', [AdminController::class, 'exportBusinessReport'])->defaults('format', 'pdf')->name('business-intelligence.export-pdf');
    Route::get('/business-intelligence/export-excel', [AdminController::class, 'exportBusinessReport'])->defaults('format', 'excel')->name('business-intelligence.export-excel');
    
    // Booking Management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
    
    // Schedule Management
    Route::get('/schedule', [AdminScheduleController::class, 'index'])->name('schedule.index');
    Route::get('/schedule/{booking}', [AdminScheduleController::class, 'show'])->name('schedule.show');
    
    // Payment Management
    Route::post('/bookings/{booking}/create-payment', [AdminBookingController::class, 'createPayment'])->name('bookings.create-payment');
    Route::patch('/payments/{payment}/verify', [AdminBookingController::class, 'verifyPayment'])->name('payments.verify');
    Route::patch('/payments/{payment}/mark-paid', [AdminBookingController::class, 'markPaymentPaid'])->name('payments.mark-paid');
    
    // Service Management
    Route::resource('services', AdminServiceController::class);
});

// Staff Routes (Protected) - Requires studio_staff role
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    // Staff Dashboard
    Route::get('/', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard.alt');
    
    // Schedule Management
    Route::get('/schedule', [StaffController::class, 'schedule'])->name('schedule');
    Route::get('/schedule/{booking}', [StaffController::class, 'showBooking'])->name('schedule.show');
    Route::patch('/schedule/{booking}/status', [StaffController::class, 'updateBookingStatus'])->name('schedule.update-status');
});
