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
                'employee_id' => 'asd',
                'last_name' => 'Doe',
                'first_name' => 'John',
                'middle_name' => 'A',
            ],

        ]);
    }
}
