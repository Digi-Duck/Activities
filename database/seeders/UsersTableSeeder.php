<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserRoleAdmin;
use App\Models\UserRolePresenter;
use App\Models\UserRoleStudent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => '管理',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            'user_role' => 1,
            'status' => 1,
        ]);
        User::create([
            'name' => '大講師',
            'email' => 'k5020420@gmail.com',
            'password' => '12345678',
            'user_role' => 2,
            'status' => 1,
        ]);
        User::create([
            'name' => '小學員',
            'email' => 'k5020420+123@gmail.com',
            'password' => '12345678',
            'user_role' => 3,
            'status' => 1,
        ]);
        UserRoleAdmin::create([
            'id' => 1,
            'user_id' => 1,
        ]);
        UserRolePresenter::create([
            'id' => 1,
            'user_id' => 2,
            'user_name' => '大講師',
            'phone_number' => '0987654321',
        ]);
        UserRoleStudent::create([
            'id' => 1,
            'user_id' => 3,
            'user_name' => '小學員',
            'phone_number' => '0987654321',
        ]);
    }
}
