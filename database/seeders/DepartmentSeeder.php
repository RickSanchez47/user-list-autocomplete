<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed some departments
        Department::create(['name' => 'Engineering']);
        Department::create(['name' => 'Marketing']);
        Department::create(['name' => 'Human Resources']);
        // Add more departments as needed
    }
}
