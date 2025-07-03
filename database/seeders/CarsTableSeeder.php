<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $now = now();
    $cars = [];

    // Generate 7 cars with supervisor_id = 3
    for ($i = 1; $i <= 7; $i++) {
        $cars[] = [
            'company_id' => 1,
            'plate_number' => 'T' . rand(100, 999) . chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)),
            'model' => 'Toyota HiAce',
            'route' => 'Dar es Salaam - Morogoro',
            'daily_hesabu_target' => 50000.00,
            'assigned_supervisor_id' => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    // Generate 13 cars with supervisor_id = null
    for ($i = 1; $i <= 13; $i++) {
        $cars[] = [
            'company_id' => 1,
            'plate_number' => 'T' . rand(100, 999) . chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)),
            'model' => 'Nissan Caravan',
            'route' => 'Dar es Salaam - Morogoro',
            'daily_hesabu_target' => 50000.00,
            'assigned_supervisor_id' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    DB::table('cars')->insert($cars);
}

}
