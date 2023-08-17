<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {        
        $user = User::inRandomOrder()->first()->id;

        return [
            'user' => $user,
            'zipcode' => fake()->bothify('########'),
            'state' => fake()->sentence(2),
            'city' => fake()->sentence(2),
            'neighborhood' => fake()->sentence(3),
            'street_address' => fake()->sentence(3),
            'number' => fake()->bothify('###'),
            'complement' => fake()->paragraph()
        ];
    }
}
