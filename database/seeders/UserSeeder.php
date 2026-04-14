<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if users already exist
        if (User::count() > 0) {
            $this->command->info('Users already exist, skipping UserSeeder.');
            return;
        }
        
        // Main users as requested
        $mainUsers = [
            ['name' => 'Admin Yujin Studio', 'email' => 'admin@gmail.com', 'role' => 'admin', 'password' => Hash::make('password'), 'phone' => '081234567890', 'is_active' => true],
            ['name' => 'Pelanggan Demo', 'email' => 'pelanggan@gmail.com', 'role' => 'customer', 'password' => Hash::make('password'), 'phone' => '082345678901', 'is_active' => true],
            ['name' => 'Petugas Studio', 'email' => 'petugastudio@gmail.com', 'role' => 'studio_staff', 'password' => Hash::make('password'), 'phone' => '083456789012', 'is_active' => true],
            ['name' => 'Pemilik Usaha', 'email' => 'pemilikusaha@gmail.com', 'role' => 'owner', 'password' => Hash::make('password'), 'phone' => '084567890123', 'is_active' => true],
        ];

        foreach ($mainUsers as $user) {
            User::create($user);
        }

        // Create additional dummy users with Indonesian names
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
            'Gilang Ramadhan', 'Citra Kirana', 'Andi Susanto', 'Evi Novianti'
        ];
        
        $roles = ['customer', 'customer', 'customer', 'customer', 'studio_staff', 'admin'];
        
        $usedEmails = ['admin@gmail.com', 'pelanggan@gmail.com', 'petugastudio@gmail.com', 'pemilikusaha@gmail.com'];
        
        for ($i = 0; $i < 46; $i++) {
            $name = $indonesianNames[$i % count($indonesianNames)];
            $role = $roles[array_rand($roles)];
            $phone = '08' . rand(1, 9) . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT);
            
            // Generate unique email
            $baseEmail = strtolower(str_replace(' ', '.', $name));
            $email = $baseEmail . ($i + 1) . '@gmail.com';
            
            // Ensure email is unique
            $counter = 1;
            while (in_array($email, $usedEmails)) {
                $email = $baseEmail . ($i + 1) . '.' . $counter . '@gmail.com';
                $counter++;
            }
            $usedEmails[] = $email;
            
            User::create([
                'name' => $name . ' ' . ($i + 1), // Make names unique too
                'email' => $email,
                'role' => $role,
                'password' => Hash::make('password'),
                'phone' => $phone,
                'is_active' => rand(0, 10) > 1, // 90% active, 10% inactive
                'email_verified_at' => now(),
                'created_at' => now()->subDays(rand(30, 365)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}

