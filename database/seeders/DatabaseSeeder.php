<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'Admin',
        ]);

        $this->call([
            UserSeeder::class,
            SubscriptionPlanSeeder::class,
            SubscriptionSeeder::class,
            TicketSeeder::class,
        ]);
    }
}
