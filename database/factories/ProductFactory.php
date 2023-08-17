<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {                
        $category = Category::inRandomOrder()->first()->id;

        return [
            'category' => $category,
            'name' => fake()->name(),               
            'price' => fake()->randomFloat(2, 0, 100),
            'description' => fake()->paragraph(),            
            'thumb' => fake()->imageUrl(),
        ];
    }    
}
