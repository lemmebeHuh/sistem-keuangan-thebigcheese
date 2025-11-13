<?php

namespace Database\Seeders;

use App\Models\Employee; // Gunakan model
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $employees = [
            [
                'name' => $faker->name('male'),
                'position' => 'Koki Kepala (Head Chef)',
                'joined_date' => $faker->dateTimeBetween('-3 years', '-1 year'),
                'is_active' => true,
            ],
            [
                'name' => $faker->name('female'),
                'position' => 'Kasir (Cashier)',
                'joined_date' => $faker->dateTimeBetween('-1 year', '-6 months'),
                'is_active' => true,
            ],
            [
                'name' => $faker->name('male'),
                'position' => 'Pramusaji (Waiter)',
                'joined_date' => $faker->dateTimeBetween('-6 months', '-1 month'),
                'is_active' => true,
            ],
            [
                'name' => $faker->name('female'),
                'position' => 'Admin Gudang',
                'joined_date' => $faker->dateTimeBetween('-2 years', '-1 year'),
                'is_active' => false, // Contoh karyawan non-aktif
            ],
        ];

        foreach ($employees as $emp) {
            Employee::create($emp); // create() akan mengisi timestamp otomatis
        }
    }
}