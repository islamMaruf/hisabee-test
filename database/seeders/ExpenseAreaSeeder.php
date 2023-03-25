<?php

namespace Database\Seeders;

use App\Models\ExpenseArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        $expenseAreas = ['Housing or Rent','Transportation and Car Insurance','Travel Expenses','Food and Groceries','Utility Bills','Cell Phone','Childcare and School Costs','Pet Food and Care','Pet Insurance','Clothing and Personal Upkeep','Health Insurance','Monthly Memberships and Subscriptions','Life Insurance','Homeowners Insurance','Entertainment','Student Loans','Credit Card Debt','Emergency Fund','Large Purchases'];
        foreach ($expenseAreas as $expenseArea){
            ExpenseArea::create([
                'name' => $expenseArea
            ]);
        }
    }
}
