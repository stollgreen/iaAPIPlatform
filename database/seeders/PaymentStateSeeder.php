<?php

namespace Database\Seeders;

use App\Models\PaymentState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentState::create([
           'name' => 'pending',
        ]);
        PaymentState::create([
            'name' => 'paid',
        ]);
        PaymentState::create([
            'name' => 'overdue',
        ]);
    }
}
