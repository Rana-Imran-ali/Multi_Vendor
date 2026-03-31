<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'IMRAN ALI',
            'email' => 'ranaimranali3310@gmail.com',
            'password' => bcrypt('@12345678'),
            'role' => 'admin'
        ]);
    }
}
