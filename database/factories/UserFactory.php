<?php

namespace Database\Factories;

use App\Enums\GenderEnum;
use App\Enums\UserStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'gender' => GenderEnum::MALE->value,
            'nationality' => fake()->country(),
            'primary_lang' => 'English',
            'other_lang' => ['Other'],
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'is_admin' => false,
            'status' => UserStatusEnum::ACTIVE->value
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is an Admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_admin' => true,
        ]);
    }

    /**
     * Indicate that the user is enrolled to Newsletter
     */
    public function newsletter(): static
    {
        return $this->state(fn (array $attributes) => [
            'newsletter' => true,
        ]);
    }

    /**
     * Indicate that the user status is Pending
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatusEnum::PENDING->value,
        ]);
    }

    /**
     * Indicate that the user status is Inactive
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatusEnum::INACTIVE->value,
        ]);
    }

    /**
     * Indicate that the user status is Blocked
     */
    public function blocked(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => UserStatusEnum::BLOCKED->value,
        ]);
    }
}
