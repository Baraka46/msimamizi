<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'company_id' => 1, // Ensure this matches a valid company ID in the companies table
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Admin',
                'email' => 'janeadmin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('adminpassword'),
                'role' => 'admin',
                'company_id' => 2,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sam Supervisor',
                'email' => 'samsupervisor@example.com',
                'email_verified_at' => null,
                'password' => Hash::make('supervisor123'),
                'role' => 'supervisor',
                'company_id' => 1,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
