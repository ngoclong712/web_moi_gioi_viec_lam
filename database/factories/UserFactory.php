<?php

namespace Database\Factories;

use App\Enums\UserRoleEnum;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(). " ". fake()->lastName(),
            'avatar' => fake()->imageUrl(),
            'email' => fake()->email(),
            'password' => fake()->password(),
            'phone' => fake()->phoneNumber(),
            'link' => null,
            'role' => fake()->randomElement(UserRoleEnum::getValues()),
            'bio' => fake()->boolean() ? fake()->text() : null,
            'position' => fake()->jobTitle(),
            'gender' => fake()->boolean(),
            'city' => fake()->city(),
            'company_id' => Company::query()->value('id'),
        ];
    }
}
