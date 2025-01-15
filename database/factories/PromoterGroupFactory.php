<?php
namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PromoterGroup;

class PromoterGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PromoterGroup::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $skills = ['Verhandlungsführung', 'Teamarbeit', 'Projektmanagement', 'Kreativität', 'Kommunikation'];

        return [
            'name' => $this->faker->randomElement(['Marketing Team', 'Vertriebsgruppe', 'HR-Abteilung', 'IT-Support Team', 'Projektmanagement-Team']),
            'skills' => Skill::inRandomOrder()->take(rand(1, 5))->pluck('id')->toArray(),
            'description' => $this->faker->text(200),
            'max_members' => $this->faker->numberBetween(5, 15)
        ];
    }
}