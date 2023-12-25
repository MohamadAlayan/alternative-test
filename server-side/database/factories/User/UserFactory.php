<?php

namespace Database\Factories\User;

use App\Enums\UserStatus;
use App\Helpers\AppHelper;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'uuid' => AppHelper::getUuid(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_dialing_number' => $this->faker->countryCode(),
            'phone_number' => $this->faker->phoneNumber(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'status' => UserStatus::ACTIVE,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
            'phone_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's email address should be verified.
     */
    public function verified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ]);
    }

    /**
     * Indicate type of user.
     */
    public function type(string $type): static
    {
        return $this->state(fn(array $attributes) => [
            'type' => $type,
        ]);
    }

}
