<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if tables are empty before seeding
        if (DB::table('users')->count() == 0) {
            $this->call([
                UserSeeder::class,
            ]);
        }
        
        if (DB::table('service_categories')->count() == 0) {
            $this->call([
                ServiceCategorySeeder::class,
            ]);
        }
        
        if (DB::table('services')->count() == 0) {
            $this->call([
                ServiceSeeder::class,
            ]);
        }
        
        if (DB::table('bookings')->count() == 0) {
            $this->call([
                BookingSeeder::class,
            ]);
        }
        
        if (DB::table('payments')->count() == 0) {
            $this->call([
                PaymentSeeder::class,
            ]);
        }
        
        $this->command->info('🎉 Database seeded successfully with 3 business intelligence scenarios!');
        $this->command->info('📊 Scenario 1 (Loss): 12-8 months ago - High cancellation rate');
        $this->command->info('📊 Scenario 2 (Normal): 8-4 months ago - Balanced performance');
        $this->command->info('📊 Scenario 3 (Profit): 4 months ago to now - High completion rate');
        $this->command->info('👥 Total users: 50 (4 main + 46 dummy)');
        $this->command->info('📅 Total bookings: 170 across 3 scenarios in 12 months range');
    }
}
