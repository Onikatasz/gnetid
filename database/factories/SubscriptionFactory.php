<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Hash;

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
        $day = 20;
    
        return [
            'client_id' => function() {
                // Ensure client_id is unique
                return Client::factory()->create()->id;
            },
            'subscription_plan_id' => function() {
                // Randomly assign a subscription plan from the existing plans
                return SubscriptionPlan::inRandomOrder()->first()->id;
            },
            'username' => $this->faker->unique()->email(),
            'password' => static::$password ??= Hash::make('password'),
            'start_date' => $this->faker->boolean(75) // 75% chance
                ? $this->faker->dateTimeBetween('+1 month', '+3 month') // From now to +1 month
                : $this->faker->dateTimeBetween('+1 months', endDate: '+3 month'), // From -3 months to +1 month
            'end_date' => function (array $attributes) use ($day) {
                $startDate = \Carbon\Carbon::parse($attributes['start_date']);
                if ($startDate->day > $day) {
                    $startDate->addMonthsNoOverflow(1);
                }
                $startDate->day(min($day, $startDate->daysInMonth));
                return $startDate;
            },
            'next_billing_date' => function (array $attributes) use ($day) {
                $date = \Carbon\Carbon::parse($attributes['end_date'])->addMonthsNoOverflow(1);
                $date->day(min($day, $date->daysInMonth));
                return $date;
            }
        ];
    }
    
    



}
