<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'nico.gelabert@gmail.com',
            'password' => bcrypt('e2Zf87l6Ejjrsds'),
            'email_verified_at' => now(),
            'is_admin' => true
        ]);
    }
}
