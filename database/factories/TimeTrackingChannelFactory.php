<?php

namespace Database\Factories;

use App\Models\TimeTrackingChannel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeTrackingChannelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimeTrackingChannel::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Definierte Kanalnamen
        $channels = ['Channel 1', 'Channel 2', 'Channel 3', 'Channel 4', 'Channel 5'];

        // Wähle zufällig einen Kanalnamen aus
        $channelName = $this->faker->randomElement($channels);

        // Gib die Werte zurück (es wird KEIN neuer Datensatz erstellt)
        return [
            'name' => $channelName,
            'description' => 'Standard description for ' . $channelName,
            'active' => true, // Standardwert für alle Kanäle
        ];
    }
}