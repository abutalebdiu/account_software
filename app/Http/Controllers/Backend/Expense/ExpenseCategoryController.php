<?php

namespace App\Http\Controllers\Backend\Expense;

use App\Http\Controllers\Controller;
use App\Model\Backend\Expense\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "klddl";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Backend\Expense\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Backend\Expense\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Backend\Expense\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Backend\Expense\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        //
    }
}
