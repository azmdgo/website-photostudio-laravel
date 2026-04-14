<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display schedule of completed bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'service.category', 'payments'])
                       ->where('status', 'completed');
        
        // Get total statistics (not filtered) for display
        $totalCompleted = Booking::where('status', 'completed')->count();
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');
        $weekCompleted = Booking::where('status', 'completed')
                               ->where('booking_date', '>=', now()->startOfWeek())
                               ->count();
        $monthCompleted = Booking::where('status', 'completed')
                                ->where('booking_date', '>=', now()->startOfMonth())
                                ->count();
        $dpBookings = Booking::where('status', 'completed')
                            ->where('payment_type', 'dp')
                            ->count();
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }
        
        // Filter by service category
        if ($request->filled('category')) {
            $query->whereHas('service.category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }
        
        // Search by booking number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        // Order by booking date
        $bookings = $query->orderBy('booking_date', 'desc')->paginate(15);
        
        // Get service categories for filter
        $categories = ServiceCategory::has('services')->get();
        
        return view('admin.schedule.index', compact(
            'bookings', 
            'categories', 
            'totalCompleted', 
            'totalRevenue', 
            'weekCompleted', 
            'monthCompleted', 
            'dpBookings'
        ));
    }
    
    /**
     * Display schedule details for modal.
     */
    public function show(Booking $booking)
    {
        // Load only necessary relationships for schedule details
        $booking->load(['user', 'service.category']);
        
        return view('admin.schedule.show', compact('booking'));
    }
}
