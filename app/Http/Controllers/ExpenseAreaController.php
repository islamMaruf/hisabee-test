<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseAreaRequest;
use App\Http\Requests\UpdateExpenseAreaRequest;
use App\Models\ExpenseArea;
use App\Traits\UploadImage;
use Illuminate\Http\JsonResponse;

class ExpenseAreaController extends Controller
{
    use UploadImage;

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $expenseAreas = ExpenseArea::all();
        return responder()->success($expenseAreas)->respond();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseAreaRequest $request)
    {
        $expenseArea = new ExpenseArea();
        $expenseArea->name = $request->name;
        $expenseArea->image_url = $this->insertImage($request);
        $expenseArea->save();
        return responder()->success($expenseArea)->respond();
    }

    /**
     * Display the specified resource.
     */
    public function show(ExpenseArea $expenseArea)
    {
        return responder()->success($expenseArea)->respond();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExpenseArea $expenseArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseAreaRequest $request, ExpenseArea $expenseArea): JsonResponse
    {
        $expenseArea->update([
           'name' => $request->name,
           'image_url' => $this->updateImage($request)
        ]);
        return responder()->success($expenseArea)->respond();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseArea $expenseArea): JsonResponse
    {
        $expenseArea->delete();
        return responder()->success($expenseArea)->respond();

    }
}
