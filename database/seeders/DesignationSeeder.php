<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed some designations
        Designation::create(['name' => 'Software Engineer']);
        Designation::create(['name' => 'Marketing Manager']);
        Designation::create(['name' => 'HR Coordinator']);
        // Add more designations as needed
    }
}
