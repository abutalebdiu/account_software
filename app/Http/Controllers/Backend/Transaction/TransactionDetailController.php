<?php

namespace App\Http\Controllers\Backend\Transaction;

use App\Http\Controllers\Controller;
use App\Model\Backend\Transaction\TransactionCategory;
use App\Model\Backend\Transaction\TransactionDetail;
use App\Model\Backend\Transaction\TransactionFinal;
use App\Model\Backend\Transaction\TransactionType;
use Illuminate\Http\Request;
use DB;
class TransactionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TransactionFinal::with("transactionDetails")->first();

        return view("backend.transaction.transaction-detail.view", [
            "transactionFinals" => TransactionFinal::with(["transactionDetails", "transactionType", "transactionCategory"])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.transaction.transaction-detail.add", [
            "transactionTypes" => TransactionType::whereNull('deleted_at')->get(),
            "transactionCategories" => TransactionCategory::whereNull('deleted_at')->get(),
        ]);
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
            "transaction_date" => "required",
            "transaction_type_id" => "required",
            "transaction_category_id" => "required",
            "sub_total.*" => "required|numeric",
            "transaction_created_date.*" => "required",
        ]);
        /* if($request->payment_amount == 0 || $request->payment_amount == NULL)return redirect()->back()->with([
            'alert-type' => 'error',
            'message' => 'Invalid Number!'
        ]); */
        
        $status = NULL;
        // Start transaction!
        DB::beginTransaction();
        try
        {  
            $save_detail = [];
            $transaction_final = new TransactionFinal();
            $transaction_final->business_location_id    = 1;
            $transaction_final->business_type_id        = 1;
            $transaction_final->transaction_type_id     = $request->transaction_type_id;
            $transaction_final->transaction_category_id = $request->transaction_category_id;
            $transaction_final->reference_no            = $request->transaction_final_reference;
            $transaction_final->transaction_date        = $request->transaction_date;
            //$transaction_final->others_cost           = 0;
            //$transaction_final->discount_type         = 0;
            //$transaction_final->discount_value        = 0;
            //$transaction_final->discount_amount       = 0;
            $transaction_final->transaction_note        = $request->transaction_note;
            $transaction_final->created_by              = auth()->user()->id;
            if ($transaction_final->save()) 
            {
                foreach ($request->sub_total as $key => $amount) {
                    $transaction_detail = new TransactionDetail();
                    $transaction_detail->business_location_id       = 1;
                    $transaction_detail->business_type_id           = 1;
                    $transaction_detail->transaction_type_id        = $request->transaction_type_id;
                    $transaction_detail->transaction_category_id    = $request->transaction_category_id;
                    $transaction_detail->transaction_final_id       = $transaction_final->id;
                    $transaction_detail->transaction_created_date   = $request->transaction_created_date[$key];
                    $transaction_detail->reference_no               = $request->transaction_final_reference;
                    $transaction_detail->transaction_title          = $request->transaction_title[$key];
                    $transaction_detail->description                = $request->description[$key];
                    $transaction_detail->sub_total                  = $amount;
                    $transaction_detail->created_by = auth()->user()->id;
                    $save_detail[] = $transaction_detail->save();
                }
                if (!in_array(false, $save_detail)) {
                    $notification = array(
                        'message' => 'Successfully Transaction Added!',
                        'alert-type' => 'success'
                    );
                } else {
                    $notification = array(
                        'message' => 'Someting Went Wrong!',
                        'alert-type' => 'error'
                    );
                }
                DB::commit();
            } else {
                $notification = array(
                    'message' => 'Someting Went Wrong!',
                    'alert-type' => 'error'
                );
            }
            return redirect()->route('admin.transaction-detail.index')->with($notification);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            if($e->getMessage())
            {
                $message = $e->getMessage();//"Something went wrong! Please Try again";
            }
            return Redirect()->back()
                ->with('error',$message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Backend\Transaction\TransactionDetail  $transaction_detail
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionDetail $transaction_detail)
    {
        $data['transaction']    =  TransactionFinal::findOrfail($transaction_detail->transaction_final_id);
        return view("backend.transaction.transaction-detail.show",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Backend\Transaction\TransactionDetail  $transaction_detail
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionDetail $transaction_detail)
    {
        return view("backend.transaction.transaction-detail.edit", [
            "transactionTypes" => TransactionType::whereNull('deleted_at')->get(),
            "transactionCategories" => TransactionCategory::whereNull('deleted_at')->get(),
            "transactionFinal" => TransactionFinal::where("id", $transaction_detail->transaction_final_id)->with("transactionDetails")->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Backend\Transaction\TransactionDetail  $transaction_detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionFinal $transaction_detail)
    {
        $save_detail = [];
        $transaction_final = $transaction_detail;
        $transaction_final->business_location_id = 1;
        $transaction_final->business_type_id = 1;
        $transaction_final->transaction_type_id = $request->transaction_type_id;
        $transaction_final->transaction_category_id = $request->transaction_category_id;
        $transaction_final->reference_no = $request->transaction_final_reference;
        $transaction_final->transaction_date = $request->transaction_date;
        $transaction_final->others_cost = 0;
        $transaction_final->discount_type = 0;
        $transaction_final->discount_value = 0;
        $transaction_final->discount_amount = 0;
        $transaction_final->transaction_note = $request->transaction_note;
        $transaction_final->status = 1;
        $transaction_final->is_active = 1;
        $transaction_final->is_verified = 1;
        $transaction_final->created_by = auth()->user()->id;
        if ($transaction_final->save()) {
            $transaction_detail->transactionDetails()->delete();
            foreach ($request->transaction_created_date as $key => $item) {
                $transaction_detail = new TransactionDetail();
                $transaction_detail->business_location_id = 1;
                $transaction_detail->business_type_id = 1;
                $transaction_detail->transaction_type_id = $request->transaction_type_id;
                $transaction_detail->transaction_category_id = $request->transaction_category_id;
                $transaction_detail->transaction_final_id = $transaction_final->id;
                $transaction_detail->transaction_created_date = $request->transaction_created_date[$key];
                $transaction_detail->reference_no = $request->transaction_final_reference;
                $transaction_detail->transaction_title = $request->transaction_title[$key];
                $transaction_detail->description = $request->description[$key];
                $transaction_detail->sub_total = $request->sub_total[$key];
                $transaction_detail->status = 1;
                $transaction_detail->is_active = 1;
                $transaction_detail->is_verified = 1;
                $transaction_detail->created_by = auth()->user()->id;
                $save_detail[] = $transaction_detail->save();
            }
            if (!in_array(false, $save_detail)) {
                $notification = array(
                    'message' => 'Successfully Transaction Updated!',
                    'alert-type' => 'success'
                );
            } else {
                $notification = array(
                    'message' => 'Someting Went Wrong!',
                    'alert-type' => 'error'
                );
            }
        } else {
            $notification = array(
                'message' => 'Someting Went Wrong!',
                'alert-type' => 'error'
            );
        }
        return redirect()->route("admin.transaction-detail.index")->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Backend\Transaction\TransactionDetail  $transaction_detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionDetail $transaction_detail)
    {
        $transaction_final = TransactionFinal::findOrfail($transaction_detail->transaction_final_id);
        foreach ($transaction_final->transactionDetails as $key => $value) 
        {
            $value->deleted_at = date('Y-m-d h:i:s'); 
            $value->save();
        }
        $transaction_final->deleted_at = date('Y-m-d h:i:s');
        //$transaction_final->save();

        //$transaction_detail->deleted_at = date('Y-m-d h:i:s');
        if ($transaction_final->save()) {
          
            $notification = array(
                'message' => 'Successfully Transaction Deleted!',
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

    public function getTransactionCategory(TransactionType $transactionType)
    {
        return $transactionType->transactionCategories;
    }
}
