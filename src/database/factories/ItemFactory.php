<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Condition;
use App\Models\Item;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'item_name' => fake()->words(2, true),
            'image_url' => 'items/sample.png',
            'brand' => fake()->optional()->company(),
            'price' => fake()->numberBetween(500, 10000),
            'condition_id' => Condition::factory(),
            'description' => fake()->realText(100),
            'status' => 1,
        ];

    }
}
