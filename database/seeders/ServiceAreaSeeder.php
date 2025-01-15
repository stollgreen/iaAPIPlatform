<?php

namespace Database\Seeders;

use App\Models\Servicearea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bundeslaender = [
            'Baden-Württemberg',
            'Bayern',
            'Berlin',
            'Brandenburg',
            'Bremen',
            'Hamburg',
            'Hessen',
            'Mecklenburg-Vorpommern',
            'Niedersachsen',
            'Nordrhein-Westfalen',
            'Rheinland-Pfalz',
            'Saarland',
            'Sachsen',
            'Sachsen-Anhalt',
            'Schleswig-Holstein',
            'Thüringen',
        ];

        foreach ($bundeslaender as $bundesland) {
            Servicearea::create([
                'name' => $bundesland,
                'description' => null  // Optional: Kann auch ein Standardwert haben, wenn gewünscht
            ]);
        }
    }
}
