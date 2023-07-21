<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_id = 1;
        $user_id_product = Product::pluck('user_id')->all();
        $user_id_index = 0;

        Auction::factory()->count(100)->state(function (array $attributes) use (&$product_id,&$user_id_index,&$user_id_product) {

            $user_id = $user_id_product[$user_id_index];

            $user_id_index++;
            return [
                'product_id' => $product_id++,
                'user_id' => $user_id
            ];
        })->create();
    }
}
