<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expenditure;
use App\Models\UtilisationCertificate;

class ExpenditureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample expenditures
        $expenditures = [
            [
                'item_name' => 'Office Stationery',
                'amount' => 1500.00,
                'date' => '2024-01-15',
                'category' => 'stationery'
            ],
            [
                'item_name' => 'Printer Maintenance',
                'amount' => 3000.00,
                'date' => '2024-01-20',
                'category' => 'maintenance'
            ],
            [
                'item_name' => 'Annual Day Event',
                'amount' => 15000.00,
                'date' => '2024-02-10',
                'category' => 'events'
            ],
            [
                'item_name' => 'Faculty Salaries',
                'amount' => 50000.00,
                'date' => '2024-02-28',
                'category' => 'salary'
            ],
            [
                'item_name' => 'Computer Equipment',
                'amount' => 25000.00,
                'date' => '2024-03-05',
                'category' => 'maintenance'
            ]
        ];

        foreach ($expenditures as $expenditure) {
            Expenditure::create($expenditure);
        }

        // Create sample UCs
        $uc1 = UtilisationCertificate::create([
            'title' => 'January Stationery Expenses',
            'description' => 'Utilization certificate for office stationery purchased in January 2024'
        ]);

        $uc2 = UtilisationCertificate::create([
            'title' => 'January-February Maintenance',
            'description' => 'Utilization certificate for maintenance activities in January-February 2024'
        ]);

        // Attach expenditures to UCs
        $uc1->expenditures()->attach([1]); // Office Stationery
        $uc2->expenditures()->attach([2, 5]); // Printer Maintenance, Computer Equipment
    }
}
