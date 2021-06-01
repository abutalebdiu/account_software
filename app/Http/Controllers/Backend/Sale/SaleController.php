<?php

namespace App\Http\Controllers\Backend\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
//use App\Models\Customer;

use App\Model\Backend\Customer\Customer;

use App\Model\Backend\Sale\SaleFinal;
use App\Model\Backend\Sale\SaleDetail;

use App\Models\Backend\Sale\Sale_warranty_guarantee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Model\Backend\Product\ProductVariation;
use App\Model\Backend\Unit\Unit;
use App\Model\Backend\Stock\PrimaryStock;
use App\Model\Backend\Stock\Stock;
use Validator;

use App\Model\Backend\Payment\Bank;
use App\Model\Backend\Payment\PaymentMethod;

use App\Model\Backend\Payment\AccountPaymentHistory;
use App\Model\Backend\Quotation\QuotationInvoice;

use App\Traits\Sell\SaleCartTrait;
use App\Traits\Stock\IncreDecreMentStockTrait;
use App\Traits\Payment\AddPaymentTrait;
use App\Backend\Reference;
class SaleController extends Controller
{
    use SaleCartTrait;
    use IncreDecreMentStockTrait;
    use AddPaymentTrait;

    public function index()
    {
        $data['sales'] = SaleFinal::whereNull('deleted_at')->where('invoice_status',1)->where('business_location_id',1)->latest()->get();
        return view('backend.sale_pos.view.index',$data);
    }


    public function createPos()
    {
        //session(['cartName' => []]);
        $data['products']   = ProductVariation::whereNull('deleted_at')->latest()->get();
        $data['references'] = Reference::latest()->get();
        $data['categories'] = Category::latest()->get();
        $data['customers']  = Customer::whereNull('deleted_at')->get();
        return view('backend.sale_pos.create',$data);
    }


