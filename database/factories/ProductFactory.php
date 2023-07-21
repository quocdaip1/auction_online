<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Product::class;
    public function definition(): array
    {
        return [
            'name'=>fake()->word(),
            'description' => fake()->paragraph(),
            'image'=>fake()->imageUrl(),
            'status'=> rand(1,2),
            'user_id' => User::inRandomOrder()->first()->id,
            'quanlity' => 3,
            'category_id' => function() {
                return Category::inRandomOrder()->first()->id;
            }
        ];
    }
}
