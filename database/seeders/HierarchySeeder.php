<?php

namespace Database\Seeders;

use App\Models\Hierarchy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HierarchySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hierarchy::factory()->count(1)->create();
    }
}
