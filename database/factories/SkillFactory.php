<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Skill;

class SkillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Projektmanagement',
                'Softwareentwicklung',
                'Datenanalyse',
                'Kundenbetreuung',
                'Teamführung',
                'UX/UI Design',
                'Suchmaschinenoptimierung',
                'Content-Marketing',
                'Verhandlungsführung',
                'IT-Sicherheit',
                'Webentwicklung',
                'Cloud Computing',
                'Maschinelles Lernen',
                'Buchhaltung',
                'Sprachkompetenz (z. B. Englisch, Deutsch)',
            ]),
            'description' => $this->faker->text(),
            'category' => $this->faker->randomElement([
                'Technologie',
                'Management',
                'Marketing',
                'Kreativität',
                'Kommunikation',
                'Finanzen',
                'Forschung',
            ]),
            'required_certification' => $this->faker->optional()->word(),
        ];
    }
}
