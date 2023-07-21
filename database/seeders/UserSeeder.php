<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'email' => 'admin1@gmail.com',
            'password' => bcrypt('password'),
            'is_admin' => 1,
            'balance' => 999999,
            'blocked_balance' => 0,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('users')->insert($users);


        $user_info = [
            'name' => 'Phạm Quốc Đại',
            'address' => fake()->address(),
            'phone' => '0769870337',
            'avatar' => fake()->imageUrl(200, 200, 'people', true, 'Faker'),
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => 1
        ];

        $directoryPath = 'image/imageUsers/user_1';
        $fullPath = public_path($directoryPath);
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
        DB::table('user_info')->insert($user_info);


        User::factory()->count(100)->create();

        for ($i = 2; $i <= 101; $i++) {

            $directoryPath = 'image/imageUsers/user_' . $i;
            $fullPath = public_path($directoryPath);

            if (!File::exists($fullPath)) {
                File::makeDirectory($fullPath, 0755, true);
            }

            UserInfo::factory()->create([
                'user_id' => $i
            ]);
        }

    }
}