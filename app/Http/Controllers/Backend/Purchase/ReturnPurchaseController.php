<?php

namespace App\Http\Controllers\Backend\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Backend\Purchase\PurchaseReturnFinal;
use App\Model\Backend\Purchase\PurchaseReturnDetail;

use App\Traits\Purchase\PurchaseAndPurchaseCartTrait;
use App\Traits\Stock\IncreDecreMentStockTrait;
use Auth;
use DB;
use App\Model\Backend\Payment\PaymentMethod;
use App\Traits\Payment\AddPaymentTrait;
class ReturnPurchaseController extends Controller
{
    use PurchaseAndPurchaseCartTrait;
    use IncreDecreMentStockTrait;
    use AddPaymentTrait;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   /*  public function returnSaleCreate($id)
    {
        session(["saleReturnCart" => []]);

        $data['sale_final'] = SaleFinal::find($id);
        $saleDetails        = SaleDetail::whereNull('deleted_at')->where('sale_final_id',$id)->get();
        foreach ($saleDetails as $key => $value)
        {
            $this->cartName         = "saleReturnCart";
            $this->product_var_id   = $value->product_variation_id;
            $this->saleDetails      = $value;
            $this->cartInsertUpdateWhenReturnOrEditSale();
        }
        $data['cartName']   = $this->cartName;
        $data['customers']  = Customer::whereNull('deleted_at')->get();
        return view('backend.sale_pos.return.create',$data);
    } */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function returnPurchaseStore(Request $request)
    {
        //return $request;
        // Start transaction!
        DB::beginTransaction();
        try {
                $final = $this->insertPurchaseReturnFinalData($request);
                foreach ($request->return_quantity as $key => $returnQuantity)
                {
                    if($returnQuantity == 0 || $returnQuantity == NULL || $returnQuantity == "null" || $returnQuantity == "0" )continue;
                    $this->insertPurchaseReturnDetailData($final,$returnQuantity,$key,$request);

                    /**purchase qty decrement from different stocks */
                    if($request->totalReceivedQuantity[$key] > 0 )
                    {
                        $this->stock_type_id        = $request->return_stock_type_id[$key];
                        $this->receivedQuantity     = $returnQuantity;
                        $this->stock_id             = $request->return_stock_id[$key];
                        $this->product_variation_id = $request->product_variation_id[$key];
                        $this->product_id           = $request->product_id[$key];
                        $this->defaultPurchaseUnitId = $request->return_unit_id[$key];
                        $this->decrementStockFromDifferentsStockWhenActionWithPurchaseDetails();
                    }
                    /**purchase qty decrement from different stocks */
                    
                    /**purchase qty decrement from purchase details */
                    $this->purchase_final_id    = $request->purchase_final_id;
                    $this->product_variation_id = $request->product_variation_id[$key];
                    $this->product_id           = $request->product_id[$key];
                    $this->quantity             = $returnQuantity;
                    $this->decrementPurchaseQuantityFromPurchaseDetails();
                    /**purchase qty decrement from purchase details */
                }

                // payment method
                if($request->payment_method_id)
                {
                    $this->payment_reference_no     = "PRI".date("Y");
                    $this->module_id                = module_HH()['purchase'];
                    $this->module_invoice_no        = $request->invoice_no;
                    $this->module_invoice_id        = $request->purchase_final_id; 
                    $this->account_id               = $request->account_id;
                    $this->payment_method_id        = $request->payment_method_id;
                    $this->cdf_type_id              = cdf_HH()['credit'];
                    $this->payment_type_id          = payment_type_HH()['income'];
                    $this->payment_amount           = $request->payment_amount;
                    $this->client_supplier_id       = $request->supplier_id;
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
                    $this->addPaymentWhenPurchase();
                }

                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollback();
                if($e->getMessage())
                {
                    $message = "Something went wrong! Please Try again";
                }
                return Redirect()->back()
                    ->with('error',$e->getMessage());
            }
        return redirect()->route('admin.purchase.index')->with('success','Return Quantity Successfully!');
    }

    public function insertPurchaseReturnFinalData($request)
    {
        if($request->return_date)
        {
            $y = substr($request->return_date,6);;
            $d =  substr($request->return_date,0,2);
            $m = substr($request->return_date,3,2);
            $mdate = $y."-".$m."-".$d;
            $returnDate =  date('Y-m-d',strtotime($mdate));
            $returnDate =  $request->return_date;
        }
        else{
            $returnDate =  date('Y-m-d h:i:s');
        }

        $data = new PurchaseReturnFinal();
        $data->business_location_id = 1;
        $data->business_type_id     = 1;
        $data->supplier_id          = $request->supplier_id;
        $data->purchase_final_id    = $request->purchase_final_id;
        $data->invoice_no             = $request->invoice_no;

        //$data->others_cost          = $request->others_cost;
        $data->discount_type        = $request->discount_type;
        $data->discount_value       = $request->discount_value;
        $data->discount_amount      = $request->discount_amount;

        $data->return_date          = $returnDate;
        $data->return_note          = $request->return_note;
        //$data->receive_note	        = $request->receive_note;
        $data->receive_status       = 1;
        $data->return_request_status = 1;
        //$data->return_received_by   = $request->return_received_by;
        $data->created_by           = Auth::user()->id;
        $data->save();
        $data->return_invoice_no    = "00".$data->id;
        $data->save();
        return $data;
    }


    public function insertPurchaseReturnDetailData($final,$returnQuantity,$key,$request)
    {
        if($request->return_date)
        {
            $y = substr($request->return_date,6);;
            $d =  substr($request->return_date,0,2);
            $m = substr($request->return_date,3,2);
            $mdate = $y."-".$m."-".$d;
            $returnDate =  date('Y-m-d',strtotime($mdate));
            $returnDate =  $request->return_date;
        }
        else{
            $returnDate =  date('Y-m-d h:i:s');
        }

        $data = new PurchaseReturnDetail();
        $data->business_location_id = $final->business_location_id;
        $data->business_type_id     = $final->business_type_id;
        $data->purchase_final_id    = $final->purchase_final_id;
        $data->supplier_id          = $final->supplier_id;
        $data->purchase_return_final_id = $final->id;
        $data->invoice_no           = $final->invoice_no;
        $data->return_invoice_no    = $final->return_invoice_no;
        $data->product_id           = $request->product_id[$key];
        $data->product_variation_id = $request->product_variation_id[$key];
        $data->return_quantity      = $returnQuantity;
        $data->return_unit_price_inc_tax = $request->return_unit_price_inc_tax[$key];

        $data->sub_total            = number_format($returnQuantity *  $request->return_unit_price_inc_tax[$key],2,'.','');
        $data->return_date          = $returnDate;
        //$data->return_status      = ;
        $data->return_unit_id       = $request->return_unit_id[$key];
        $data->return_stock_id      = $request->return_stock_id[$key];
        //$data->return_type_id       = $request->return_unit_price[$key];
        //$data->return_request_status= $request->return_unit_price[$key];
        $data->created_by           = Auth::user()->id;
        $data->save();
        return $data;
    }


}
