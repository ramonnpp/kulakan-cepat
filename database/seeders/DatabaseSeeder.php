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
        // Panggil seeder utama yang berisi semua logika pembuatan data
        $this->call(DummyDataSeeder::class);
    }
}
