<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if services already exist
        if (Service::count() > 0) {
            $this->command->info('Services already exist, skipping ServiceSeeder.');
            return;
        }
        
        // Create Service Categories (prevent duplicates)
        $indoor = ServiceCategory::updateOrCreate(
            ['name' => 'Indoor Photography'],
            [
                'description' => 'Sesi foto di dalam studio dengan pencahayaan profesional',
                'is_active' => true,
            ]
        );
        
        $outdoor = ServiceCategory::updateOrCreate(
            ['name' => 'Outdoor Photography'],
            [
                'description' => 'Sesi foto di lokasi outdoor dengan suasana natural',
                'is_active' => true,
            ]
        );

        // Indoor Services
        Service::create([
            'service_category_id' => $indoor->id,
            'name' => 'Portrait Studio',
            'description' => 'Foto portrait profesional dengan pencahayaan studio',
            'price' => 300000,
            'duration_minutes' => 60,
            'is_active' => true,
        ]);
        
        Service::create([
            'service_category_id' => $indoor->id,
            'name' => 'Family Photo Studio',
            'description' => 'Sesi foto keluarga di studio dengan berbagai background',
            'price' => 500000,
            'duration_minutes' => 90,
            'is_active' => true,
        ]);
        
        Service::create([
            'service_category_id' => $indoor->id,
            'name' => 'Product Photography',
            'description' => 'Foto produk untuk keperluan bisnis dan e-commerce',
            'price' => 400000,
            'duration_minutes' => 120,
            'is_active' => true,
        ]);

        // Outdoor Services
        Service::create([
            'service_category_id' => $outdoor->id,
            'name' => 'Pre-Wedding Outdoor',
            'description' => 'Sesi foto pre-wedding di lokasi outdoor yang indah',
            'price' => 800000,
            'duration_minutes' => 180,
            'is_active' => true,
        ]);
        
        Service::create([
            'service_category_id' => $outdoor->id,
            'name' => 'Graduation Outdoor',
            'description' => 'Foto wisuda di lokasi outdoor dengan background kampus',
            'price' => 350000,
            'duration_minutes' => 90,
            'is_active' => true,
        ]);
        
        Service::create([
            'service_category_id' => $outdoor->id,
            'name' => 'Family Outdoor Session',
            'description' => 'Sesi foto keluarga di taman atau lokasi outdoor lainnya',
            'price' => 600000,
            'duration_minutes' => 120,
            'is_active' => true,
        ]);
    }
}
