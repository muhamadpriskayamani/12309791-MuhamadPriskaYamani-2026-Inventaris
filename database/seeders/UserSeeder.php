<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'), 
        ]);

        User::create([
            'name' => 'Staff User',
            'email' => 'staff@gmail.com',
            'role' => 'staff',
            'password' => Hash::make('password'), 
        ]);
    }
}