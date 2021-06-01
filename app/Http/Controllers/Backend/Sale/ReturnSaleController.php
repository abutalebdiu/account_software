<?php

namespace App\Http\Controllers\Backend\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Backend\Sale\SaleFinal;
use App\Model\Backend\Sale\SaleDetail;
use App\Model\Backend\Sale\SaleReturnFinal;
use App\Model\Backend\Sale\SaleReturnDetail;
use App\Model\Backend\Customer\Customer;
use App\Traits\Sell\SaleCartTrait;
use Auth;
use DB;
use App\Model\Backend\Payment\PaymentMethod;
use App\Traits\Payment\AddPaymentTrait;
class ReturnSaleController extends Controller
{
    use SaleCartTrait;
    use AddPaymentTrait;
    
    
    
    public function index()
    {

        $data['salesreturns'] = SaleReturnFinal::latest()->get();
        return view('backend.sale.return.index',$data);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function returnSaleCreate($id)
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
        $data['cartName'] = $this->cartName;
        $data['customers']  = Customer::whereNull('deleted_at')->get();
        $data['payment_methods'] =  PaymentMethod::whereNull('deleted_at')->get();

        return view('backend.sale_pos.return.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function returnSaleStore(Request $request)
    {
        //return $request;
        // Start transaction!
        DB::beginTransaction();
        try {
                $final = $this->insertSalReturnFinalData($request);
                foreach ($request->return_quantity as $key => $returnQuantity)
                {
                    if($returnQuantity == 0 || $returnQuantity == NULL || $returnQuantity == "null" || $returnQuantity == "0" )continue;
                    $this->insertSaleReturnDetailData($final,$returnQuantity,$key,$request);

                    /*Addition Quantity in the Sale Stock*/
                    additionStockQuantity_HH(
                        $request->product_variation_id[$key],
                        $request->return_stock_id[$key],
                        $request->return_unit_id[$key],
                        $returnQuantity
                    );
                    /*Addition Quantity in the Sale Stock*/

                    subtractionFromSaleDetailsQuantity_HH(
                        $request->sale_final_id,
                        $request->product_variation_id[$key],
                        $request->return_unit_id[$key],
                        $returnQuantity
                    );
                }

                // payment method
                if($request->payment_method_id)
                {
                    $this->payment_reference_no     = "SRE".date("Y");
                    $this->module_id                = module_HH()['sale'];
                    $this->module_invoice_no        = $request->order_no;
                    $this->module_invoice_id        = $request->sale_final_id; 
                    $this->account_id               = $request->account_id;
                    $this->payment_method_id        = $request->payment_method_id;
                    $this->cdf_type_id              = cdf_HH()['debit'];
                    $this->payment_type_id          = payment_type_HH()['expense'];
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
                    $this->addPaymentWhenPurchase();
                }

                session(["saleReturnCart" => []]);
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
        return redirect()->route('sale.saleView')->with('success','Return Quantity Successfully!');
    }

    public function insertSalReturnFinalData($request)
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

        $data = new SaleReturnFinal();
        $data->business_location_id = 1;
        $data->business_type_id     = 1;
        $data->customer_id          = $request->customer_id;
        $data->sale_final_id        = $request->sale_final_id;
        $data->order_no             = $request->order_no;

        //$data->others_cost          = $request->others_cost;
        $data->discount_type        = $request->discount_type;
        $data->discount_value       = $request->discount_value;
        $data->discount_amount      = $request->discount_amount;

        $data->return_date          = $returnDate;
        $data->return_note          = $request->return_note;
        //$data->receive_note	        = $request->receive_note	;
        $data->receive_status       = 1;
        $data->return_request_status = 1;
        //$data->return_received_by   = $request->return_received_by;
        $data->created_by           = Auth::user()->id;
        $data->save();
        $data->return_invoice_no    = "00".$data->id;
        $data->save();
        return $data;
    }


    public function insertSaleReturnDetailData($final,$returnQuantity,$key,$request)
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

        $data = new SaleReturnDetail();
        $data->business_location_id = $final->business_location_id;
        $data->business_type_id     = $final->business_type_id;
        $data->sale_final_id        = $final->sale_final_id;
        $data->customer_id          = $final->customer_id;
        $data->sale_return_final_id = $final->id;
        $data->order_no             = $final->order_no;
        $data->return_invoice_no    = $final->return_invoice_no;
        $data->product_id           = $request->product_id[$key];
        $data->product_variation_id = $request->product_variation_id[$key];
        $data->return_quantity      = $returnQuantity;
        $data->return_unit_price    = $request->return_unit_price[$key];

        $data->sub_total            = number_format($returnQuantity *  $request->return_unit_price[$key],2,'.','');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
       public function show($id)
    {
       $data['salesreturn'] = SaleReturnFinal::find($id);
       return view('backend.sale.return.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
