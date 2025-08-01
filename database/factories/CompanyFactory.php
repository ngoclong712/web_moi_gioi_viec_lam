<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'address' => fake()->streetAddress(),
            'address2' => fake()->buildingNumber(),
            'district' => fake()->city(),
            'city' => fake()->city(),
            'country' => 'Vietnam',
            'zipcode' => fake()->postcode(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'logo' => fake()->imageUrl(),
        ];
    }
}
