<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'title' => 'Welcome Beach Cleanup',
            'description' => 'Our first CSR initiative!',
            'location' => 'Casablanca Beach',
            'date' => now()->addDays(7),
            'points_reward' => 100,
            'status' => 'open',
        ]);
    }
}
