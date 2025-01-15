<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Commitment;
use App\Models\Employee;
use App\Models\TimeTracking;
use App\Models\TimeTrackingChannel;
use App\Models\TimeTrackingState;

class TimeTrackingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimeTracking::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::query()->inRandomOrder()?->value('id') ?? Employee::factory()->create()->value('id'),
            'commitment_id' => Commitment::query()->inRandomOrder()?->value('id') ?? Commitment::factory()->create()->value('id'),
            'time_tracking_channel_id' => TimeTrackingChannel::query()->inRandomOrder()->value('id')
                ?? TimeTrackingChannel::factory()->create()->value('id'),
            'time_tracking_state_id' => TimeTrackingState::query()->inRandomOrder()->value('id')
                ?? TimeTrackingState::factory()->create()->value('id'),
            'start_time' => $this->faker->dateTime(now()),
            'end_time' => $this->faker->dateTime(now()->addMinutes(rand(1, 480)))
        ];
    }
}
