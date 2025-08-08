<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Office Supplies', 'Travel', 'Food & Dining', 'Marketing',
            'Equipment', 'Utilities', 'Insurance', 'Professional Services',
            'Sales Revenue', 'Consulting Income', 'Product Sales', 'Service Income'
        ];

        return [
            'business_id' => Business::factory(),
            'name' => $this->faker->randomElement($categories),
            'type' => $this->faker->randomElement(['income', 'expense']),
        ];
    }
}
