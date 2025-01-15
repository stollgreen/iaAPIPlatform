<?php

namespace Database\Seeders;

use App\Models\Eventstate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Eventstate::create([
            'name' => 'planned',
        ]);
        Eventstate::create([
            'name' => 'ongoing',
        ]);
        Eventstate::create([
            'name' => 'completed',
        ]);
        Eventstate::create([
            'name' => 'canceled'
        ]);
    }
}
