<?php

namespace Database\Seeders;

use App\Models\Inventorycondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventoryConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inventorycondition::create([
            'name' => 'new',
        ]);
        Inventorycondition::create([
            'name' => 'used',
        ]);
        Inventorycondition::create([
            'name' => 'damaged',
        ]);
        Inventorycondition::create([
            'name' => 'refurbished',
        ]);
        Inventorycondition::create([
            'name' => 'missed',
        ]);
    }
}
