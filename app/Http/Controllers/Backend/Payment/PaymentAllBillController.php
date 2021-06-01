<?php

namespace App\Http\Controllers\Backend\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Payment\AddPaymentTrait;
use DB;
use App\Model\Backend\Customer\Customer;
use App\Model\Backend\Supplier;
use App\Model\Backend\Payment\PaymentMethod;
use App\Model\Backend\Payment\AccountPaymentHistory;
class PaymentAllBillController extends Controller
{
    use AddPaymentTrait;

    /**purchase bill */
    public function purchaseBill(Request $request)
    {
        $this->validate($request, [
            "payment_method_id" => "required",
            "payment_amount" => "required|numeric",
        ]);
        if($request->payment_amount == 0 || $request->payment_amount == NULL)return redirect()->back()->with([
            'alert-type' => 'error',
            'message' => 'Invalid Number!'
        ]);
            
        $status = NULL;
        // Start transaction!
        DB::beginTransaction();
        try
        {
            if($request->payment_method_id)
            {
                $this->payment_reference_no     = "PE".date("Y");
                $this->module_id                = module_HH()['purchase'];
                $this->module_invoice_no        = $request->module_invoice_no;
                $this->module_invoice_id        = $request->purchase_final_id;
                $this->account_id               = $request->account_id;
                $this->payment_method_id        = $request->payment_method_id;
                $this->cdf_type_id              = cdf_HH()['debit'];
                $this->payment_type_id          = payment_type_HH()['expense'];
                $this->payment_amount           = $request->payment_amount;
                $this->client_supplier_id       = $request->supplier_id;
                $this->payment_date             = $request->payment_date;
                //$this->description              = 'purchase' . ;

                $this->card_number              = $request->card_number;
                $this->card_holder_name         = $request->card_holder_name;
                $this->card_transaction_no      = $request->card_transaction_no;
                $this->card_type                = $request->card_type;
                $this->expire_month             = $request->expire_month;
                $this->expire_year              = $request->expire_year;
                $this->card_security_code       = $request->card_security_code;
                $this->from_mobile_banking_account  = $request->from_mobile_banking_account;
                $this->cheque_no                = $request->cheque_no;
                $this->transfer_bank_account_no = $request->transfer_bank_account_no;
                $this->transaction_no           = $request->transaction_no;
                $this->payment_note             = $request->payment_note;
                $this->addPaymentWhenPurchase();
                $status = 1;
            }
            if($status)
            {
                DB::commit();
                return redirect()->back()->with([
                    'alert-type' => 'success',
                    'message' => 'Payment Successful!'
                ]);
            }else{
                return redirect()->back()->with([
                    'alert-type' => 'error',
                    'message' => 'Not Payment!'
                ]);
            }
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

    /**Sale Receive Bill */
    public function saleReceiveBill(Request $request)
    {
        $this->validate($request, [
            "payment_method_id" => "required",
            "payment_amount" => "required|numeric",
        ]);
        if($request->payment_amount == 0 || $request->payment_amount == NULL)return redirect()->back()->with([
            'alert-type' => 'error',
            'message' => 'Invalid Number!'
        ]);
            
        $status = NULL;
        // Start transaction!
        DB::beginTransaction();
        try
        {
            if($request->payment_method_id)
            {
                $this->payment_reference_no     = "SI".date("Y");
                $this->module_id                = module_HH()['sale'];
                $this->module_invoice_no        = $request->module_invoice_no;
                $this->module_invoice_id        = $request->sale_final_id;
                $this->account_id               = $request->account_id;
                $this->payment_method_id        = $request->payment_method_id;
                $this->cdf_type_id              = cdf_HH()['credit'];
                $this->payment_type_id          = payment_type_HH()['income'];
                $this->payment_amount           = $request->payment_amount;
                $this->client_supplier_id       = $request->customer_id;
                $this->payment_date             = $request->payment_date;
                //$this->description              = 'Sale' . ;

                $this->card_number              = $request->card_number;
                $this->card_holder_name         = $request->card_holder_name;
                $this->card_transaction_no      = $request->card_transaction_no;
                $this->card_type                = $request->card_type;
                $this->expire_month             = $request->expire_month;
                $this->expire_year              = $request->expire_year;
                $this->card_security_code       = $request->card_security_code;
                $this->from_mobile_banking_account  = $request->from_mobile_banking_account;
                $this->cheque_no                = $request->cheque_no;
                $this->transfer_bank_account_no = $request->transfer_bank_account_no;
                $this->transaction_no           = $request->transaction_no;
                $this->payment_note             = $request->payment_note;
                $this->addPaymentWhenSale();
                $status = 1;
            }
            if($status)
            {
                DB::commit();
                return redirect()->back()->with([
                    'alert-type' => 'success',
                    'message' => 'Payment Successful!'
                ]);
            }else{
                return redirect()->back()->with([
                    'alert-type' => 'error',
                    'message' => 'Not Payment!'
                ]);
            }
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



    /*
    |-----------------------------------------------------------------------------------------------
    |   Receive Previous sale Bill From Customer 
    |-----------------------------------------------------------------------------------------------
    */
        /**Receive Previous Bill List From Customer */
        public function receiveListPreviousBill()
        {
            $data['payments']  = AccountPaymentHistory::whereNull('deleted_at')
                                ->where('module_id',module_HH()['sale previous bill'])
                                ->latest()
                                ->get();
            return view('backend.payment.receive_previous_bill.receive_bill_list',$data);
        }

        /**Receive Previous Bill  From Customer */
        public function receivePreviousBill()
        {
            $data['payment_methods']   = PaymentMethod::whereNull('deleted_at')->get();
            $data['customers']          = Customer::latest()->get();
            return view('backend.payment.receive_previous_bill.customer_bill',$data);
        }

        /**Customer Previous due amount*/
        public function salePreviousDueAmount(Request $request)
        {
            if($request->id)
            {
                $customer          = Customer::findOrfail($request->id);
                return $customer?$customer->totalPreviousDueAmount():0.0;
            }else{
                return 0.0;
            }
        }

        /**Customer Previous due amount*/
        public function storeReceivePreviousBill(Request $request)
        {
            $this->validate($request, [
                "payment_method_id" => "required",
                "payment_amount" => "required|numeric",
            ]);
            if($request->payment_amount == 0 || $request->payment_amount == NULL)return redirect()->back()->with([
                'alert-type' => 'error',
                'message' => 'Invalid Number!'
            ]);
            
            $status = NULL;
            // Start transaction!
            DB::beginTransaction();
            try
            {
                if($request->payment_method_id)
                {
                    $this->payment_reference_no     = "SPDI".date("Y");
                    $this->module_id                = module_HH()['sale previous bill'];
                    $this->module_invoice_no        = "Previous";//$request->module_invoice_no;
                    $this->module_invoice_id        = NULL;//$request->sale_final_id;
                    $this->account_id               = $request->account_id;
                    $this->payment_method_id        = $request->payment_method_id;
                    $this->cdf_type_id              = cdf_HH()['credit'];
                    $this->payment_type_id          = payment_type_HH()['income'];
                    $this->payment_amount           = $request->payment_amount;
                    $this->client_supplier_id       = $request->client_supplier_id;
                    $this->payment_date             = $request->payment_date;
                    //$this->description              = 'Sale' . ;

                    $this->card_number              = $request->card_number;
                    $this->card_holder_name         = $request->card_holder_name;
                    $this->card_transaction_no      = $request->card_transaction_no;
                    $this->card_type                = $request->card_type;
                    $this->expire_month             = $request->expire_month;
                    $this->expire_year              = $request->expire_year;
                    $this->card_security_code       = $request->card_security_code;
                    $this->from_mobile_banking_account  = $request->from_mobile_banking_account;
                    $this->cheque_no                = $request->cheque_no;
                    $this->transfer_bank_account_no = $request->transfer_bank_account_no;
                    $this->transaction_no           = $request->transaction_no;
                    $this->payment_note             = $request->payment_note;
                    $this->addPaymentWhenSale();
                    $status = 1;
                }
                if($status)
                {
                    DB::commit();
                    return redirect()->route('admin.receiveListPreviousBill')->with([
                        'alert-type' => 'success',
                        'message' => 'Payment Receive Successful!'
                    ]);
                }else{
                    return redirect()->back()->with([
                        'alert-type' => 'error',
                        'message' => 'Not Payment!'
                    ]);
                }
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
    /*
    |-----------------------------------------------------------------------------------------------
    |   Receive Previous sale Bill From Customer 
    |-----------------------------------------------------------------------------------------------
    */

    
    /*
    |-----------------------------------------------------------------------------------------------
    |   Pay Previous Purchase Bill TO  Supplier 
    |-----------------------------------------------------------------------------------------------
    */
        /**Paid  Previous Bill List To Supplier */
        public function payPreviousPurchaseBillList()
        {
            $data['payments']  = AccountPaymentHistory::whereNull('deleted_at')
                                ->where('module_id',module_HH()['purchase previous bill'])
                                ->latest()
                                ->get();
            return view('backend.payment.pay_previous_bill.paid_previous_bill_list',$data);
        }


        /**Pay Previous Bill From Supplier */
        public function payPreviousPurchaseBill()
        {
            $data['payment_methods']   = PaymentMethod::whereNull('deleted_at')->get();
            $data['suppliers']         = Supplier::latest()->get();
            return view('backend.payment.pay_previous_bill.purchase_bill',$data);
        }

        /**Supplier Previous due amount*/
        public function purchasePreviousDueAmount(Request $request)
        {
            if($request->id)
            {
                $supplier          = Supplier::findOrfail($request->id);
                return $supplier?$supplier->totalPreviousDueAmount():0.0;
            }else{
                return 0.0;
            }
        }

        /**Supplier Previous due amount*/
        public function storePayPreviousPurchaseBill(Request $request)
        {
            $this->validate($request, [
                "payment_method_id" => "required",
                "payment_amount" => "required|numeric",
            ]);

            if($request->payment_amount == 0 || $request->payment_amount == NULL)return redirect()->back()->with([
                'alert-type' => 'error',
                'message' => 'Invalid Amount!'
            ]);
            
            $status = NULL;
            // Start transaction!
            DB::beginTransaction();
            try
            {
                if($request->payment_method_id)
                {
                    $this->payment_reference_no     = "PPDE".date("Y");
                    $this->module_id                = module_HH()['purchase previous bill'];
                    $this->module_invoice_no        = "Previous Due Bill";
                    $this->module_invoice_id        = NULL;//;
                    $this->account_id               = $request->account_id;
                    $this->payment_method_id        = $request->payment_method_id;
                    $this->cdf_type_id              = cdf_HH()['debit'];
                    $this->payment_type_id          = payment_type_HH()['expense'];
                    $this->payment_amount           = $request->payment_amount;
                    $this->client_supplier_id       = $request->client_supplier_id;
                    $this->payment_date             = $request->payment_date;
                    //$this->description              = 'purchase' . ;
    
                    $this->card_number              = $request->card_number;
                    $this->card_holder_name         = $request->card_holder_name;
                    $this->card_transaction_no      = $request->card_transaction_no;
                    $this->card_type                = $request->card_type;
                    $this->expire_month             = $request->expire_month;
                    $this->expire_year              = $request->expire_year;
                    $this->card_security_code       = $request->card_security_code;
                    $this->from_mobile_banking_account  = $request->from_mobile_banking_account;
                    $this->cheque_no                = $request->cheque_no;
                    $this->transfer_bank_account_no = $request->transfer_bank_account_no;
                    $this->transaction_no           = $request->transaction_no;
                    $this->payment_note             = $request->payment_note;
                    $this->addPaymentWhenPurchase();
                    $status = 1;
                }
                if($status)
                {
                    DB::commit();
                    return redirect()->route('admin.payPreviousPurchaseBillList')->with([
                        'alert-type' => 'success',
                        'message' => 'Payment Successful!'
                    ]);
                }else{
                    return redirect()->back()->with([
                        'alert-type' => 'error',
                        'message' => 'Not Payment!'
                    ]);
                }
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
    /*
    |-----------------------------------------------------------------------------------------------
    |  Pay Previous Purchase Bill TO  Supplier 
    |-----------------------------------------------------------------------------------------------
    */
}
