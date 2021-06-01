<?php

namespace App\Http\Controllers\Backend\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Backend\Transaction\TransactionType;
use App\Model\Backend\Transaction\TransactionCategory;

class TransactionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("backend.transaction.transaction-category.view", [
            "transactionCategories" => TransactionCategory::all(),
            "transactionTypes" => TransactionType::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route("admin.transaction-category.index");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required|string|max:100|unique:transaction_categories,name",
            "transaction_type_id" => "required|exists:transaction_types,id",
        ]);

        $transaction_category = new TransactionCategory();

        $transaction_category->business_location_id = 1;
        $transaction_category->business_type_id = 1;
        $transaction_category->name = $request->name;
        $transaction_category->transaction_type_id = $request->transaction_type_id;
        $transaction_category->status = 1;
        $transaction_category->is_active = 1;
        $transaction_category->is_verified = 1;
        $transaction_category->created_by = auth()->user()->id;

        if ($transaction_category->save()) {
            $notification = array(
                'message' => 'Successfully Transaction Category added!',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Someting Went Wrong!',
                'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Backend\Transaction\TransactionCategory  $transaction_category
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionCategory $transaction_category)
    {
        return redirect()->route("admin.transaction-category.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Backend\Transaction\TransactionCategory  $transaction_category
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionCategory $transaction_category)
    {
        return view("backend.transaction.transaction-category.edit", [
            "transactionCategory" => $transaction_category,
            "transactionTypes" => TransactionType::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Backend\Transaction\TransactionCategory  $transaction_category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionCategory $transaction_category)
    {
        $this->validate($request, [
            "name" => "required|string|max:100|unique:transaction_categories,name," . $transaction_category->id,
            "transaction_type_id" => "required|exists:transaction_types,id",
        ]);

        $transaction_category->business_location_id = 1;
        $transaction_category->business_type_id = 1;
        $transaction_category->name = $request->name;
        $transaction_category->transaction_type_id = $request->transaction_type_id;
        $transaction_category->status = 1;
        $transaction_category->is_active = 1;
        $transaction_category->is_verified = 1;
        $transaction_category->created_by = auth()->user()->id;

        if ($transaction_category->save()) {
            $notification = array(
                'message' => 'Successfully Transaction Category updated!',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Someting Went Wrong!',
                'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Backend\Transaction\TransactionCategory  $transaction_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionCategory $transaction_category)
    {
        $transaction_category->deleted_at = date('Y-m-d h:i:s');
        if ($transaction_category->save()) {
            $notification = array(
                'message' => 'Successfully Transaction Category Deleted!',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Someting Went Wrong!',
                'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification);
    }
}
