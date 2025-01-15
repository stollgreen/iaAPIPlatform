<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\Location;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'country' => Country::factory()->create()->id,
            'postal_code' => $this->faker->postcode(),
            'capacity' => $this->faker->numberBetween( 1, 5000)
        ];
    }
}
