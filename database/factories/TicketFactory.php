<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Client Id random number between 1 and 100
            'client_id' => $this->faker->numberBetween(1, 100),
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
        ];
    }
}
