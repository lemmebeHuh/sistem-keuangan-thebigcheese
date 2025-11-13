<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Database\Seeder;

class PayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Ambil semua ID karyawan yang aktif saja
        $activeEmployeeIds = Employee::where('is_active', true)->pluck('id');

        if ($activeEmployeeIds->isEmpty()) {
            $this->command->warn('Tidak ada Karyawan aktif untuk digaji.');
            return;
        }

        $payrolls = [];

        // Buat 3 data gaji palsu untuk setiap karyawan aktif
        foreach ($activeEmployeeIds as $employeeId) {
            for ($i = 0; $i < 3; $i++) {
                $payrolls[] = [
                    'employee_id' => $employeeId,
                    'amount' => $faker->numberBetween(2500000, 7000000), // Gaji
                    'payment_date' => $faker->dateTimeBetween('-3 months', 'now'),
                    'notes' => 'Gaji bulanan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Masukkan semua data gaji sekaligus
        Payroll::insert($payrolls);
    }
}