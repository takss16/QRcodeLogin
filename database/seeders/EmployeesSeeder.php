<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert sample data into the 'employees' table
        DB::table('employees')->insert([
            [
                'employee_id' => '001',
                'last_name' => 'Doe',
                'first_name' => 'John',
                'middle_name' => 'A',
            ],
            [
                'employee_id' => '002',
                'last_name' => 'Smith',
                'first_name' => 'Jane',
                'middle_name' => 'B',
            ],
        ]);
    }
}
