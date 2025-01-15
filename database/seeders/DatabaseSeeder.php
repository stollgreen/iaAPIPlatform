<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Skill;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountrySeeder::class);
        $this->call(CommitmentStateSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(EventStateSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(InventoryConditionSeeder::class);
        $this->call(ServiceAreaSeeder::class);
        $this->call(OfferStateSeeder::class);
        $this->call(PaymentStateSeeder::class);
        $this->call(PriceGroupSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(PromoterGroupSeeder::class);
        $this->call(TimeTrackingChannelSeeder::class);
        $this->call(TimeTrackingStateSeeder::class);
    }
}
