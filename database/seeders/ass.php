<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Matikan pengecekan foreign key
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel. HARUS DARI ANAK KE INDUK.
        DB::table('transactions')->truncate(); // <-- Anak
        DB::table('categories')->truncate();   // <-- Induk
        DB::table('users')->truncate();        // <-- Induk

        // (Jika ada tabel 'password_resets' dll, bisa di-truncate juga)
        // DB::table('password_reset_tokens')->truncate();

        // 3. Nyalakan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();

        // 4. Panggil seeder. HARUS DARI INDUK KE ANAK.
        $this->call([
            UserSeeder::class,        // <-- Induk (dibuat dulu)
            CategorySeeder::class,    // <-- Induk (dibuat dulu)
            TransactionSeeder::class, // <-- Anak (dibuat terakhir)
        ]);
    }
}