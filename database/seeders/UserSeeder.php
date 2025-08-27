<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@college.edu',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department' => 'Administration',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Dr. Principal',
            'email' => 'principal@college.edu',
            'password' => Hash::make('password'),
            'role' => 'principal',
            'department' => 'Administration',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Finance Officer',
            'email' => 'finance@college.edu',
            'password' => Hash::make('password'),
            'role' => 'finance_officer',
            'department' => 'Finance',
            'is_active' => true,
        ]);

        // Create department heads
        User::create([
            'name' => 'Dr. CS Head',
            'email' => 'cshead@college.edu',
            'password' => Hash::make('password'),
            'role' => 'department_head',
            'department' => 'Computer Science',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Dr. Math Head',
            'email' => 'mathhead@college.edu',
            'password' => Hash::make('password'),
            'role' => 'department_head',
            'department' => 'Mathematics',
            'is_active' => true,
        ]);

        // Create faculty members
        User::create([
            'name' => 'Prof. John Faculty',
            'email' => 'faculty@college.edu',
            'password' => Hash::make('password'),
            'role' => 'faculty',
            'department' => 'Computer Science',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Dr. Jane Professor',
            'email' => 'jane@college.edu',
            'password' => Hash::make('password'),
            'role' => 'faculty',
            'department' => 'Mathematics',
            'is_active' => true,
        ]);
    }
}
