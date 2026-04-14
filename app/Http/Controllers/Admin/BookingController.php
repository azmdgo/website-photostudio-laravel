<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display all bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'service.category', 'payments']);
        
        // Get total statistics (not filtered) for display
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');
        $pendingBookings = Booking::where('status', 'pending')->count();
        $completedBookings = Booking::where('status', 'completed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
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
        
        $bookings = $query->latest()->paginate(15);
        
        return view('admin.bookings.index', compact(
            'bookings', 
            'totalBookings', 
            'totalRevenue', 
            'pendingBookings', 
            'completedBookings', 
            'cancelledBookings'
        ));
    }
    
    /**
     * Show booking details.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'service.category', 'payments.verifiedBy']);
        
        return view('admin.bookings.show', compact('booking'));
    }
    
    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000'
        ]);
        
        // Special handling for completed status
        if ($request->status === 'completed') {
            $updateData = [
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
                'photo_session_completed_at' => now(),
                'updated_at' => now()
            ];
            
            // If DP payment type, set final payment deadline (3 days from now)
            if ($booking->payment_type === 'dp') {
                $updateData['final_payment_deadline'] = now()->addDays(3);
                
                // Create final payment if DP is verified but final payment doesn't exist
                $dpPayment = $booking->dp_payment;
                if ($dpPayment && $dpPayment->verification_status === 'verified' && !$booking->final_payment) {
                    Payment::create([
                        'booking_id' => $booking->id,
                        'amount' => $booking->remaining_amount,
                        'payment_method' => null,
                        'status' => 'pending',
                        'verification_status' => 'pending',
                    ]);
                }
            }
            
            $booking->update($updateData);
            
            $message = 'Status booking berhasil diupdate menjadi "Selesai"!' . 
                ($booking->payment_type === 'dp' ? ' Deadline pelunasan: 3 hari dari sekarang.' : '');
        } else {
            $booking->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
                'updated_at' => now()
            ]);
            
            $message = 'Status booking berhasil diupdate!';
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Delete booking.
     */
    public function destroy(Booking $booking)
    {
        // Only allow deletion of cancelled bookings
        if ($booking->status !== 'cancelled') {
            return redirect()->back()->with('error', 'Hanya booking yang dibatalkan yang dapat dihapus!');
        }
        
        $booking->delete();
        
        return redirect()->route('admin.bookings.index')
                        ->with('success', 'Booking berhasil dihapus!');
    }
    
    /**
     * Create payment for confirmed booking.
     */
    public function createPayment(Request $request, Booking $booking)
    {
        // Only confirmed bookings can have payments created
        if ($booking->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Hanya booking yang sudah dikonfirmasi yang dapat dibuat pembayaran!');
        }
        
        // Check if payment already exists
        if ($booking->payments->count() > 0) {
            return redirect()->back()->with('error', 'Pembayaran untuk booking ini sudah ada!');
        }
        
        // Determine payment amount based on payment type
        $amount = $booking->payment_type === 'dp' ? $booking->dp_amount : $booking->total_price;
        
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $amount,
            'payment_method' => null, // Will be updated when customer pays
            'status' => 'pending',
            'verification_status' => 'pending',
        ]);
        
        return redirect()->back()->with('success', 'Pembayaran berhasil dibuat! Silakan informasikan ke pelanggan untuk melakukan pembayaran.');
    }
    
    /**
     * Verify payment.
     */
    public function verifyPayment(Request $request, Payment $payment)
    {
        $request->validate([
            'verification_status' => 'required|in:verified,rejected',
            'verification_notes' => 'nullable|string|max:1000'
        ]);
        
        $payment->update([
            'verification_status' => $request->verification_status,
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'verification_notes' => $request->verification_notes,
        ]);
        
        // If payment is verified and it's DP, create remaining payment
        if ($request->verification_status === 'verified' && $payment->booking->payment_type === 'dp') {
            // Only create remaining payment if this is the DP payment (not the final payment)
            if ($payment->amount == $payment->booking->dp_amount) {
                $existingRemainingPayment = Payment::where('booking_id', $payment->booking_id)
                                                  ->where('amount', $payment->booking->remaining_amount)
                                                  ->first();
                
                if (!$existingRemainingPayment) {
                    Payment::create([
                        'booking_id' => $payment->booking_id,
                        'amount' => $payment->booking->remaining_amount,
                        'payment_method' => null,
                        'status' => 'pending',
                        'verification_status' => 'pending',
                    ]);
                }
            }
        }
        
        $message = $request->verification_status === 'verified' 
            ? 'Pembayaran berhasil diverifikasi!' 
            : 'Pembayaran ditolak!';
            
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Mark payment as paid (when customer uploads proof).
     */
    public function markPaymentPaid(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,transfer,ewallet',
            'payment_proof' => 'nullable|string',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        $payment->update([
            'payment_method' => $request->payment_method,
            'status' => 'paid',
            'paid_at' => now(),
            'payment_proof' => $request->payment_proof,
            'notes' => $request->notes,
        ]);
        
        return redirect()->back()->with('success', 'Status pembayaran berhasil diupdate menjadi "Dibayar"!');
    }
    
}
