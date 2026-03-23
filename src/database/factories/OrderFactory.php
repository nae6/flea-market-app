<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Item;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'buyer_id' => User::factory(),
            'item_id' => Item::factory(),
            'payment_method' => fake()->randomElement(['konbini', 'card']),
            'stripe_checkout_session_id' => 'cs_test_' . Str::random(24),
            'stripe_payment_intent_id' => 'pi_test_' . Str::random(24),
            'amount' => fake()->numberBetween(1000, 50000),
            'zip_code' => fake()->numerify('###-####'),
            'address' => fake()->address(),
            'building' => fake()->optional()->secondaryAddress(),
            'status' => 'paid',
        ];
    }
}
