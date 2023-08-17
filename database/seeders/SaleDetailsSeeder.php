<?php

namespace Database\Seeders;

use App\Models\SaleDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SaleDetails::factory()->count(100)->create();
    }
}
