<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Create the default admin user.
     * Uses firstOrCreate so it is safe to run multiple times.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'ranaimranali3310@gmail.com'],
            [
                'name'     => 'IMRAN ALI',
                'password' => Hash::make('@12345678'),
                'role'     => 'admin',
            ]
        );

        $this->command->info('Admin seeded: ranaimranali3310@gmail.com / @12345678');
    }
}
