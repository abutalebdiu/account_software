<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Auth;
use App\Models\Customer;
use Validator;
use App\Model\Backend\Payment\PaymentMethod;
use App\Model\Backend\Payment\AccountPaymentHistory;
use App\Model\Backend\Payment\AccountPaymentHistoryDetail;
use DB;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['loans'] = Loan::latest()->get();
        return view('backend.loans.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['payment_methods']   = PaymentMethod::whereNull('deleted_at')->get();
        $data['customers'] = Customer::where('customer_type',2)->get();
        return view('backend.loans.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator =  Validator::make($request->all(),[
            'customer_id'  => 'required',
            'amount'       => 'required',
            'loan_date'    => 'required',
        ]);


        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{

        DB::beginTransaction();
        try
        {

            $countloan = Loan::count();
            $findlastorder = Loan::latest()->first();

            $loan = New Loan();

            if($countloan>0){
                $loan->loanuid  =  $findlastorder->loanuid+1;
            }
            else{
                $loan->loanuid  =  '20210001';
            }

            $loan->customer_id  = $request->customer_id;
            $loan->amount       = $request->amount;
            $loan->loan_by      = Auth::user()->id;
            $loan->loan_reason  = $request->loan_reason;
            $loan->loan_date    = $request->loan_date;
            $loan->return_date  = $request->return_date;
            $loan->note         = $request->note;
            $loan->loan_type    = 1;        /*1 for give and 2 for taken*/
            $loan->takenby      = $request->takenby;

            $loan->save();

            /*      need to acount table */

            $data = new AccountPaymentHistory();

            
            $findlastaccount = AccountPaymentHistory::orderBy('id','DESC')->first();
            

            $data->payment_invoice_no   = "00".$findlastaccount->payment_invoice_no+1;
            $data->payment_reference_no = 'LI'.date('Y')."/"."00".strval($findlastaccount->payment_invoice_no+1);
            $data->module_id            = module_HH()['loan'];
            $data->module_invoice_no    = $loan->loanuid;
            $data->module_invoice_id    = $loan->id;
            $data->account_id           = $request->account_id;
            $data->payment_method_id    = $request->payment_method_id;
            $data->cdf_type_id          = cdf_HH()['debit'];
            $data->payment_type_id      = payment_type_HH()['expense'];
            $data->payment_amount       = $request->amount;
            $data->client_supplier_id   = $request->customer_id;
            $data->description          = $request->note;
            $data->payment_date         = $request->loan_date;
            $data->payment_by           = Auth::user()->id;
            $data->created_by           = Auth::user()->id;
            $data->save();
            
                /*      need to acount History table */


            $detail = new AccountPaymentHistoryDetail();
            $detail->account_payment_history_id     =  $data->id;
            $detail->payment_invoice_no             =  $data->payment_invoice_no;
            $detail->payment_reference_no           =  $data->payment_reference_no;
            $detail->module_id                      =  $data->module_id;
            $detail->account_id                     =  $data->account_id;
            $detail->payment_method_id              =  $data->payment_method_id;

            $detail->card_number                    =  $request->card_number;
            $detail->card_holder_name               =  $request->card_holder_name;
            $detail->card_transaction_no            =  $request->card_transaction_no;
            $detail->card_type                      =  $request->card_type;
            $detail->expire_month                   =  $request->expire_month;
            $detail->expire_year                    =  $request->expire_year;
            $detail->card_security_code             =  $request->card_security_code;
            $detail->from_mobile_banking_account    =  $request->from_mobile_banking_account;
            $detail->cheque_no                      =  $request->cheque_no;
            $detail->transfer_bank_account_no       =  $request->transfer_bank_account_no;
            $detail->transaction_no                 =  $request->transaction_no;
            $detail->payment_note                   =  $request->payment_note;
            $detail->payment_date                   =  $request->loan_date;
         
            $detail->save();


            DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollback();
                if($e->getMessage())
                {
                    $message = $e->getMessage();//"Something went wrong! Please Try again";
                }
                $notification = array(
                    'message' => 'Successfully customer Loan added!',
                    'alert-type' => 'error'
                );
                return redirect()->route('customer.loan.create')->with($notification);
            }

            $notification = array(
                    'message' => 'Successfully customer Loan added!',
                    'alert-type' => 'success'
            );
            return redirect()->route('customer.loan.index')->with($notification);

            
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan,$id)
    {
        $data['customers'] = Customer::where('customer_type',2)->get();
        $data['loan']   = Loan::find($id);
        return view('backend.loans.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan,$id)
    {
         $validator =  Validator::make($request->all(),[
            'customer_id'  => 'required',
            'amount'       => 'required',
            'loan_date'    => 'required',
        ]);


        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{

        DB::beginTransaction();
        try
        {

    
            $loan =  Loan::find($id);

            $loan->customer_id  = $request->customer_id;
            $loan->amount       = $request->amount;
            $loan->loan_by      = Auth::user()->id;
            $loan->loan_reason  = $request->loan_reason;
            $loan->loan_date    = $request->loan_date;
            $loan->return_date  = $request->return_date;
            $loan->note         = $request->note;
            $loan->loan_type    = 1;        /*1 for give and 2 for taken*/
            $loan->takenby      = $request->takenby;

           // $loan->save();

            /*      need to acount table */

            $data = AccountPaymentHistory::where('module_invoice_id',$loan->id)->where('module_id',5)->first();

            $data->account_id           = $request->account_id;
            $data->payment_method_id    = $request->payment_method_id;
            $data->payment_amount       = $request->amount;
            $data->client_supplier_id   = $request->customer_id;
            $data->description          = $request->note;
            $data->payment_date         = $request->loan_date;
            $data->payment_by           = Auth::user()->id;
            $data->created_by           = Auth::user()->id;
            $data->save();
            
                /*      need to acount History table */

            $detail =  AccountPaymentHistoryDetail::where('account_payment_history_id',$data->id)->first();

            $detail->account_id                     =  $data->account_id;
            $detail->payment_method_id              =  $data->payment_method_id;

            $detail->card_number                    =  $request->card_number;
            $detail->card_holder_name               =  $request->card_holder_name;
            $detail->card_transaction_no            =  $request->card_transaction_no;
            $detail->card_type                      =  $request->card_type;
            $detail->expire_month                   =  $request->expire_month;
            $detail->expire_year                    =  $request->expire_year;
            $detail->card_security_code             =  $request->card_security_code;
            $detail->from_mobile_banking_account    =  $request->from_mobile_banking_account;
            $detail->cheque_no                      =  $request->cheque_no;
            $detail->transfer_bank_account_no       =  $request->transfer_bank_account_no;
            $detail->transaction_no                 =  $request->transaction_no;
            $detail->payment_note                   =  $request->payment_note;
            $detail->payment_date                   =  $request->loan_date;
         
            $detail->save();


            DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollback();
                if($e->getMessage())
                {
                    $message = $e->getMessage();//"Something went wrong! Please Try again";
                }
                $notification = array(
                    'message' => 'Something Wrong!',
                    'alert-type' => 'error'
                );
                return redirect()->route()->back()->with($notification);
            }

            $notification = array(
                    'message' => 'Successfully customer Loan Update!',
                    'alert-type' => 'success'
            );
            return redirect()->route('customer.loan.index')->with($notification);

            
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
