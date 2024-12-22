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
        DB::table('cars')->insert([
            [
                'company_id' => 1, // Ensure this matches a valid company ID in the companies table
                'plate_number' => 'T123ABC',
                'model' => 'Toyota HiAce',
                'route' => 'Dar es Salaam - Morogoro',
                'daily_hesabu_target' => 50000.00,
                'assigned_supervisor_id' => 3, // Ensure this matches a valid supervisor ID in the users table
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 2,
                'plate_number' => 'T456DEF',
                'model' => 'Nissan Caravan',
                'route' => 'Arusha - Moshi',
                'daily_hesabu_target' => 70000.00,
                'assigned_supervisor_id' => null, // No supervisor assigned
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_id' => 3,
                'plate_number' => 'T789GHI',
                'model' => 'Ford Transit',
                'route' => 'Mbeya - Iringa',
                'daily_hesabu_target' => 60000.00,
                'assigned_supervisor_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
