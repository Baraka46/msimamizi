<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DailyHesabuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Assuming you have cars and users already seeded in the database
        $carIds = DB::table('cars')->pluck('id')->toArray();
        $supervisorIds = DB::table('users')->pluck('id')->toArray();

        // Create 10 sample entries for the daily_hesabu table
        foreach (range(1, 10) as $index) {
            DB::table('daily_hesabu')->insert([
                'car_id' => $faker->randomElement($carIds),
                'supervisor_id' => $faker->randomElement($supervisorIds),
                'amount' => $faker->randomFloat(2, 50, 1000), // Amount between 50 and 1000
                'collection_time' => $faker->dateTimeThisYear, // Collection time this year
                'description' => $faker->sentence, // Random description
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
