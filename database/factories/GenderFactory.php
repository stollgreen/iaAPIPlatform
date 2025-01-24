<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Gender;

class GenderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gender::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => Gender::inRandomOrder()->value('id') ?? $this->faker->randomElement(['male', 'female']),
        ];
    }
}
