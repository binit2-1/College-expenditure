<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create HoD (Department Head)
        User::updateOrCreate(
            ['email' => 'hod@college.edu'],
            [
                'name' => 'Dr. John Smith',
                'password' => bcrypt('password'),
                'role' => 'department_head',
                'department' => 'Computer Science'
            ]
        );

        // Create Faculty
        User::updateOrCreate(
            ['email' => 'faculty@college.edu'],
            [
                'name' => 'Prof. Jane Doe',
                'password' => bcrypt('password'),
                'role' => 'faculty',
                'department' => 'Computer Science'
            ]
        );

        // Create another Faculty from different department
        User::updateOrCreate(
            ['email' => 'faculty2@college.edu'],
            [
                'name' => 'Dr. Bob Wilson',
                'password' => bcrypt('password'),
                'role' => 'faculty',
                'department' => 'Mathematics'
            ]
        );

        // Create another HoD for Math department
        User::updateOrCreate(
            ['email' => 'hod-math@college.edu'],
            [
                'name' => 'Dr. Alice Johnson',
                'password' => bcrypt('password'),
                'role' => 'department_head',
                'department' => 'Mathematics'
            ]
        );
    }
}
