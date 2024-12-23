<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->unique()->phoneNumber(),
            'nik' => $this->generateNik(),
            'is_subscribe' => $this->faker->boolean(),
        ];
    }

    /**
     * Generate a 16-digit NIK without dashes.
     *
     * @return string
     */
    private function generateNik(): string
    {
        // Generate a 16-digit random number (numerify ensures it's a 16-digit number)
        return $this->faker->numerify('################');
    }
}
