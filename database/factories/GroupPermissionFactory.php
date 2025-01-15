<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Group;
use App\Models\GroupPermission;

class GroupPermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupPermission::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'groupid' => Group::factory()->create()->id,
            'value' => $this->faker->word(),
        ];
    }
}
