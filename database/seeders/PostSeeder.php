<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\QueryException;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $categories = [];

            $categoriesName = ['Digital Art', 'Music', 'Motor Bike', 'Game Pad', 'Real estate', 'Collectibles'];
            for ($i = 0; $i < 6; $i++) {
                $categories[] = [
                    'name' => $categoriesName[$i],
                    'status' => 1,
                    'user_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('categories')->insert($categories);

            for ($i = 1; $i < 6; $i++) {
                $directoryPath = 'image/imageCategories/category_' . $i;
                $fullPath = public_path($directoryPath);
            
                if (!File::exists($fullPath)) {
                    File::makeDirectory($fullPath, 0755, true);
                }
            }


            // $products = [
            //     [
            //         'name' => "KTM DUKE 1290R EVO 2023 ",
            //         'description' => 'none',
            //         'image' => "ktmduke1290.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 1
            //     ],

            //     [
            //         'name' => "Yamaha R1",
            //         'description' => 'none',
            //         'image' => "yamahar1.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 1
            //     ],
            //     [
            //         'name' => "Ninja h2",
            //         'description' => 'none',
            //         'image' => "ninjah2.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 1
            //     ],

            //     [
            //         'name' => "Honda cbr",
            //         'description' => 'none',
            //         'image' => "hondacbr.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 1
            //     ],

            //     [
            //         'name' => "Bmw s1000rr",
            //         'description' => 'none',
            //         'image' => "bmws1000rr.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 1
            //     ],

            //     [
            //         'name' => "Iphone 14 pro max",
            //         'description' => 'none',
            //         'image' => "iphone14promax.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 4
            //     ],


            //     [
            //         'name' => "Samsung S23utra",
            //         'description' => 'none',
            //         'image' => "s23utra.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 4
            //     ],


            //     [
            //         'name' => "xiaomi",
            //         'description' => 'none',
            //         'image' => "xiaomi.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 4
            //     ],

            //     [
            //         'name' => "Samsung Z-fold",
            //         'description' => 'none',
            //         'image' => "z-fold.png.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 4
            //     ],


            //     [
            //         'name' => "ring gold",
            //         'description' => 'none',
            //         'image' => "ring1.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 2
            //     ],

            //     [
            //         'name' => "ring gold",
            //         'description' => 'none',
            //         'image' => "ring2.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 2
            //     ],

            //     [
            //         'name' => "ring gold",
            //         'description' => 'none',
            //         'image' => "ring3.png",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 2
            //     ],

            //     [
            //         'name' => "Vintage Rolex",
            //         'description' => 'none',
            //         'image' => "watches1.jpg",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 3
            //     ],


            //     [
            //         'name' => "Lady's Vintage Rolex Datejust",
            //         'description' => 'none',
            //         'image' => "watches2.jpg",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 3
            //     ],
            //     [
            //         'name' => "Lady's Retro Diamond",
            //         'description' => 'none',
            //         'image' => "watches3.jpg",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 3
            //     ],

            //     [
            //         'name' => "Coin gold 120 years england",
            //         'description' => 'none',
            //         'image' => "coin1.jpg",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 7
            //     ],

            //     [
            //         'name' => "Coin gold 2000 years roman",
            //         'description' => 'none',
            //         'image' => "coin2.jpg",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 7
            //     ],

            //     [
            //         'name' => "Coin gold Aureus",
            //         'description' => 'none',
            //         'image' => "coin3.jpg",
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'status' => 2,
            //         'user_id' => 1,
            //         'category_id' => 7
            //     ],

            // ];
            // DB::table('products')->insert($products);
            // $auctions = [];

            // for ($i = 1; $i < 19; $i++) {
            //     $auctions[] = [
            //         'start_time' => '2023-04-13 14:00:00',
            //         'end_time' => '2025-04-13 14:00:00',
            //         'starting_price' => $i . '0000',
            //         'status' => 2,
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //         'user_id' => 1,
            //         'product_id' => $i,
            //     ];
            // }

            // DB::table('auctions')->insert($auctions);
        } catch (QueryException $e) {
            echo 'Seeder Error' . $e->getMessage();
        }

    }
}