<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;

class GroupUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupUser::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'groupid' => Group::factory()->create()->id,
            'userid' => User::factory()->create()->id,
        ];
    }
}
