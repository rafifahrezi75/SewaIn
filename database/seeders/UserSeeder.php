<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'nama' => 'Admin SewaIn',
            'email' => 'admin@sewain.com',
            'notelp' => '081234567890',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'nama' => 'Owner SewaIn',
            'email' => 'owner@sewain.com',
            'notelp' => '081234567891',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'owner',
        ]);

        \App\Models\User::create([
            'nama' => 'Pelanggan 1',
            'email' => 'user@sewain.com',
            'notelp' => '081234567892',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
