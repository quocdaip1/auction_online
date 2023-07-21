<?php

namespace Database\Factories;

use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
class UserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = UserInfo::class;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone'=> fake()->phoneNumber(),
            'address'=> fake()->address(),
            'created_at'=>now(),
            'updated_at'=>now(),  
        ];
    }
}
