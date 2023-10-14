<?php

namespace Database\Seeders;

use App\Models\Statistic;
use App\Models\User;
use App\Models\UserRoleAdmin;
use App\Models\UserRolePresenter;
use App\Models\UserRoleStudent;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $randomDate = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
        User::create([
            'name' => '管理',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            'user_role' => 1,
            'status' => 1,
            'created_at' => $randomDate,
        ]);
        $randomDate = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
        User::create([
            'name' => '大講師',
            'email' => 'k5020420@gmail.com',
            'password' => '12345678',
            'user_role' => 2,
            'status' => 1,
            'created_at' => $randomDate,
        ]);
        $randomDate = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
        User::create([
            'name' => '小學員',
            'email' => 'k5020420+123@gmail.com',
            'password' => '12345678',
            'user_role' => 3,
            'status' => 1,
            'created_at' => $randomDate,
        ]);
        for ($i = 4; $i <= 200; $i++) {
            $randomDate = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'user_role' => 3,
                'password' => Hash::make('password' . $i),
                'status' => 1,
                'created_at' => $randomDate,
            ]);
        }
        for ($i = 201; $i <= 300; $i++) {
            $randomDate = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'user_role' => 2,
                'password' => Hash::make('password' . $i),
                'status' => 1,
                'created_at' => $randomDate,
            ]);
        }
        $randomDate = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
        UserRoleAdmin::create([
            'id' => 1,
            'user_id' => 1,
            'created_at' => $randomDate,
        ]);
        $randomDate = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
        UserRolePresenter::create([
            'id' => 1,
            'user_id' => 2,
            'user_name' => '大講師',
            'phone_number' => '0987654321',
            'created_at' => $randomDate,
        ]);
        $randomDate = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
        UserRoleStudent::create([
            'id' => 1,
            'user_id' => 3,
            'user_name' => '小學員',
            'phone_number' => '0987654321',
            'created_at' => $randomDate,
        ]);
        for ($i = 2; $i <= 198; $i++) {
            $randomDate = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
            UserRoleStudent::create([
                'id' => $i,
                'user_id' => $i+2,
                'user_name' => 'User ' . $i,
                'phone_number' => '0987654321',
                'created_at' => $randomDate,
            ]);
        }
        for ($i = 199; $i <= 298; $i++) {
            $randomDate = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
            UserRolePresenter::create([
                'id' => $i,
                'user_id' => $i+2,
                'user_name' => 'User ' . $i,
                'phone_number' => '0987654321',
                'created_at' => $randomDate,
            ]);
        }
        for ($i=1; $i <= 100000; $i++) { 
            $randomDate = Carbon::now()->subDays(rand(1, 60))->subHours(rand(1, 24))->subMinutes(rand(1, 60));
            Statistic::create([
                'id' => $i,
                'website_view' => 1,
                'created_at' => $randomDate,
            ]);
        }
    }
}
