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

        // 2. Kosongkan tabel (Truncate) DARI ANAK KE INDUK
        // Kita TIDAK menyentuh 'users'
        DB::table('payrolls')->truncate();
        DB::table('transactions')->truncate();
        // ---
        DB::table('employees')->truncate();
        DB::table('categories')->truncate();

        // 3. Nyalakan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();

        // 4. Panggil seeder DARI INDUK KE ANAK
        $this->call([
            // Induk:
            CategorySeeder::class,
            EmployeeSeeder::class,
            // (UserSeeder tidak dipanggil)

            // Anak:
            PayrollSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}