<?php

namespace Database\Seeders;

use App\Models\Pricegroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pricegroup::create([
            'name' => 'normal',
            'description' => 'Normalpreis',
            'discount' => '0',
            'currency' => 'EUR',
        ]);
        Pricegroup::create([
            'name' => 'special',
            'description' => 'Spezialpreis',
            'discount' => '10',
            'currency' => 'EUR',
        ]);

    }
}
