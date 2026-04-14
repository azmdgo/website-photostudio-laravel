<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $recentBookings = $user->bookings()->with('service.category')
                                       ->latest()
                                       ->take(3)
                                       ->get();
        
        $totalBookings = $user->bookings()->count();
        $pendingBookings = $user->bookings()->where('status', 'pending')->count();
        $completedBookings = $user->bookings()->where('status', 'completed')->count();
        
        return view('customer.dashboard', compact(
            'user', 
            'recentBookings', 
            'totalBookings', 
            'pendingBookings', 
            'completedBookings'
        ))->with('showFooter', true);
    }

    /**
     * Display services page.
     */
    public function services()
    {
        $categories = ServiceCategory::active()
                                    ->with(['services' => function($query) {
                                        $query->active();
                                    }])
                                    ->get();
        
        return view('customer.services', compact('categories'))->with('showFooter', true);
    }

    /**
     * Display booking form.
     */
    public function booking(Request $request)
    {
        $categories = ServiceCategory::active()
                                    ->with(['services' => function($query) {
                                        $query->active();
                                    }])
                                    ->get();
        
        $selectedService = null;
        if ($request->has('service')) {
            $selectedService = Service::active()->find($request->service);
        }
        
        return view('customer.booking', compact('categories', 'selectedService'))->with('showFooter', true);
    }

    /**
     * Store a new booking.
     */
    public function storeBooking(Request $request)
    {
        // Get the service to check if it's an outdoor service
        $service = Service::with('category')->findOrFail($request->service_id);
        $isOutdoor = $service->category->name === 'Outdoor Photography';
        
        $validationRules = [
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:today',
            'booking_time' => 'required',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'notes' => 'nullable|string|max:1000',
            'payment_type' => 'required|in:full,dp',
        ];
        
        // Add location validation for outdoor services
        if ($isOutdoor) {
            $validationRules['location_address'] = 'required|string|max:500';
            $validationRules['latitude'] = 'nullable|numeric|between:-90,90';
            $validationRules['longitude'] = 'nullable|numeric|between:-180,180';
        }
        
        $request->validate($validationRules);

        $service = Service::findOrFail($request->service_id);
        
        // Check if the time slot is available (more strict check)
        $existingBooking = Booking::where('booking_date', $request->booking_date)
                                 ->where('booking_time', $request->booking_time)
                                 ->where('status', '!=', 'cancelled')
                                 ->first();
        
        if ($existingBooking) {
            return back()->withErrors([
                'booking_time' => 'Maaf, pada jam tersebut sudah ada yang melakukan booking. Silakan pilih waktu lain.'
            ])->withInput();
        }

        // Calculate DP amounts if payment type is DP
        $dpAmount = null;
        $remainingAmount = null;
        if ($request->payment_type === 'dp') {
            $dpAmount = round($service->price * 0.3);
            $remainingAmount = $service->price - $dpAmount;
        }
        
        $bookingData = [
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'notes' => $request->notes,
            'total_price' => $service->price,
            'payment_type' => $request->payment_type,
            'dp_amount' => $dpAmount,
            'remaining_amount' => $remainingAmount,
            'status' => 'confirmed', // Auto-confirm booking
        ];
        
        // Add location fields if service is outdoor
        if ($service->category->name === 'Outdoor Photography') {
            $bookingData['location_address'] = $request->location_address;
            $bookingData['latitude'] = $request->latitude;
            $bookingData['longitude'] = $request->longitude;
        }
        
        $booking = Booking::create($bookingData);

        return redirect()->route('customer.orders')
                        ->with('success', 'Booking berhasil dibuat dan dikonfirmasi otomatis! Nomor booking: ' . $booking->booking_number);
    }

    /**
     * Display user orders.
     */
    public function orders()
    {
        $bookings = Auth::user()->bookings()
                              ->with(['service.category', 'payments'])
                              ->latest()
                              ->paginate(10);
        
        return view('customer.orders', compact('bookings'))->with('showFooter', true);
    }

    /**
     * Display about page.
     */
    public function about()
    {
        return view('customer.about')->with('showFooter', true);
    }

    /**
     * Check time slot availability.
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'service_id' => 'required|exists:services,id'
        ]);

        $availableTimes = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];
        $bookedTimes = [];

        // Get all booked times for the selected date
        $existingBookings = Booking::where('booking_date', $request->booking_date)
                                  ->where('status', '!=', 'cancelled')
                                  ->pluck('booking_time')
                                  ->toArray();

        // Convert to string format for comparison
        $bookedTimes = array_map(function($time) {
            // If time is already in H:i format, return as is
            if (preg_match('/^\d{2}:\d{2}$/', $time)) {
                return $time;
            }
            // If it's a datetime, extract the time part
            return date('H:i', strtotime($time));
        }, $existingBookings);

        return response()->json([
            'available_times' => $availableTimes,
            'booked_times' => array_unique($bookedTimes)
        ]);
    }
    
    /**
     * Upload payment proof for a payment.
     */
    public function uploadPaymentProof(Request $request, Payment $payment)
    {
        // Verify that this payment belongs to the authenticated user
        if ($payment->booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to payment');
        }
        
        $request->validate([
            'payment_proof' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        // Update payment with proof
        $payment->update([
            'payment_proof' => $request->payment_proof,
            'notes' => $request->notes,
            'status' => 'paid',  // Mark as paid when proof is uploaded
            'paid_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload! Admin akan memverifikasi pembayaran Anda.');
    }
}
