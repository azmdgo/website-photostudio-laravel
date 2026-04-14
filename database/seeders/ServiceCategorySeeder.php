<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Indoor Photography',
                'description' => 'Layanan fotografi dalam ruangan seperti studio, wedding indoor, portrait, dan acara indoor lainnya.',
                'is_active' => true,
            ],
            [
                'name' => 'Outdoor Photography',
                'description' => 'Layanan fotografi luar ruangan seperti prewedding outdoor, family photo outdoor, dan event outdoor.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::updateOrCreate(
                ['name' => $category['name']], // Check by name
                $category // Update with these values
            );
        }

        $this->command->info('Service categories seeded successfully!');
    }
}
