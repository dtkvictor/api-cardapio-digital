<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HierarchySeeder::class,            
            UserSeeder::class,
            UserDetailSeeder::class,
            AddressSeeder::class,            
            CategorySeeder::class,
            ProductSeeder::class, 
            PaymentMethodSeeder::class,
            SaleSeeder::class,
            SaleDetailsSeeder::class,            
        ]);
    }
}
