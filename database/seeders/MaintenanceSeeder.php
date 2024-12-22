<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Assuming you have cars already seeded in the database
        $carIds = DB::table('cars')->pluck('id')->toArray();

        // Create 10 sample entries for the maintenance table
        foreach (range(1, 10) as $index) {
            DB::table('maintenance')->insert([
                'car_id' => $faker->randomElement($carIds), // Random car_id from the cars table
                'expense_name' => $faker->word, // Random expense name
                'cost' => $faker->randomFloat(2, 50, 1000), // Cost between 50 and 1000
                'description' => $faker->sentence, // Random description
                'date' => $faker->date(), // Random date
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
