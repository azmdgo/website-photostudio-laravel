<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    private static $counter = 1;
    private $usedEmails = [];
    private $bookingCounter = 1;
    private static $usedBookingNumbers = [];
    
    public function run(): void
    {
        // Reset counter to ensure uniqueness
        self::$counter = 1;
        self::$usedBookingNumbers = [];
        
        // Check if bookings already exist
        if (Booking::count() > 0) {
            $this->command->info('Bookings already exist, skipping BookingSeeder.');
            return;
        }
        
        $users = User::where('role', 'customer')->get();
        $services = Service::all();
        
        // Indonesian names for realistic data
        $indonesianNames = [
            'Budi Santoso', 'Siti Nurhaliza', 'Ahmad Fauzi', 'Dewi Sartika',
            'Rudi Hermawan', 'Ratna Sari', 'Agus Salim', 'Maya Widya',
            'Hendra Wijaya', 'Indira Putri', 'Yanto Supriyadi', 'Lestari Wati',
            'Bambang Purnomo', 'Kartika Sari', 'Dedi Kurniawan', 'Anita Rahmawati',
            'Teguh Prasetyo', 'Endah Sulistyowati', 'Arif Rahman', 'Sari Dewi',
            'Joko Widodo', 'Mega Sari', 'Wawan Setiawan', 'Tri Handayani',
            'Surya Pratama', 'Fitri Handayani', 'Eko Prasetyo', 'Rina Susanti',
            'Dody Pranata', 'Winda Puspita', 'Cahyo Nugroho', 'Dian Permata',
            'Hendro Susilo', 'Lilis Suryani', 'Gunawan Setiadi', 'Novi Andriani',
            'Rinto Hakim', 'Siska Meilani', 'Yudha Pratama', 'Elsa Ramadhani',
            'Fajar Sidik', 'Tuti Alawiyah', 'Irvan Maulana', 'Dina Mariana',
            'Bayu Aji', 'Riska Amelia', 'Wahyu Hidayat', 'Puspita Sari',
            'Gilang Ramadhan', 'Citra Kirana'
        ];
        
        $phones = [
            '081234567890', '082345678901', '083456789012', '084567890123',
            '085678901234', '086789012345', '087890123456', '088901234567',
            '089012345678', '081123456789', '082234567890', '083345678901',
            '084456789012', '085567890123', '086678901234', '087789012345',
            '088890123456', '089901234567', '081345678901', '082456789012',
            '083567890123', '084678901234', '085789012345', '086890123456',
            '087901234567', '088012345678', '089123456789', '081456789012',
            '082567890123', '083678901234', '084789012345', '085890123456',
            '086901234567', '087012345678', '088123456789', '089234567890',
            '081567890123', '082678901234', '083789012345', '084890123456',
            '085901234567', '086012345678', '087123456789', '088234567890',
            '089345678901', '081678901234', '082789012345', '083890123456',
            '084901234567', '085012345678'
        ];
        
        // Initialize used emails to prevent duplicates
        $this->usedEmails = [];
        
        // Create all bookings in one go to prevent duplicates
        $this->createAllBookings($users, $services, $indonesianNames, $phones);
    }
    
    private function createAllBookings($users, $services, $indonesianNames, $phones)
    {
        // Scenario 1: Loss (Kerugian) - 12 months ago to 8 months ago (40 bookings)
        for ($i = 0; $i < 40; $i++) {
            $this->createBooking($users, $services, $indonesianNames, $phones, 'loss', $i);
        }
        
        // Scenario 2: Normal - 8 months ago to 4 months ago (50 bookings)
        for ($i = 0; $i < 50; $i++) {
            $this->createBooking($users, $services, $indonesianNames, $phones, 'normal', $i);
        }
        
        // Scenario 3: Profit (Keuntungan) - 4 months ago to now (50 bookings)
        for ($i = 0; $i < 50; $i++) {
            $this->createBooking($users, $services, $indonesianNames, $phones, 'profit', $i);
        }
    }
    
    private function createBooking($users, $services, $indonesianNames, $phones, $scenario, $index)
    {
        $user = $users->random();
        $service = $services->random();
        
        // Set date range and status based on scenario
        switch ($scenario) {
            case 'loss':
$startDate = Carbon::now()->subMonths(12);
                $endDate = Carbon::now()->subMonths(8);
                $statusWeights = [
                    'cancelled' => 40,    // 40% cancelled
                    'completed' => 30,    // 30% completed
                    'pending' => 20,      // 20% pending
                    'confirmed' => 10     // 10% confirmed
                ];
                $priceMultiplier = 1 - rand(0, 30) / 100; // Discount 0-30%
                break;
                
            case 'normal':
$startDate = Carbon::now()->subMonths(8);
                $endDate = Carbon::now()->subMonths(4);
                $statusWeights = [
                    'pending' => 40,      // 40% pending
                    'confirmed' => 30,    // 30% confirmed
                    'completed' => 20,    // 20% completed
                    'cancelled' => 10     // 10% cancelled
                ];
                $priceMultiplier = 1 - rand(0, 15) / 100; // Discount 0-15%
                break;
                
            case 'profit':
$startDate = Carbon::now()->subMonths(4);
                $endDate = Carbon::now();
                $statusWeights = [
                    'completed' => 60,    // 60% completed (PROFIT!)
                    'confirmed' => 25,    // 25% confirmed
                    'pending' => 10,      // 10% pending
                    'cancelled' => 5      // 5% cancelled
                ];
                $priceMultiplier = 1 + rand(0, 10) / 100; // Premium 0-10%
                break;
        }
        
        $bookingDate = $startDate->copy()->addDays(rand(0, $startDate->diffInDays($endDate)));
        $status = $this->weightedRandomStatus($statusWeights);
        
        Booking::create([
            'booking_number' => $this->generateUniqueBookingNumber(),
            'user_id' => $user->id,
            'service_id' => $service->id,
            'booking_date' => $bookingDate->toDateString(),
            'booking_time' => $this->randomTime(),
            'customer_name' => $indonesianNames[array_rand($indonesianNames)],
            'customer_phone' => $phones[array_rand($phones)],
            'customer_email' => $this->generateUniqueEmail($indonesianNames),
            'total_price' => $service->price * $priceMultiplier,
            'status' => $status,
            'notes' => $this->generateNotes($status),
            'created_at' => $bookingDate,
            'updated_at' => $bookingDate,
        ]);
        
        // Small delay to ensure uniqueness
        usleep(1000);
    }
    
    
    private function weightedRandomStatus($weights)
    {
        $total = array_sum($weights);
        $random = rand(1, $total);
        
        $current = 0;
        foreach ($weights as $status => $weight) {
            $current += $weight;
            if ($random <= $current) {
                return $status;
            }
        }
        
        return array_key_first($weights);
    }
    
    private function randomTime()
    {
        $hours = [9, 10, 11, 13, 14, 15, 16, 17];
        $minutes = [0, 30];
        
        return sprintf('%02d:%02d:00', $hours[array_rand($hours)], $minutes[array_rand($minutes)]);
    }
    
    private function generateNotes($status)
    {
        $notes = [
            'completed' => [
                'Sesi foto berjalan lancar',
                'Klien sangat puas dengan hasil',
                'Lokasi sesuai ekspektasi',
                'Hasil foto akan dikirim dalam 3 hari',
                'Terima kasih atas kepercayaannya'
            ],
            'cancelled' => [
                'Dibatalkan karena cuaca buruk',
                'Klien berhalangan hadir',
                'Permintaan reschedule',
                'Tidak cocok dengan jadwal',
                'Pembatalan mendadak'
            ],
            'pending' => [
                'Menunggu konfirmasi jadwal',
                'Menunggu pembayaran DP',
                'Sedang koordinasi lokasi',
                'Menunggu persetujuan klien',
                'Dalam proses verifikasi'
            ],
            'confirmed' => [
                'Jadwal sudah dikonfirmasi',
                'DP sudah diterima',
                'Lokasi sudah disepakati',
                'Siap untuk pelaksanaan',
                'Sudah koordinasi dengan klien'
            ]
        ];
        
        return $notes[$status][array_rand($notes[$status])];
    }
    
    private function generateUniqueEmail($indonesianNames)
    {
        $attempts = 0;
        do {
            $name = $indonesianNames[array_rand($indonesianNames)];
            $baseEmail = strtolower(str_replace(' ', '.', $name));
            $email = $baseEmail . ($attempts > 0 ? $attempts : '') . '@gmail.com';
            $attempts++;
        } while (in_array($email, $this->usedEmails) && $attempts < 100);
        
        $this->usedEmails[] = $email;
        return $email;
    }
    
    private function generateUniqueBookingNumber()
    {
        // Use microtime for guaranteed uniqueness
        $microtime = str_replace('.', '', microtime(true));
        $number = 'BK' . date('Ymd') . substr($microtime, -6);
        
        // Ensure uniqueness by checking against used numbers
        while (in_array($number, self::$usedBookingNumbers)) {
            usleep(1000); // Wait 1ms
            $microtime = str_replace('.', '', microtime(true));
            $number = 'BK' . date('Ymd') . substr($microtime, -6);
        }
        
        self::$usedBookingNumbers[] = $number;
        return $number;
    }
}