    public function productListByAjax(Request $request)
    {
        $search = $request->pNameSkuBarCodeAsCodeCCode;
        $query =  ProductVariation::query();
        $query->join('products','products.id','=','product_variations.product_id');

        if($request->cat_id != "all" && $request->cat_id)
        {
            $query->where('products.category_id',$request->cat_id);
            //$cat_id = $request->cat_id;
            //$query->where(function($q) use ( $cat_id ){
                //return $q->where('products.category_id',$cat_id);
            //});  
        }

        if($search)
        {
            $query->where('products.name','like','%'.$search.'%');

            $query->orWhere(function($q)use ($search){
                return  $q->orWhere('products.sku','like','%'.$search.'%');
                });

            $query->orWhere(function($q)use ($search){
                return $q->orWhere('products.bar_code','like','%'.$search.'%');
            });
            $query->orWhere(function($q)use ($search){
                return $q->orWhere('products.company_code','like','%'.$search.'%');
            });
            $query->orWhere(function($q)use ($search){
                return $q->orWhere('products.custom_code','like','%'.$search.'%');
            });
        }

        $query->select('product_variations.*','product_variations.id as productVarId',
            'products.id as productId','products.name as productName','products.brand_id','products.category_id',
            'products.product_sku as sku','products.custom_code as ascode','products.company_code as ccode','products.grade_type_id as grade'
        );

       
        $data['selected_cat_id'] = $request->cat_id;
        $data['products']  = $query->latest()->paginate(62);

        //$data['products']   = ProductVariation::whereNull('deleted_at')->latest()->paginate(24);
        $data['categories'] = Category::latest()->get();
        $html =  view('backend.sale_pos.ajax.product_list.product_list',$data)->render();
        return response()->json([
            'status' => true,
            'data' => $html
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }




    /*Store From Add To Cart With Payment Modal, Working Properly*/
    public function storeFromAddToCartWithPayment(Request $request)
    {
        //return $request;
        $input = $request->except('_token');
        $validator = Validator::make($input,[
            //'sale_date'             => 'required|min:10:max:10',
            'customer_id'               => 'required',
            'final_sub_total_amount'    => 'required',
            //'order_no'              => 'required|min:2|max:30',
            'product_id.*'              => 'required|max:100',
            //'description.*'         => 'nullable|max:100',
            'phone'                     => $request->invoice_status == 2 ? 'required|min:6|max:20' : 'nullable',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->final_sub_total_amount < 1)
        {
            return redirect()->back()->with('error','Something went wrong!');
        }
        /*
            $y = substr($request->sale_date,6);;
            $d =  substr($request->sale_date,0,2);
            $m = substr($request->sale_date,3,2);
            $date = $y."-".$m."-".$d;
            $sale_date =  date('Y-m-d',strtotime($date));
        */
        $sale_date =  date('Y-m-d h:s:i');
        // Start transaction!
        DB::beginTransaction();
        try {
                $data = new SaleFinal();
                $data->invoice_status       = $request->invoice_status;
                $data->business_location_id = 1;
                $data->business_type_id     = 1;
                $data->customer_id          = $request->customer_id;
                $data->reference_id         = $request->reference_id;
                $data->discount_type        = $request->final_discount_type;
                $data->discount_value       = $request->final_discount_value;
                $data->discount_amount      = $request->final_discount_amount;
                $data->shipping_cost        = $request->fianl_other_cost;
                $data->sale_date            = $sale_date;
                $data->created_by           = Auth::user()->id;
                $save                       = $data->save();
                $data->order_no             = "00".$data->id;
                $data->save();
                if($save)
                {
                    if($request->product_id)
                    {
                        foreach ($request->product_id as $key => $product)
                        {
                            $productSingle = ProductVariation::find($product);
                            $disAmount = 0;
                            if($request->discount_type[$key] == 'percentage')
                            {
                                $disAmount = (($request->quantity[$key] * $request->sale_price[$key]) * $request->discount_value[$key]) /100 ;
                            }
                            else{
                                $disAmount = $request->discount_value[$key];
                            }
                            $sale_detail                    =  new SaleDetail();
                            $sale_detail->invoice_status    = $request->invoice_status;
                            $sale_detail->business_location_id = 1;
                            $sale_detail->business_type_id  = 1;
                            $sale_detail->sale_final_id     = $data->id;
                            $sale_detail->customer_id       = $request->customer_id;
                            $sale_detail->reference_id      = $request->reference_id;
                            $sale_detail->order_no          = $data->order_no;

                            $sale_detail->product_id        = $productSingle?$productSingle->product_id:NULL;
                            $sale_detail->product_variation_id = $product;
                            $sale_detail->quantity          = $request->quantity[$key];
                            $sale_detail->unit_price        = $request->sale_price[$key];
                            $sale_detail->discount_type     = $request->discount_type[$key];
                            $sale_detail->discount_value    = $request->discount_value[$key];
                            $sale_detail->discount_amount   = $disAmount;
                            $sale_detail->sub_total         = ($request->product_sub_Total_sale_amount[$key]);
                            $sale_detail->sale_date         = $sale_date;
                            //$sale_detail->description      = $request->description[$key];
                            $sale_detail->created_by        = Auth::user()->id;

                            $sale_type_id                   = $request->sale_type_id[$key];
                            $stock_id                       = $request->sale_from_stock_id[$key];
                            $sale_unit_id                   = $request->sale_unit_id[$key];

                            $sale_detail->purchase_price    = $request->purchase_price[$key];

                            $sale_detail->sale_from_stock_id= $stock_id;
                            $sale_detail->sale_unit_id      = $sale_unit_id;
                            $sale_detail->sale_type_id      = $sale_type_id;
                            $sale_detail->save();

                            if($request->invoice_status == 1)
                            {
                                subtractionStockQuantity_HH($product,$stock_id,$sale_unit_id,$request->quantity[$key]);
                            }

                            if($request->identity_number[$key])
                            {
                                $productFind = Product::find($productSingle?$productSingle->product_id:NULL);
                                $wG_type = "";
                                if($productFind)
                                {
                                    if($productFind->warranty_period)
                                    {
                                        $wG_type = "warranty";
                                    }
                                    else if($productFind->guarantee_period)
                                    {
                                        $wG_type = "guarantee";
                                    }else{
                                        $wG_type = "";
                                    }
                                }
                                $warranty_guarantee                             =  new Sale_warranty_guarantee();
                                $warranty_guarantee->sale_final_id              = $data->id;
                                //$warranty_guarantee->sale_detail_id             = $sale_detail->id;
                                $warranty_guarantee->product_variation_id       = $product;
                                $warranty_guarantee->product_id                 = $productSingle?$productSingle->product_id:NULL;
                                $warranty_guarantee->sale_date                  = $sale_date;
                                $warranty_guarantee->warranty_guarantee_type    = $wG_type ;
                                $warranty_guarantee->quantity                   = $request->quantity[$key];
                                $warranty_guarantee->identity_number            = $request->identity_number[$key];
                                $warranty_guarantee->save();
                            }
                        }//foreach end
                    } //if product have end

                    // payment method
                    if($request->payment_method_id)
                    {
                        $this->payment_reference_no     = "SI".date("Y");
                        $this->module_id                = module_HH()['sale'];
                        $this->module_invoice_no        = $data->order_no;
                        $this->module_invoice_id        = $data->id;
                        $this->account_id               = $request->account_id;
                        $this->payment_method_id        = $request->payment_method_id;
                        $this->cdf_type_id              = cdf_HH()['credit'];
                        $this->payment_type_id          = payment_type_HH()['income'];
                        $this->payment_amount           = $request->paid_amount;
                        $this->client_supplier_id       = $data->customer_id;
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
                    }

                    /**Make Quotation */
                    if($request->invoice_status == 2)
                    {
                       $quotation =  new QuotationInvoice();
                       $quotation->sale_final_id    = $data->id;
                       $quotation->order_no         = $data->order_no;
                       $quotation->customer_name    = $request->customer_name;
                       $quotation->phone            = $request->phone;
                       $quotation->quotation_no     = $request->quotation_no;
                       $quotation->validate_date    = $request->validate_date;
                       $quotation->quotation_note   = $request->quotation_note;
                       $quotation->quotation_date   = $data->sale_date;
                       $quotation->created_by       = Auth::user()->id;
                       $quotation->save();
                    }
                    /**Make Quotation */

                }//save if end
                session(['cartName' => []]);
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

        $data['saleFinal']  = SaleFinal::findOrfail($data->id);
        if($data['saleFinal']->invoice_status == 1)
        {
            return view('backend.sale_pos.print.invoice.invoice',$data);
        }
        elseif($data['saleFinal']->invoice_status == 2)
        {
            return view('backend.sale_pos.print.invoice.quotation_invoice',$data);
        }

        return redirect()->back()->with('success','Sale Added Successfully!');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saleSingleShow(Request $request)
    {
        $data['saleFinal']  = SaleFinal::findOrfail($request->id);
        return view('backend.sale_pos.show.show',$data);
    }

    //print invoice
    public function saleSingleInvoicePrint(Request $request)
    {
        $data['saleFinal']  = SaleFinal::findOrfail($request->id);

        if($data['saleFinal']->invoice_status == 1)
        {
            return view('backend.sale_pos.print.invoice.invoice',$data);
        }
        elseif($data['saleFinal']->invoice_status == 2)
        {
            return view('backend.sale_pos.print.invoice.quotation_invoice',$data);
        }

        return view('backend.sale_pos.print.invoice.invoice',$data);
    }




    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPos($id)
    {
        session(["saleEditCart" => []]);
        $data['sale_final'] = SaleFinal::find($id);
        $data['customers']  = Customer::whereNull('deleted_at')->get();
        $data['references'] = Reference::latest()->get();
        return view('backend.sale_pos.edit.edit',$data);
    }


    /*Store From Add To Cart With Payment Modal, Working Properly*/
    public function storeFromSaleUpdateFromSaleEditCart(Request $request)
    {
        /*
            $y = substr($request->sale_date,6);;
            $d =  substr($request->sale_date,0,2);
            $m = substr($request->sale_date,3,2);
            $date = $y."-".$m."-".$d;
            $sale_date =  date('Y-m-d',strtotime($date));
        */
        $sale_date =  date('Y-m-d h:s:i a');
        // Start transaction!
        DB::beginTransaction();
        try {

            $final = SaleFinal::findOrFail($request->sale_final_id);
            /** Delete All previous data from sale , sale details, and others tables */
            foreach ($final->saleDetails?? NULL as $key => $value)
            {
                $this->product_variation_id = $value->product_variation_id;
                $this->quantity             = $value->quantity;
                $this->sale_unit_id         = $value->sale_unit_id;
                $this->stock_id             = $value->sale_from_stock_id;
                if($final->invoice_status == 1)
                {
                    $this->incrementStockQuantityToPrimaryStock();
                }
                $value->delete();
            }
            foreach ($final->saleReturnDetails?? NULL as $key => $valueReturn)
            {
                $valueReturn->deleted_at = date('Y-m-d h:i:s');
                $valueReturn->save();
            }
            foreach ($final->saleReturnFinals?? NULL as $key => $valueReturnFnl)
            {
                $valueReturnFnl->deleted_at = date('Y-m-d h:i:s');
                $valueReturnFnl->save();
            }
            foreach ($final->payments?? NULL as $key => $payment)
            {
                $payment->deleted_at = date('Y-m-d h:i:s');
                $payment->save();
            }
            /** Delete All previous data from sale , sale details, and others tables */

            // update sale table
            $final->invoice_status       = $request->invoice_status;
            $final->business_location_id = 1;
            $final->business_type_id     = 1;
            $final->customer_id          = $request->customer_id;
            $final->reference_id         = $request->reference_id;

            $final->discount_type        = $request->discount_type;
            $final->discount_value       = $request->discount_value;
            $final->discount_amount      = $request->discount_amount;
            $final->shipping_cost        = $request->shipping_cost;

            $final->sale_date            = $request->invoice_status == 1? $sale_date : $final->sale_date;
            $final->created_by           = $request->invoice_status == 1?  Auth::user()->id : $final->created_by;
            $save                        = $final->save();

            if($save)
            {
                if($request->product_variation_id)
                {
                    foreach ($request->product_variation_id as $key => $productVId)
                    {
                        $productSingle = ProductVariation::find($productVId);
                        /* $disAmount = 0;
                        if($request->discount_type[$key] == 'percentage')
                        {
                            $disAmount = (($request->new_quantity[$key] * $request->unit_price[$key]) * $request->discount_value[$key]) /100 ;
                        }
                        else{
                            $disAmount = $request->discount_value[$key];
                        } */
                        $sale_detail                    =  new SaleDetail();
                        $sale_detail->invoice_status    = $request->invoice_status;
                        $sale_detail->business_location_id = 1;
                        $sale_detail->business_type_id  = 1;
                        $sale_detail->sale_final_id     = $final->id;
                        $sale_detail->customer_id       = $request->customer_id;
                        $sale_detail->reference_id      = $request->reference_id;
                        $sale_detail->order_no          = $final->order_no;

                        $sale_detail->product_id        = $productSingle?$productSingle->product_id:NULL;
                        $sale_detail->product_variation_id = $productVId;

                        $sale_detail->quantity          = $request->new_quantity[$key];
                        $sale_detail->unit_price        = $request->unit_price[$key];
                        $sale_detail->discount_type     = $request->discountType[$key];
                        $sale_detail->discount_value    = $request->discountValue[$key];
                        $sale_detail->discount_amount   = $request->discountAmount[$key];

                        $sale_detail->purchase_price    = $request->purchase_price[$key];

                        $sale_detail->sub_total         = ($request->sub_total[$key]);
                        $sale_detail->sale_date         = $sale_date;
                        //$sale_detail->description      = $request->description[$key];
                        $sale_detail->created_by        = Auth::user()->id;

                        $sale_type_id                   = $request->sale_type_id[$key];
                        $stock_id                       = $request->sale_from_stock_id[$key];
                        $sale_unit_id                   = $request->sale_unit_id[$key];

                        $sale_detail->sale_from_stock_id= $stock_id;
                        $sale_detail->sale_unit_id      = $sale_unit_id;
                        $sale_detail->sale_type_id      = $sale_type_id;

                        $sale_detail->save();

                        if($request->invoice_status == 1)
                        {
                            subtractionStockQuantity_HH($productVId,$stock_id,$sale_unit_id,$request->quantity[$key]);
                        }


                        if($request->identity_number[$key])
                        {
                            $productFind = Product::find($product_id[$key]);
                            $wG_type = "";
                            if($productFind)
                            {
                                if($productFind->warranty_period)
                                {
                                    $wG_type = "warranty";
                                }
                                else if($productFind->guarantee_period)
                                {
                                    $wG_type = "guarantee";
                                }else{
                                    $wG_type = "";
                                }
                            }

                            $warranty_guarantee                             =  new Sale_warranty_guarantee();
                            $warranty_guarantee->sale_final_id              = $data->id;
                            $warranty_guarantee->sale_detail_id             = $sale_detail->id;
                            $warranty_guarantee->product_id                 = $product;
                            $warranty_guarantee->product_variation_id       = $productVId;
                            $warranty_guarantee->sale_date                  = $sale_date;
                            $warranty_guarantee->warranty_guarantee_type    = $wG_type ;
                            $warranty_guarantee->quantity                   = $request->quantity[$key];
                            $warranty_guarantee->identity_number            = $request->identity_number[$key];;
                            $warranty_guarantee->save();
                        }
                    }//foreach end
                } //if product have end

                if($final->quotationInvoices)
                {
                    $final->quotationInvoices->delete();
                }

            }//save if end
            session(["saleEditCart" => []]);
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
        return redirect()->route('sale.saleView')->with('success','Sale Updated Successfully!');
        // session(['cartName' => []]);
    }



    public function edit($id)
    {
        //
    }


    public function duplicateSale($id)
    {
        $finalSale = SaleFinal::where('id', $id)->whereNull('deleted_at')->first();
        DB::beginTransaction();
        try
        {
            $newSaleFinal = $finalSale->replicate();
            $newSaleFinal->save();
            $newSaleFinal->order_no     = "00".$newSaleFinal->id;
            $newSaleFinal->created_by   = Auth::user()->id;
            $newSaleFinal->sale_date    = date("Y-m-d h:i:s");
            $newSaleFinal->save();

            foreach ($finalSale->saleDetails as $detail) {
                $newDetail = SaleDetail::find($detail->id)->replicate();
                $newDetail->order_no = $newSaleFinal->order_no;
                $newDetail->sale_final_id   = $newSaleFinal->id;
                $newDetail->return_quantity = NULL;
                $newDetail->created_by      = Auth::user()->id;
                $newDetail->sale_date       = date("Y-m-d h:i:s");
                $newDetail->save();
                if($newSaleFinal->invoice_status == 1)
                {
                    subtractionStockQuantity_HH($newDetail->product_variation_id,$newDetail->sale_from_stock_id,$newDetail->sale_unit_id,$newDetail->quantity);
                }
            }

            DB::commit();
            return redirect()->back()->with([
                'alert-type' => 'success',
                'message' => 'Sale Duplicated Successful!'
            ]);
        }
        catch(\Exception $e)
        {
            dd($e);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSale(Request $request)
    {
        // Start transaction!
        DB::beginTransaction();
        try
        {
            $final = SaleFinal::findOrFail($request->id);
            foreach ($final->saleDetails?? NULL as $key => $value)
            {
                $this->product_variation_id = $value->product_variation_id;
                $this->quantity             = $value->quantity;
                $this->sale_unit_id = $value->sale_unit_id;
                $this->stock_id     = $value->sale_from_stock_id;
                if($final->invoice_status == 1)
                {
                    $this->incrementStockQuantityToPrimaryStock();
                }
                $value->deleted_at = date('Y-m-d h:i:s');
                $value->save();
            }
            foreach ($final->saleReturnDetails?? NULL as $key => $valueReturn)
            {
                $valueReturn->deleted_at = date('Y-m-d h:i:s');
                $valueReturn->save();
            }

            foreach ($final->saleReturnFinals?? NULL as $key => $valueReturnFnl)
            {
                $valueReturnFnl->deleted_at = date('Y-m-d h:i:s');
                $valueReturnFnl->save();
            }

            foreach ($final->payments?? NULL as $key => $payment)
            {
                $payment->deleted_at = date('Y-m-d h:i:s');
                $payment->save();
            }
            $final->deleted_at = date('Y-m-d h:i:s');
            $final->save();
            DB::commit();
            return $final;
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
        //return redirect()->back()->with('success','Sale Added Successfully!');
    }



    public function addSinglePayment(Request $request)
    {
        $data['saleFinal']          =  SaleFinal::findOrFail($request->id);
        $data['banks']              = Bank::get();
        $data['payment_methods']    = PaymentMethod::whereNull('deleted_at')->get();
        return view('backend.payment_modal.sale_add',$data);
    }

    public function viewSinglePayment(Request $request)
    {
        $data['saleFinal']          = SaleFinal::findOrFail($request->id);
        $data['banks']              = Bank::get();
        $data['payment_methods']    = PaymentMethod::whereNull('deleted_at')->get();
        return view('backend.payment_modal.sale_view',$data);
    }


    /**single payment delete */
    public function saleSinglePaymentDelete(Request $request)
    {
        //$id             = $request->id;
        //$sale_final_id  = $request->sale_final_id;
        $payment = AccountPaymentHistory::findOrfail($request->id);
        $payment->deleted_at = date('Y-m-d h:i:s');
        $payment->save();
        return true;
    }


    public function destroy($id)
    {
            /*Addition Quantity in the Sale Stock*/
            /* $this->sale_final_id        = $final->id;
            $this->product_variation_id = $value->product_variation_id;
            $this->sale_detail_id       = $value->id;
            $this->quantity             = $value->quantity;
            $this->decrementStoctFromSaleDetails();*/
            /*Addition Quantity in the Sale Stock*/
    }











    /*
    |------------------------------------------------------------------
    | Product Search and Add to cart by name,sku,barcode
    |------------------------------------------------------------
    */
        public function searchProductByNameSkuBarCodeForAddToCartWhenSaleCreate(Request $request)
        {
            $search = $request->pNameSkuBarCode;
            $query =  ProductVariation::query();
            $query->join('products','products.id','=','product_variations.product_id');

            $query->where('products.name','like','%'.$search.'%');
                $query->orWhere(function($q)use ($search){
                    return  $q->orWhere('products.sku','like','%'.$search.'%');
                    });
                $query->orWhere(function($q)use ($search){
                return $q->orWhere('products.bar_code','like','%'.$search.'%');
                });
                $query->select('product_variations.*','product_variations.id as productVarId',
                    'products.id as productId','products.name as productName','products.brand_id','products.category_id',
                    'products.product_sku as sku'
                );
            $count = $query->count();
            /*
                if($count == 1)
                {
                    //make cart
                    $productVariation =  $query->first();
                    $this->cartName         = "cartName";
                    $this->productVariations = $productVariation;
                    $this->product_var_id   = $productVariation->id;
                    $this->discountType     = 'fixed';
                    $this->discountValue    = 0;
                    $this->discount_amount  = 0;
                    $this->sale_unit_price  = $productVariation->default_selling_price;
                    $this->identityNumber   = "";
                    $this->quantity         = 1;
                    $this->sale_from_stock_id = 2;
                    $this->sale_type_id    = 1;
                    $this->sale_unit_id    = $productVariation->default_sale_unit_id;
                    $this->sub_total       = $productVariation->default_selling_price;
                    $this->selling_unit_name = $productVariation->defaultSaleUnits?$productVariation->defaultSaleUnits->short_name:NULL;
                    $checkQty = $this->checkQuantityIsAbailableOrNot($productVariation->id,2,$productVariation->default_sale_unit_id);
                    if($checkQty)
                    {
                        $this->inserInToCartWhenSearchSingleProductBySkuBarCodePnameDuringSaleCreate();
                    }
                    $data['cartName'] = $this->cartName ;

                    $html =  view('backend.sale_pos.ajax.add_to_cart_show')->render();
                    return response()->json([
                            'status'    => true,
                            'match'     =>'single',
                            'qty_status'=> $checkQty,
                            'data'      => $html
                        ]);

                }else if($count > 1){
                    // show dropdown list
                    $products = $query->get();
                    $output = '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display:block;position:relation;">';
                    foreach($products as $product)
                    {
                        $sizeName = NULL;$weightName = NULL;$colorName = NULL;
                        if($product->sizes) $sizeName = " - ".$product->sizes->name;
                        if($product->colors) $colorName = " - ".$product->colors->name;
                        if($product->weights) $weightName = " - ".$product->weights->name;
                        $productName = $product->productName . $sizeName . $colorName . $weightName;

                        $output .='<li><a href="#" data-id="'.$product->productVarId.'" class="dropdown-item dropdown_class">'.$productName.'</a> </li>';
                    }
                    $output .= "</ul>";
                    //return $output;
                    return response()->json([
                        'status'    => true,
                        'match'     =>'multiple',
                        'data'      => $output
                    ]);
                }
                else{
                    return false;
                }
            */

            // show dropdown list
            $products = $query->get();
            $output = '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="display:block;position:relation;">';
            foreach($products as $product)
            {
                $sizeName = NULL;$weightName = NULL;$colorName = NULL;
                if($product->sizes) $sizeName = " - ".$product->sizes->name;
                if($product->colors) $colorName = " - ".$product->colors->name;
                if($product->weights) $weightName = " - ".$product->weights->name;
                $productName = $product->productName . $sizeName . $colorName . $weightName;

                $output .='<li><a href="#" data-id="'.$product->productVarId.'" class="dropdown-item dropdown_class">'.$productName.'</a> </li>';
            }
            $output .= "</ul>";
            //return $output;
            return response()->json([
                'status'    => true,
                'match'     =>'multiple',
                'data'      => $output
            ]);
        }

        public function addToCartSingleProductByResultOfSearchingByAjaxWhenSaleCreate(Request $request)
        {
            $id = $request->pNameSkuBarCode;
            $query =  ProductVariation::query();
            $query->join('products','products.id','=','product_variations.product_id');
            $query->where('product_variations.id',$id);
                $query->select('product_variations.*','product_variations.id as productVarId',
                    'products.id as productId','products.name as productName','products.brand_id','products.category_id',
                    'products.product_sku as sku'
                );
            $productVariation = $query->first();
                $this->cartName         = "cartName";
                $this->productVariations = $productVariation;
                $this->product_var_id   = $productVariation->id;
                $this->discountType     = 'fixed';
                $this->discountValue    = 0;
                $this->discount_amount  = 0;
                $this->sale_unit_price  = $productVariation->default_selling_price;
                $this->identityNumber   = "";
                $this->quantity         = 1;
                $this->sale_from_stock_id = 2;
                $this->sale_type_id    = 1;
                $this->sale_unit_id    = $productVariation->default_sale_unit_id;
                $this->sub_total       = $productVariation->default_selling_price;
                $this->selling_unit_name = $productVariation->defaultSaleUnits?$productVariation->defaultSaleUnits->short_name:NULL;
                $checkQty = $this->checkQuantityIsAbailableOrNot($productVariation->id,2,$productVariation->default_sale_unit_id);
                if($checkQty)
                {
                    $this->inserInToCartWhenSearchSingleProductBySkuBarCodePnameDuringSaleCreate();
                }
                $data['cartName'] = $this->cartName ;
            $html =  view('backend.sale_pos.ajax.add_to_cart_show')->render();
            return response()->json([
                'status'    => true,
                'match'     =>'single',
                'qty_status'=> $checkQty,
                'data'      => $html
            ]);
        }
    /*
    |------------------------------------------------------------------
    | Product Search and Add to cart by name,sku,barcode
    |------------------------------------------------------------
    */



    /*
    |------------------------------------------------------------------
    | check quantity is abailabe or not
    |------------------------------------------------------------
    */
        /**check quantity is abailabe or not */
        public function checkQuantityIsAbailableOrNot($product_variation_id,$stock_id,$sale_unit_id)
        {
            $avlQty = checkPrimaryStockQtyByPVIDWithoutProductId_HH($stock_id,$business_location_id = 1,$product_variation_id);
                $availAbleQty = $avlQty?$avlQty->available_stock :0;
                $availableStock = availableStock_HH($sale_unit_id,$availAbleQty);
            if($availableStock > 1)
            {
                return 1;
            }else{
                return 0;
            }
        }
    /*
    |------------------------------------------------------------------
    | check quantity is abailabe or not
    |------------------------------------------------------------
    */


}
