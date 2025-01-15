<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CommitmentState;

class CommitmentStateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CommitmentState::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => CommitmentState::inRandomOrder()->first()?->name ?? "Test",
        ];
    }
}
