<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::create(
            [
                'name' => 'php',
                'description' => 'PHP skill',
                'category' => 'programming',
                'required_certification' => 'certified'
            ]
        );

        Skill::create(
            [
                'name' => 'laravel',
                'description' => 'Laravel skill',
                'category' => 'programming',
                'required_certification' => 'certified'
            ]
        );
    }
}
