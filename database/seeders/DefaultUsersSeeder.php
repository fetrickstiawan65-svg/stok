<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultUsersSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'owner@demo.test'],
            ['name' => 'Owner Demo', 'password' => Hash::make('Password!123'), 'role' => 'owner']
        );

        User::updateOrCreate(
            ['email' => 'admin@demo.test'],
            ['name' => 'Admin Demo', 'password' => Hash::make('Password!123'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'kasir@demo.test'],
            ['name' => 'Kasir Demo', 'password' => Hash::make('Password!123'), 'role' => 'cashier']
        );
    }
}
