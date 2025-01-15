<?php

namespace Database\Seeders;

use App\Models\Promoter;
use App\Models\PromoterGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoterGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PromoterGroup::create([
            'name' => 'promotergroup1',
            'description' => 'PromoterGruppe 1',
            'skills' => [],
            'max_members' => '10',
        ]);

        PromoterGroup::create([
            'name' => 'promotergroup2',
            'description' => 'PromoterGruppe 2',
            'skills' => [],
            'max_members' => '10',
        ]);
    }
}
