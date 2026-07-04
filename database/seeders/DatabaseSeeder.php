<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            PaymentSeeder::class,
            ContactMessageSeeder::class,
            CartSeeder::class,
        ]);
    }
}
