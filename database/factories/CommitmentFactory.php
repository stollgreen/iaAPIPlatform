<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Commitment;
use App\Models\CommitmentState;
use App\Models\Event;
use App\Models\Promoter;

class CommitmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Commitment::class;


    /**
     * CommitmentFactory constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->faker = \Faker\Factory::create('de_DE'); // Lokale Sprache setzen
    }

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'promoter_id' => Promoter::factory()->create()->value('id'),
            'event_id' => Event::inRandomOrder()->value('id') ?? Event::factory()->create()->value('id'),
            'role' => $this->faker->randomElement([
                'Projektleiter',
                'Verkaufsleiter',
                'Kundenberater',
                'Buchhalter',
                'Marketing-Manager',
                'Event-Koordinator',
                'Geschäftsführer'
            ]),
            'start_time' => $this->faker->dateTime(now()),
            'end_time' => $this->faker->dateTime(now()->addMinutes(rand(1, 480))),
            'status' => CommitmentState::inRandomOrder()->value('id'),
        ];
    }

}
