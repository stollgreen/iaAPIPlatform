<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TimeTrackingState;

class TimeTrackingStateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimeTrackingState::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $states = ['active', 'inactive', 'pending', 'approved', 'rejected'];

        // Wähle zufällig einen Zustand aus der Liste
        $stateName = $this->faker->randomElement($states);

        // Suche den Zustand in der Datenbank oder erstelle ihn, falls er nicht existiert
        $state = TimeTrackingState::firstOrCreate(
            ['name' => $stateName],
            ['description' => $this->faker->text()]
        );

        // Gib die Werte zurück
        return [
            'name' => $state->name,
            'description' => $state->description,
        ];
    }
}