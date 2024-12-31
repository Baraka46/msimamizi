<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ServiceSeeder extends Seeder
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

        // Create 10 sample entries for the services table
        foreach (range(1, 10) as $index) {
            DB::table('services')->insert([
                'car_id' => $faker->randomElement($carIds), // Random car_id from the cars table
                'service_type' => $faker->randomElement(['oil', 'tires', 'engine', 'balljoint']), // Random service type
                'cost' => $faker->randomFloat(2, 50, 1000), // Random cost between 50 and 1000
                'date_performed' => $faker->date(), // Random date for when the service was performed
                'next_due_date' => $faker->optional()->date(), // Random next due date, may be null
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
