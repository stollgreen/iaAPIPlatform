<?php

namespace Database\Seeders;

use App\Models\TimeTrackingChannel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeTrackingChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeTrackingChannel::create([
            'name' => 'phone',
            'description' => 'phone call',
        ]);
        TimeTrackingChannel::create([
            'name' => 'email',
            'description' => 'email',
        ]);
        TimeTrackingChannel::create([
            'name' => 'chat',
            'description' => 'chat',
        ]);
        TimeTrackingChannel::create([
            'name' => 'machine',
            'description' => 'machine',
        ]);
        TimeTrackingChannel::create([
            'name' => 'terminal',
            'description' => 'terminal',
        ]);
        TimeTrackingChannel::create([
            'name' => 'api',
            'description' => 'api',
        ]);
        TimeTrackingChannel::create([
            'name' => 'card',
            'description' => 'card',
        ]);
    }
}
