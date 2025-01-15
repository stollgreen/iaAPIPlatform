<?php

namespace Database\Seeders;

use App\Models\TimeTracking;
use App\Models\TimeTrackingState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeTrackingStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeTrackingState::create([
            'name' => 'pending',
        ]);
        TimeTrackingState::create([
            'name' => 'accepted',
        ]);
        TimeTrackingState::create([
            'name' => 'rejected',
        ]);
        TimeTrackingState::create([
            'name' => 'in progress',
        ]);
        TimeTrackingState::create([
            'name' => 'completed',
        ]);
        TimeTrackingState::create([
            'name' => 'cancelled',
        ]);
    }
}
