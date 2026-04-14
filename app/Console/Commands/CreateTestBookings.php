<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;

class CreateTestBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test bookings for today to test availability system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating test bookings...');
        
        // Get first user and service
        $user = User::where('role', 'customer')->first();
        $service = Service::first();
        
        if (!$user || !$service) {
            $this->error('Please create users and services first!');
            return 1;
        }
        
        // Create bookings for today at specific times
        $today = Carbon::today()->addDays(1); // Tomorrow to avoid past date validation
        
        $testBookings = [
            [
                'time' => '09:00',
                'name' => 'Test Customer 1',
                'phone' => '081234567890',
                'email' => 'test1@example.com'
            ],
            [
                'time' => '11:00',
                'name' => 'Test Customer 2', 
                'phone' => '081234567891',
                'email' => 'test2@example.com'
            ],
            [
                'time' => '15:00',
                'name' => 'Test Customer 3',
                'phone' => '081234567892', 
                'email' => 'test3@example.com'
            ]
        ];
        
        foreach ($testBookings as $bookingData) {
            // Check if booking already exists
            $existingBooking = Booking::where('booking_date', $today->toDateString())
                                     ->where('booking_time', $bookingData['time'])
                                     ->first();
            
            if ($existingBooking) {
                $this->line("Booking for {$bookingData['time']} already exists, skipping...");
                continue;
            }
            
            Booking::create([
                'user_id' => $user->id,
                'service_id' => $service->id,
                'booking_date' => $today->toDateString(),
                'booking_time' => $bookingData['time'],
                'customer_name' => $bookingData['name'],
                'customer_phone' => $bookingData['phone'],
                'customer_email' => $bookingData['email'],
                'total_price' => $service->price,
                'payment_type' => 'full',
                'status' => 'confirmed',
                'notes' => 'Test booking for availability system'
            ]);
            
            $this->info("Created test booking for {$bookingData['time']} - {$bookingData['name']}");
        }
        
        $this->info("Test bookings created for date: {$today->toDateString()}");
        $this->info('You can now test the availability system on the booking form!');
        
        return 0;
    }
}
