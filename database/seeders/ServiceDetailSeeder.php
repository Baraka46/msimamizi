<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ServiceDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Assuming you have services already seeded in the database
        $serviceIds = DB::table('services')->pluck('id')->toArray();

        // Create 10 sample entries for the service_details table
        foreach (range(1, 10) as $index) {
            DB::table('service_details')->insert([
                'service_id' => $faker->randomElement($serviceIds), // Random service_id from the services table
                'item_name' => $faker->word, // Random item name
                'description' => $faker->sentence, // Random description
                'cost' => $faker->randomFloat(2, 10, 500), // Random cost between 10 and 500
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
