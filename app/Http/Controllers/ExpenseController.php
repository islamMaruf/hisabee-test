<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use App\Models\ExpenseArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {

        $expenses = ExpenseArea::select('expense_areas.name as expense_area', DB::raw('SUM(expenses.amount) as amount'), DB::raw('MAX(expenses.created_at) as created_at'))
            ->join('expenses', 'expense_areas.id', '=', 'expenses.expense_area_id')
            ->groupBy('expense_areas.id');
        if (request()->has('sort_by') && in_array(request()->sort_by, ['date', 'amount']) && request()->has('sort_order') && in_array(request()->sort_order, ['asc', 'desc'])) {
            $sortBy = request()->sort_by == 'date' ? 'created_at' : 'amount';
            $sortOrder = request()->sort_order ? request()->sort_order : 'desc';
            $expenses->orderBy($sortBy, $sortOrder);
        }
        $expenses = $expenses->get();
        $total_amount = Expense::sum('amount');

        $expenses = $expenses->map(function ($item) use ($total_amount) {
            $item['percentage'] = round(($item->amount / $total_amount) * 100, 2);
            return $item;
        });

        return responder()->success($expenses)->respond();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function removeAmount(Request $request): JsonResponse
    {
        $expense = new Expense();
        $expense->amount =  - ($request->amount);
        $expense->notes = $request->notes;
        $expense->expense_area_id = $request->expense_area_id;
        $expense->save();
        return responder()->success($expense)->respond();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $expense = new Expense();
        $expense->amount = $request->amount;
        $expense->notes = $request->notes;
        $expense->expense_area_id = $request->expense_area_id;
        $expense->save();
        return responder()->success($expense)->respond();

    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense): JsonResponse
    {
        $expenses = ExpenseArea::select('expense_areas.name as expense_area', DB::raw('SUM(expenses.amount) as amount'), DB::raw('MAX(expenses.created_at) as created_at'))
            ->join('expenses', 'expense_areas.id', '=', 'expenses.expense_area_id')
            ->where('expense_areas.id', $expense->expense_area_id)
            ->groupBy('expense_areas.id')
            ->get();
        $total_amount = Expense::sum('amount');

        $expense = $expenses->map(function ($item) use ($total_amount) {
            $item['percentage'] = round(($item->amount / $total_amount) * 100, 2);
            return $item;
        });
        return responder()->success($expense)->respond();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense): JsonResponse
    {

        $expense->update([
            'amount' => -($request->amount),
            'notes' => $request->notes,
            'expense_area_id' => $request->expense_area_id
        ]);
        return responder()->success($expense)->respond();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense): JsonResponse
    {
        $expense = $expense->delete();
        return responder()->success($expense)->respond();

    }
}
