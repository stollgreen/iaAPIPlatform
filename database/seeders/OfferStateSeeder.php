<?php

namespace Database\Seeders;

use App\Models\OfferState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OfferState::create([
            'name' => 'pending',
        ]);
        OfferState::create([
            'name' => 'accepted',
        ]);
        OfferState::create([
            'name' => 'rejected',
        ]);
    }
}
