<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Promoter;
use App\Models\PromoterGroup;

class PromoterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Promoter::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        $skill = Skill::inRandomOrder()->first();
        $employee = Employee::factory()->create();

        return [
            'employee_id' => $employee->id,
            'promoter_group_id' => PromoterGroup::factory()->create()->id,
            'name' => $employee->first_name . " " . $employee->last_name,
            'email' => $employee->email,
            'phone' => $this->faker->phoneNumber(),
            'skills' => Skill::inRandomOrder()->take(rand(1,5))->pluck('id'),
            'certifications' => $this->faker->word(),
            'availability' => $this->faker->word(),
        ];
    }
}
