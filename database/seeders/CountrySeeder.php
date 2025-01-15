<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create([
            'name' => 'Germany',
        ]);
        Country::create([
            'name' => 'Österreich',
        ]);
        Country::create([
            'name' => 'Schweiz',
        ]);
        Country::create([
            'name' => 'Frankreich',
        ]);
    }
}
