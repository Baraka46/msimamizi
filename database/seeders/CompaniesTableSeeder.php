<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'name' => 'FastTrack Logistics',
                'address' => '123 Speedy Avenue, Dar es Salaam',
                'phone_number' => '255712345678',
                'email' => 'info@fasttrack.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CityLink Transport',
                'address' => '456 Main Street, Arusha',
                'phone_number' => '255765432109',
                'email' => 'contact@citylink.co.tz',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SafeRide Ventures',
                'address' => '789 Secure Road, Mwanza',
                'phone_number' => '255713987654',
                'email' => 'support@saferide.tz',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
