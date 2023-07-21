<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auction>
 */
class AuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Auction::class;
    public function definition(): array
    {

        $endDateTime = now()->addDays(7);
      
        return [
            'start_time' => now(),
            'end_time' => $endDateTime,
            'starting_price' => 2000,
            'status' => rand(1,2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}