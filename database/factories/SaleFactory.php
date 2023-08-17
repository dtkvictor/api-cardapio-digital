<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {        
        $user = User::inRandomOrder()->first()->id;    
        $payment = PaymentMethod::inRandomOrder()->first()->id;

        return [
            'user' => $user,
            'payment' => $payment
        ];
    }
}