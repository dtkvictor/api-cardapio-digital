<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SaleDetails>
 */
class SaleDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {        
        $sale = Sale::inRandomOrder()->first()->id;
        $product = Product::inRandomOrder()->first()->id;

        return [
            'sale' => $sale,
            'product' => $product,
            'quantity' => rand(1, 100),
            'price' => fake()->randomFloat(2, 0, 100),
            'discount' => rand(0, 100),
        ];
    }          
}
