<?php

namespace App\Http\Controllers\Backend\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Backend\Transaction\TransactionType;

class TransactionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("backend.transaction.transaction-type.view", [
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
        return redirect()->route("admin.transaction-type.index");
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
            "name" => "required|string|max:100|unique:transaction_types,name"
        ]);

        $transaction_type = new TransactionType();

        $transaction_type->business_location_id = 1;
        $transaction_type->business_type_id = 1;
        $transaction_type->name = $request->name;
        $transaction_type->status = 1;
        $transaction_type->is_active = 1;
        $transaction_type->is_verified = 1;
        $transaction_type->created_by = auth()->user()->id;

        if ($transaction_type->save()) {
            $notification = array(
                'message' => 'Successfully Transaction Type added!',
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
     * @param  \App\Model\Backend\Transaction\TransactionType  $transaction_type
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionType $transaction_type)
    {
        return redirect()->route("admin.transaction-type.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Backend\Transaction\TransactionType  $transaction_type
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionType $transaction_type)
    {
        return view("backend.transaction.transaction-type.edit", [
            "transactionType" => $transaction_type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Backend\Transaction\TransactionType  $transaction_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionType $transaction_type)
    {
        $this->validate($request, [
            "name" => "required|string|max:100|unique:transaction_types,name," . $transaction_type->id
        ]);

        $transaction_type->name = $request->name;

        if ($transaction_type->save()) {
            $notification = array(
                'message' => 'Successfully Transaction Type Updated!',
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
     * @param  \App\Model\Backend\Transaction\TransactionType  $transaction_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionType $transaction_type)
    {
        $transaction_type->deleted_at = date('Y-m-d h:i:s');
        if ($transaction_type->save()) {
            $notification = array(
                'message' => 'Successfully Transaction Type Deleted!',
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
