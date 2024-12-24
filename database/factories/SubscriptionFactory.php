<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\SubscriptionPlan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => function() {
                // Ensure client_id is unique
                return Client::factory()->create()->id;
            },
            'subscription_plan_id' => function() {
                // Randomly assign a subscription plan from the existing plans
                return SubscriptionPlan::inRandomOrder()->first()->id;
            },
            'end_date' => $this->faker->boolean(75) // 75% chance
                ? $this->faker->dateTimeBetween('now', '+1 month') // From now to +1 month
                : $this->faker->dateTimeBetween('-3 months', '+1 month'), // From -3 months to +1 month
        ];
    }
}
