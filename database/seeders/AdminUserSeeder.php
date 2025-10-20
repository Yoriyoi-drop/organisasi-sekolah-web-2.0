<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@manu.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'm.fajarramadhani00@gmail.com'],
            [
                'name' => 'administrator',
                'password' => Hash::make('admin321'),
                'is_admin' => true,
            ]
        );
    }
}
