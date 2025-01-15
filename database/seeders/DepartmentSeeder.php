<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'name' => 'IT',
        ]);
        Department::create([
            'name' => 'HR',
        ]);
        Department::create([
            'name' => 'Sales',
        ]);
        Department::create([
            'name' => 'Marketing',
        ]);
        Department::create([
            'name' => 'Finance',
        ]);
        Department::create([
            'name' => 'Admin',
        ]);
        Department::create([
            'name' => 'Customer Service',
        ]);
        Department::create([
            'name' => 'Quality Assurance',
        ]);
    }

}
