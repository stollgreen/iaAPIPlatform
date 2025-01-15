<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            'name' => 'Standort 1',
            'address' => 'Musterstraße 11',
            'postal_code' => '10117',
            'city' => "Berlin",
            'country' => 1,
            'capacity' => 100,
        ]);
        Location::create([
            'name' => 'Standort 2',
            'address' => 'Wegemuster 3',
            'postal_code' => '20357',
            'city' => "Hamburg",
            'country' => 1,
            'capacity' => 250,
        ]);
    }
}
