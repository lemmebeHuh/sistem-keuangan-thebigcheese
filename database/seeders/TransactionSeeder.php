<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil ID dari data yang ADA
        $userIds = User::pluck('id'); // <-- Mengambil user ID yang SUDAH ADA
        $incomeCategoryIds = Category::where('type', 'income')->pluck('id');
        $expenseCategoryIds = Category::where('type', 'expense')->pluck('id');

        // Safety check
        if ($userIds->isEmpty()) {
            $this->command->error('Tidak ada User di database. Harap isi data user terlebih dahulu.');
            return;
        }
        if ($incomeCategoryIds->isEmpty() || $expenseCategoryIds->isEmpty()) {
            $this->command->warn('Tidak ada Kategori income/expense. Seeding transaksi mungkin tidak lengkap.');
        }

        $transactions = [];
        $faker = \Faker\Factory::create('id_ID');

        // 2. Buat 150 data transaksi dummy
        for ($i = 0; $i < 150; $i++) {
            $isExpense = rand(1, 10) <= 8; // 80% pengeluaran, 20% pemasukan
            
            $categoryId = null;
            $amount = 0;
            $description = '';

            if ($isExpense && !$expenseCategoryIds->isEmpty()) {
                $categoryId = $expenseCategoryIds->random();
                $amount = $faker->numberBetween(20000, 300000);
                $description = 'Biaya operasional ' . $faker->word();
            } elseif (!$isExpense && !$incomeCategoryIds->isEmpty()) {
                $categoryId = $incomeCategoryIds->random();
                $amount = $faker->numberBetween(100000, 2000000);
                $description = 'Penjualan ' . $faker->word();
            }

            if (!$categoryId) continue;

            $transactions[] = [
                'user_id' => $userIds->random(), // Ambil user ID acak DARI YANG ADA
                'category_id' => $categoryId,
                'amount' => $amount,
                'description' => $description,
                'transaction_date' => $faker->dateTimeBetween('-90 days', 'now'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 3. Masukkan semua data ke DB
        DB::table('transactions')->insert($transactions);
    }
}