<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display the staff dashboard.
     */
    public function dashboard()
    {
        // Basic statistics for staff
        $totalBookingsToday = Booking::whereDate('booking_date', today())->count();
        $totalBookingsThisWeek = Booking::whereBetween('booking_date', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();
        $totalBookingsThisMonth = Booking::whereMonth('booking_date', now()->month)
                                        ->whereYear('booking_date', now()->year)
                                        ->count();
        
        // Upcoming bookings for today
        $todayBookings = Booking::with(['user', 'service.category'])
                               ->whereDate('booking_date', today())
                               ->where('status', '!=', 'cancelled')
                               ->orderBy('booking_time')
                               ->get();
        
        // Upcoming bookings for this week
        $weekBookings = Booking::with(['user', 'service.category'])
                              ->whereBetween('booking_date', [
                                  now()->startOfWeek(),
                                  now()->endOfWeek()
                              ])
                              ->where('status', '!=', 'cancelled')
                              ->orderBy('booking_date')
                              ->orderBy('booking_time')
                              ->take(10)
                              ->get();
        
        // Bookings for this month (for filter functionality)
        $monthBookings = Booking::with(['user', 'service.category'])
                               ->whereMonth('booking_date', now()->month)
                               ->whereYear('booking_date', now()->year)
                               ->where('status', '!=', 'cancelled')
                               ->orderBy('booking_date')
                               ->orderBy('booking_time')
                               ->get();
        
        // Recent activities (latest bookings)
        $recentBookings = Booking::with(['user', 'service.category'])
                                ->latest()
                                ->take(5)
                                ->get();
        
        // Booking status statistics for charts
        $bookingStats = Booking::select('status', DB::raw('count(*) as count'))
                              ->groupBy('status')
                              ->get();
        
        return view('staff.dashboard', compact(
            'totalBookingsToday',
            'totalBookingsThisWeek',
            'totalBookingsThisMonth',
            'todayBookings',
            'weekBookings',
            'monthBookings',
            'recentBookings',
            'bookingStats'
        ));
    }
    
    /**
     * Display schedule page.
     */
    public function schedule(Request $request)
    {
        $query = Booking::with(['user', 'service.category']);
        
        // Filter by date if provided
        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        } else {
            // Default to show bookings from today onwards
            $query->where('booking_date', '>=', today());
        }
        
        // Filter by service type (indoor/outdoor) if provided
        if ($request->filled('location')) {
            $query->whereHas('service.category', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->location . '%');
            });
        }
        
        // Get bookings ordered by date and time
        $bookings = $query->orderBy('booking_date')
                         ->orderBy('booking_time')
                         ->paginate(20);
        
        return view('staff.schedule.index', compact('bookings'));
    }
    
    /**
     * Show specific booking details.
     */
    public function showBooking(Booking $booking)
    {
        $booking->load(['user', 'service.category', 'payments']);
        
        // Status color classes
        $statusClasses = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'in_progress' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger'
        ];
        
        return view('staff.schedule.show', compact('booking', 'statusClasses'));
    }
    
    /**
     * Update booking status (limited permissions for staff).
     */
    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:confirmed,in_progress,completed'
        ]);
        
        // Staff can only update certain statuses
        $allowedStatuses = ['confirmed', 'in_progress', 'completed'];
        
        if (!in_array($request->status, $allowedStatuses)) {
            return redirect()->back()
                           ->with('error', 'Anda tidak memiliki izin untuk mengubah status ke ' . $request->status);
        }
        
        $booking->update([
            'status' => $request->status
        ]);
        
        $statusMessages = [
            'confirmed' => 'Booking telah dikonfirmasi',
            'in_progress' => 'Booking sedang berlangsung',
            'completed' => 'Booking telah selesai'
        ];
        
        return redirect()->back()
                       ->with('success', $statusMessages[$request->status]);
    }
}
