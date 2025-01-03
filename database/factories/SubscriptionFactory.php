<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

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

    protected static $password;

    // Schema
    // subscriptions {
    //     id int pk
    //     client_id int fk
    //     subscription_plan_id int fk
    //     username varchar unique
    //     password varchar
    //     start_date date
    //     end_date date
    //   }

    public function definition(): array
    {
        return [
            // ID with 11 digits number
            'id' => $this->faker->unique()->numberBetween(10000000000, 99999999999),
    
            // Unique client_id
            'client_id' => function() {
                return Client::factory()->create()->id;
            },
    
            // Subscription plan
            'subscription_plan_id' => function() {
                return SubscriptionPlan::inRandomOrder()->first()->id;
            },
    
            // Username combines id and domain
            'username' => function (array $attributes) {
                return $attributes['id'] . '@netgpusat.com';
            },
    
            // Random hashed password
            'password' => Crypt::encryptString(
                $this->faker->regexify('[A-Za-z0-9!@#$%^&*()_+]{8,8}')
            ),
    
            // Start Date
            'start_date' => $this->faker->dateTimeBetween('-1 months', '+3 months')->format('Y-m-d'),
    
            // End Date (same day next month)
            'end_date' => function (array $attributes) {
                return \Carbon\Carbon::parse($attributes['start_date'])->addMonthNoOverflow()->format('Y-m-d');
            },
        ];
    }
}
