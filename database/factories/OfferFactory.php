<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Event;
use App\Models\Offer;
use App\Models\OfferState;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        return [
            'event_id' => Event::factory()->create()->value('id'),
            'customer_id' => Customer::factory()->create()->value('id'),
            'description' => $this->faker->text(30),
            'total_price' => $this->faker->randomFloat(2, 0, 25000),
            'status' => OfferState::inRandomOrder()->value('id')
        ];
    }
}
