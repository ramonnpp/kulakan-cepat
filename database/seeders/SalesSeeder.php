<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sales;
use Illuminate\Support\Facades\Hash;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sales::create([
            'name' => 'Sales Satu',
            'email' => 'sales@example.com',
            'no_phone' => '081234567890',
            'password' => 'password', // Password akan di-hash oleh model Sales
            'target_sales' => 50000000,
            'wilayah' => 'Jakarta',
            'status' => 'Aktif',
        ]);
    }
}
