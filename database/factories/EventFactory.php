<?php

namespace Database\Factories;

use App\Models\EventState;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Location;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'date' => $this->faker->dateTime(now()->addDays(14)),
            'location_id' => Location::factory()->create()->value('id'),
            'organizer' => $this->faker->name(),
            'budget' => $this->faker->randomFloat(2, 0, 10000),
            'status' => EventState::factory()->create()->id,
        ];
    }
}
