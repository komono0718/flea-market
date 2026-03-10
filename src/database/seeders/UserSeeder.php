<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ログイン用ユーザー（ID=1になる）
        User::create([
            'name' => 'ログインユーザー',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
        ]);

        // 出品者ユーザー（ID=2になる）
        User::create([
            'name' => '出品者ユーザー',
            'email' => 'seller@test.com',
            'password' => Hash::make('password'),
        ]);
    }
}
