<?php

namespace Database\Seeders;

use App\Models\CommitmentState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommitmentStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //confirmed,pending,canceled
        CommitmentState::create([
            'name' => 'confirmed',
        ]);
        CommitmentState::create([
            'name' => 'pending',
        ]);
        CommitmentState::create([
            'name' => 'canceled'
        ]);
    }
}
