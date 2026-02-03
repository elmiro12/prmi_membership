<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'tipeUser' => 'super_admin',
            'photo' => null,
        ]);
        
        User::create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'tipeUser' => 'member', // will need member profile, but for now just user
            'photo' => null,
        ]);
    }
}
