<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@localhost',
            'password' => bcrypt('<PASSWORD>'),
            'password_salt' => bcrypt('<PASSWORD_SALT'),
            'last_login' => null,
            'account_typ' => 'admin',
            'activated' => true,
            'blocked' => false,
            'email_verified_at' => "2025-01-01 00:00:00",
        ]);
    }
}
