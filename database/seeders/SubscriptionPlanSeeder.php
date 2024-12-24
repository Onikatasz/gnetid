<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'title' => 'Basic',
                'price' => 100000,
                'duration_days' => 30,
            ],
            [
                'title' => 'Premium',
                'price' => 200000,
                'duration_days' => 30,
            ],
            [
                'title' => 'Gold',
                'price' => 300000,
                'duration_days' => 30,
            ],
        ];

        foreach ($plans as $plan) {
            \App\Models\SubscriptionPlan::create($plan);
        }
    }
}
