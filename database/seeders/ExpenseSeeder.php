<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\ExpenseArea;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expenseAreaMaxId = ExpenseArea::max('id');
        $expenseAreaMinId = ExpenseArea::min('id');
        for ($i = 0; $i < 1000; $i++) {
            Log::info('hit expense  loop ------------> ' . $i . ' rand id---------> ' . rand($expenseAreaMaxId, $expenseAreaMinId));
            $expense = new Expense();
            $expense->amount = rand(100, 100000);
            $expense->expense_area_id = rand($expenseAreaMaxId, $expenseAreaMinId);
            $expense->created_at = Carbon::now()->subdays(rand(2, 45))->toDateTimeString();;
            $expense->updated_at = Carbon::now()->subdays(rand(2, 45))->toDateTimeString();;
            $expense->save();
            Log::info(json_encode($expense->toJson()));
        }
    }
}
