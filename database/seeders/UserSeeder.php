<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        User::create([
            'name' => 'Admin Orgn',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'Zahra Organizer',
            'email' => 'zahra@gmail.com',
            'password' => Hash::make('zahra'),
            'role' => 'organizer'
        ]);
        User::create([
            'name' => 'Vantika Organizer',
            'email' => 'vantika@gmail.com',
            'password' => Hash::make('vantika'),
            'role' => 'organizer'
        ]);
    }
}
