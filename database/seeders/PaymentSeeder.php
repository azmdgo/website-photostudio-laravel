<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    private static $paymentCounter = 1;
    private $paymentNumberCounter = 1;
    private static $usedPaymentNumbers = [];
    
    /**
     * Generate unique payment number using UUID substring
     */
    private function generateUniquePaymentNumber()
    {
        // Use microtime for guaranteed uniqueness
        $microtime = str_replace('.', '', microtime(true));
        $number = 'PAY' . date('Ymd') . substr($microtime, -6);
        
        // Ensure uniqueness by checking against used numbers
        while (in_array($number, self::$usedPaymentNumbers)) {
            usleep(1000); // Wait 1ms
            $microtime = str_replace('.', '', microtime(true));
            $number = 'PAY' . date('Ymd') . substr($microtime, -6);
        }
        
        self::$usedPaymentNumbers[] = $number;
        return $number;
    }
    
    public function run(): void
    {
        // Reset counter to ensure uniqueness
        self::$paymentCounter = 1;
        self::$usedPaymentNumbers = [];
        
        // Check if payments already exist
        if (Payment::count() > 0) {
            $this->command->info('Payments already exist, skipping PaymentSeeder.');
            return;
        }
        
        $bookings = Booking::all();
        
        foreach ($bookings as $booking) {
            $this->createPaymentForBooking($booking);
            // Add small delay to ensure unique payment numbers
            usleep(1000);
        }
    }
    
    private function createPaymentForBooking($booking)
    {
        $paymentMethods = ['cash', 'transfer', 'ewallet'];
        $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
        
        // Determine payment status based on booking status
        $paymentStatus = match ($booking->status) {
            'completed' => 'paid',
            'confirmed' => rand(0, 1) ? 'paid' : 'pending',
            'pending' => 'pending',
            'cancelled' => rand(0, 1) ? 'refunded' : 'failed',
            default => 'pending'
        };
        
        // Generate payment number
        $paymentNumber = $this->generateUniquePaymentNumber();
        
        // Calculate payment amount (could be partial or full)
        $paymentAmount = $booking->total_price;
        
        // Determine payment type based on booking status and realistic scenarios
        $useDownPayment = $this->shouldUseDownPayment($booking);
        
        if ($useDownPayment) {
            $this->createDownPaymentFlow($booking, $paymentMethod);
        } else {
            $this->createFullPayment($booking, $paymentMethod, $paymentStatus, $paymentNumber);
        }
    }
    
    /**
     * Determine if booking should use down payment system
     */
    private function shouldUseDownPayment($booking)
    {
        // Higher chance of DP for expensive services (>= 500k)
        if ($booking->total_price >= 500000) {
            return rand(1, 100) <= 85; // 85% chance for expensive services
        }
        
        // Medium chance for mid-range services (300k - 500k)
        if ($booking->total_price >= 300000) {
            return rand(1, 100) <= 70; // 70% chance for mid-range services
        }
        
        // Lower chance for cheaper services (< 300k)
        return rand(1, 100) <= 45; // 45% chance for cheaper services
    }
    
    /**
     * Create down payment flow (DP + Pelunasan)
     */
    private function createDownPaymentFlow($booking, $paymentMethod)
    {
        // DP percentage varies by service price
        $dpPercent = $this->getDpPercentage($booking->total_price);
        $dpAmount = $booking->total_price * $dpPercent;
        $remainingAmount = $booking->total_price - $dpAmount;
        
        // Create DP payment
        $dpStatus = $this->getDpStatus($booking->status);
        $dpPayment = Payment::create([
            'payment_number' => $this->generateUniquePaymentNumber(),
            'booking_id' => $booking->id,
            'amount' => $dpAmount,
            'payment_method' => $paymentMethod,
            'status' => $dpStatus,
            'payment_proof' => $dpStatus === 'paid' ? $this->generatePaymentProof($paymentMethod) : null,
            'paid_at' => $dpStatus === 'paid' ? $booking->created_at->addDays(rand(0, 2)) : null,
            'notes' => 'Pembayaran DP (' . ($dpPercent * 100) . '% dari total)',
            'created_at' => $booking->created_at,
            'updated_at' => $booking->created_at->addDays(rand(0, 2)),
        ]);
        
        // Create pelunasan payment if DP is paid and booking is not cancelled
        if ($dpStatus === 'paid' && !in_array($booking->status, ['cancelled', 'pending'])) {
            $pelunasanStatus = $this->getPelunasanStatus($booking->status);
            $pelunasanDate = $booking->created_at->addDays(rand(3, 14)); // 3-14 days after DP
            
            // Add delay to ensure unique payment number
            usleep(2000);
            
            Payment::create([
                'payment_number' => $this->generateUniquePaymentNumber(),
                'booking_id' => $booking->id,
                'amount' => $remainingAmount,
                'payment_method' => $paymentMethod,
                'status' => $pelunasanStatus,
                'payment_proof' => $pelunasanStatus === 'paid' ? $this->generatePaymentProof($paymentMethod) : null,
                'paid_at' => $pelunasanStatus === 'paid' ? $pelunasanDate : null,
                'notes' => 'Pelunasan pembayaran (' . (100 - ($dpPercent * 100)) . '% sisa)',
                'created_at' => $pelunasanDate,
                'updated_at' => $pelunasanDate,
            ]);
        }
    }
    
    /**
     * Create full payment
     */
    private function createFullPayment($booking, $paymentMethod, $paymentStatus, $paymentNumber)
    {
        Payment::create([
            'payment_number' => $paymentNumber,
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'payment_method' => $paymentMethod,
            'status' => $paymentStatus,
            'payment_proof' => $paymentStatus === 'paid' ? $this->generatePaymentProof($paymentMethod) : null,
            'paid_at' => $paymentStatus === 'paid' ? $booking->created_at->addDays(rand(0, 3)) : null,
            'notes' => 'Pembayaran lunas (Full Payment)',
            'created_at' => $booking->created_at,
            'updated_at' => $booking->created_at->addDays(rand(0, 3)),
        ]);
    }
    
    /**
     * Get DP percentage based on service price
     */
    private function getDpPercentage($totalPrice)
    {
        if ($totalPrice >= 800000) {
            return rand(30, 50) / 100; // 30-50% for premium services
        } elseif ($totalPrice >= 500000) {
            return rand(40, 60) / 100; // 40-60% for high-end services
        } elseif ($totalPrice >= 300000) {
            return rand(50, 70) / 100; // 50-70% for mid-range services
        } else {
            return rand(60, 80) / 100; // 60-80% for budget services
        }
    }
    
    /**
     * Get DP status based on booking status
     */
    private function getDpStatus($bookingStatus)
    {
        return match ($bookingStatus) {
            'completed' => 'paid',
            'confirmed' => rand(1, 100) <= 90 ? 'paid' : 'pending', // 90% paid
            'pending' => rand(1, 100) <= 60 ? 'paid' : 'pending', // 60% paid
            'cancelled' => rand(1, 100) <= 30 ? 'refunded' : 'failed', // 30% refunded
            default => 'pending'
        };
    }
    
    /**
     * Get pelunasan status based on booking status
     */
    private function getPelunasanStatus($bookingStatus)
    {
        return match ($bookingStatus) {
            'completed' => 'paid',
            'confirmed' => rand(1, 100) <= 70 ? 'paid' : 'pending', // 70% paid
            'pending' => 'pending',
            'cancelled' => 'failed',
            default => 'pending'
        };
    }
    
    private function generatePaymentProof($paymentMethod)
    {
        $proofs = [
            'cash' => [
                'Pembayaran tunai langsung',
                'Uang diterima langsung',
                'Cash payment received'
            ],
            'transfer' => [
                'Transfer BCA - Ref: ' . rand(1000000, 9999999),
                'Transfer BRI - Ref: ' . rand(1000000, 9999999),
                'Transfer BNI - Ref: ' . rand(1000000, 9999999),
                'Transfer Mandiri - Ref: ' . rand(1000000, 9999999)
            ],
            'ewallet' => [
                'OVO - Ref: ' . rand(1000000, 9999999),
                'GoPay - Ref: ' . rand(1000000, 9999999),
                'Dana - Ref: ' . rand(1000000, 9999999),
                'LinkAja - Ref: ' . rand(1000000, 9999999)
            ]
        ];
        
        return $proofs[$paymentMethod][array_rand($proofs[$paymentMethod])];
    }
    
    private function generatePaymentNotes($status, $method)
    {
        $notes = [
            'paid' => [
                'Pembayaran berhasil diterima',
                'Terima kasih atas pembayarannya',
                'Payment received successfully',
                'Lunas, terima kasih',
                'Pembayaran telah dikonfirmasi'
            ],
            'pending' => [
                'Menunggu konfirmasi pembayaran',
                'Sedang diproses',
                'Waiting for payment confirmation',
                'Mohon upload bukti pembayaran',
                'Pembayaran belum dikonfirmasi'
            ],
            'failed' => [
                'Pembayaran gagal',
                'Transfer tidak berhasil',
                'Payment failed',
                'Mohon coba lagi',
                'Pembayaran ditolak'
            ],
            'refunded' => [
                'Pembayaran telah dikembalikan',
                'Refund berhasil diproses',
                'Uang dikembalikan',
                'Pembatalan pembayaran',
                'Refund completed'
            ]
        ];
        
        return $notes[$status][array_rand($notes[$status])];
    }
}
