<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder ini HANYA FOKUS mengisi data.
        // (Pembersihan tabel/truncate akan diurus oleh DatabaseSeeder.php)

        $categories = [
            // --- Pemasukan (Income) ---
            ['name' => 'Modal Disetor (Owner)', 'type' => 'income'], // Masuk income karena menambah kas
            ['name' => 'Penjualan Makanan (Dine-in)', 'type' => 'income'],
            ['name' => 'Penjualan Minuman (Dine-in)', 'type' => 'income'],
            ['name' => 'Penjualan Online (GoFood/GrabFood)', 'type' => 'income'],
            ['name' => 'Penjualan Catering / Event', 'type' => 'income'],
            
            
            // --- Pengeluaran (Expense) ---
            ['name' => 'Bahan Baku - Daging & Ikan', 'type' => 'expense'],
            ['name' => 'Bahan Baku - Sayur & Buah', 'type' => 'expense'],
            ['name' => 'Bahan Baku - Bumbu & Kering', 'type' => 'expense'],
            ['name' => 'Bahan Baku - Minuman', 'type' => 'expense'],
            ['name' => 'Gaji Karyawan', 'type' => 'expense'], // Kita akan link ini ke Payroll
            ['name' => 'Sewa Tempat / Ruko', 'type' => 'expense'],
            ['name' => 'Listrik, Air, dan Gas', 'type' => 'expense'],
            ['name' => 'Kemasan / Packaging', 'type' => 'expense'],
            ['name' => 'Biaya Marketing', 'type' => 'expense'],
        ];

        // Masukkan data (created_at/updated_at akan otomatis terisi)
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'type' => $category['type'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}