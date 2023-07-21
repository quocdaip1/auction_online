<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = User::class;
    public function definition(): array
    {
        $string = str_replace(' ','_',fake()->unique()->name());
        $email = str_replace('.','',$string);

        return [
            'email' => $email.'@gmail.com',
            'email_verified_at' => now(),
            'status' => rand(1,2),
            'balance' => 0,
            'blocked_balance' => 0,
            'is_admin' => rand(1,2),
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
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
}
