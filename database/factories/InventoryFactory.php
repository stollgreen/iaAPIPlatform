<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Inventory;
use App\Models\InventoryCondition;

class InventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inventory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type' => $this->faker->word(),
            'quantity' => $this->faker->randomNumber(),
            'available' => $this->faker->boolean(),
            'condition' => InventoryCondition::factory()->create()->id,
            'price' => $this->faker->word(),
            'rental_price' => $this->faker->word(),
        ];
    }
}
