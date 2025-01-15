<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'is_admin',
            'description' => 'Ist Administratorkonto',
        ]);
        Permission::create([
            'name' => 'is_user',
            'description' => 'Ist Benutzerkonto',
        ]);
        Permission::create([
            'name' => 'is_customer',
            'description' => 'Ist Kunde',
        ]);
        Permission::create([
            'name' => 'is_employee',
            'description' => 'Ist Mitarbeiter',
        ]);
        Permission::create([
            'name' => 'is_manager',
            'description' => 'Ist Manager',
        ]);
        Permission::create([
            'name' => 'is_accountant',
            'description' => 'Ist Accountant',
        ]);

    }
}
