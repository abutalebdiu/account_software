<?php

namespace App\Http\Controllers\Backend\Sale;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\Backend\Sale\SaleFinal;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Category;
//use App\Models\Customer;

use App\Model\Backend\Customer\Customer;

use App\Model\Backend\Sale\SaleDetail;

use App\Models\Backend\Sale\Sale_warranty_guarantee;

use Illuminate\Support\Facades\Auth;
use App\Model\Backend\Product\ProductVariation;
use App\Model\Backend\Unit\Unit;
use App\Model\Backend\Stock\PrimaryStock;
use App\Model\Backend\Stock\Stock;
use Validator;

use App\Model\Backend\Quotation\QuotationInvoice;
use App\Traits\Sell\SaleCartTrait;
use App\Traits\Stock\IncreDecreMentStockTrait;
use App\Traits\Payment\AddPaymentTrait;
use App\Backend\Reference;
class QuotationController extends Controller
{
    use SaleCartTrait;
    use IncreDecreMentStockTrait;
    use AddPaymentTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        QuotationInvoice::latest()->get(); 
        $data['sales'] = SaleFinal::whereNull('deleted_at')->where('invoice_status',2)->where('business_location_id',1)->latest()->get();
        return view('backend.quotation.index',$data);
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
    public function quotationSaleSingleShow(Request $request)
    {
        $data['saleFinal']  = SaleFinal::findOrfail($request->id);
        return view('backend.quotation.show',$data);
    }

    public function quotationDeleteSale(Request $request)
    {
         // Start transaction!
        DB::beginTransaction();
        try
        {
            $final = SaleFinal::findOrFail($request->id);
            foreach ($final->quotationSaleDetails?? NULL as $key => $value)
            {
                $value->delete();
            }

            if($final->quotationInvoices)
            {
                $final->quotationInvoices->delete();
            }
             
            $final->delete();
            DB::commit();
            return true;
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
    }



    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Backend\Quotation\QuotationInvoice  $quotationInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(QuotationInvoice $quotationInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Backend\Quotation\QuotationInvoice  $quotationInvoice
     * @return \Illuminate\Http\Response
     */

    public function editPos($id)
    {
    }
 
     /*Store From Add To Cart With Payment Modal, Working Properly*/
    public function storeFromSaleUpdateFromSaleEditCart(Request $request)
    {
        
    }
 
 

    
    public function edit($id)
    {
        session(["saleEditCart" => []]);
        $data['sale_final'] = SaleFinal::find($id);
        $data['customers']  = Customer::whereNull('deleted_at')->get();
        $data['references'] = Reference::latest()->get();
        return view('backend.quotation.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Backend\Quotation\QuotationInvoice  $quotationInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //return $request;
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
            foreach ($final->quotationSaleDetails?? NULL as $key => $value)
            {
                $value->delete();
            }
            if($final->quotationInvoices)
            {
                $final->quotationInvoices->delete();
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

                        $sale_detail->sub_total         = ($request->sub_total[$key]);
                        $sale_detail->sale_date         = $sale_date;
                        //$sale_detail->description      = $request->description[$key];
                        $sale_detail->created_by        = Auth::user()->id;

                        $sale_type_id                   = $request->sale_type_id[$key];
                        $stock_id                       = $request->sale_from_stock_id[$key];
                        $sale_unit_id                   = $request->sale_unit_id[$key];

                        $sale_detail->purchase_price    = $request->purchase_price[$key];

                        $sale_detail->sale_from_stock_id = $stock_id;
                        $sale_detail->sale_unit_id       = $sale_unit_id;
                        $sale_detail->sale_type_id       = $sale_type_id;

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Backend\Quotation\QuotationInvoice  $quotationInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuotationInvoice $quotationInvoice)
    {
        //
    }
}
