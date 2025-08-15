<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat pengguna default
        DB::table('users')->insert([
            'name' => 'Owner Bigcheese',
            'email' => 'admin@thebigcheese.com',
            'password' => Hash::make('123'), // Ganti 'password' dengan password yang aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}