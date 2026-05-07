<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. ADMIN
        User::updateOrCreate(
            ['email' => 'admin@plaju.go.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. OPERATOR
        User::updateOrCreate(
            ['email' => 'operator@plaju.go.id'],
            [
                'name' => 'Operator Plaju',
                'password' => Hash::make('password'),
                'role' => 'operator',
            ]
        );

        // 3. CAMAT
        User::updateOrCreate(
            ['email' => 'camat@plaju.go.id'],
            [
                'name' => 'Camat Plaju',
                'password' => Hash::make('password'),
                'role' => 'camat',
            ]
        );
    }
}
