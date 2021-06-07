<?php

namespace App\Http\Controllers\Backend\Purchase;

use App\Http\Controllers\Controller;
use App\Model\Backend\Purchase\PurchaseQuotation;
use Illuminate\Http\Request;

use App\Model\Backend\Supplier;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Product;
use App\Model\Backend\Product\ProductVariation;
use App\Model\Backend\Business\BusinessLocation;
use DB;
use Validator;
use App\Model\Backend\Purchase\PurchaseFinal;
use App\Model\Backend\Purchase\PurchaseDetail;
use App\Model\Backend\Purchase\PurchaseFinalAdditionalNote;
use App\Model\Backend\Purchase\PurchaseShippingAddress;
use App\Model\Backend\Stock\StockType;
use App\Model\Backend\Stock\Stock;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Model\Backend\Stock\MainStock;
use App\Model\Backend\PurchaseProductReceiveHistory\PurchaseProductReceiveHistory;
use App\Traits\Stock\IncreDecreMentStockTrait;

use App\Model\Backend\Payment\Bank;
use App\Model\Backend\Payment\PaymentMethod;
use App\Model\Backend\Payment\AccountPaymentHistory;

use App\Traits\Payment\AddPaymentTrait;
class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data['supplieres'] = Supplier::get();

        $query = PurchaseFinal::query();

        if($request->supplier_id)
        {
            $query = $query->where('supplier_id',$request->supplier_id);
        }

        $data['purchases'] = $query->whereNull('deleted_at')
                        ->latest()
                        ->where('purchase_status_id',3)
                        ->get();

        return view('backend.purchase.quotation.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $data['supplier_id']    = $request->supplier_id;

        $data['brands']         = Brand::all();
        $data['categories']     = Category::all();
        $data['units']          = Unit::all();
        $data['suppliers']      = Supplier::get();
        $data['stockTypes']     = StockType::whereNotIn('id',[1])->get();//
        $data['businessLocations'] = BusinessLocation::whereNull('deleted_at')->get();
        $data['payment_methods'] =  PaymentMethod::whereNull('deleted_at')->get();
        return view('backend.purchase.quotation.add',$data);
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
     * @param  \App\Model\Backend\Purchase\PurchaseQuotation  $purchaseQuotation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Backend\Purchase\PurchaseQuotation  $purchaseQuotation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        session(['quotationProductPurchaseCart' => []]);
        $data['banks']          = Bank::get();
        $data['payment_methods'] =  PaymentMethod::whereNull('deleted_at')->get();
        //return view('backend.payment_modal.add_payment',$data);

        $data['purchase'] = PurchaseFinal::where('id', $id)->whereNull('deleted_at')->first();
        foreach($data['purchase']?$data['purchase']->details:NULL as $purchaseDetail)
        {
            $this->addToSessionForCart($purchaseDetail);
        }

        $data['brands']         = Brand::all();
        $data['categories']     = Category::all();
        $data['units']          = Unit::all();
        $data['suppliers']      = Supplier::get();
        $data['stockTypes']     = StockType::whereNotIn('id',[1])->get();//
        $data['businessLocations'] = BusinessLocation::whereNull('deleted_at')->get();
        //return view("backend.purchase.edit", $data);
        return view('backend.purchase.quotation.edit',$data);
    }


    /**from pulling product by ajax */
    public function addToSessionForCart($purchaseDetail) 
    {
        $quotationProductPurchaseCart = [];
        $quotationProductPurchaseCart = session()->has('quotationProductPurchaseCart') ? session()->get('quotationProductPurchaseCart')  : [];
        $productVar =  ProductVariation::where('id',$purchaseDetail->product_variation_id)->first();
        if($productVar)
        {
                $sizeName = NULL;$weightName = NULL;$colorName = NULL;
                if($productVar->sizes) $sizeName = " - ".$productVar->sizes->name;
                if($productVar->colors) $colorName = " - ".$productVar->colors->name;
                if($productVar->weights) $weightName = " - ".$productVar->weights->name;
                $product    = $productVar->products?$productVar->products->name:NULL;
                $productName = $product . $sizeName . $colorName . $weightName;
            if(array_key_exists($productVar->id,$quotationProductPurchaseCart))
                {
                    //$quotationProductPurchaseCart[$order->id]['total_price'] = $quotationProductPurchaseCart[$order->id]['quantity'] * $quotationProductPurchaseCart[$order->id]['unit_price'];
                }
            else{
                $quotationProductPurchaseCart[$purchaseDetail->product_variation_id] = [
                    'product_var_id'            => $purchaseDetail->product_variation_id,
                    'product_name'              => $productName ,
                    'product_id'                => $purchaseDetail->product_id,
                    'default_purchase_unit_id'  => $purchaseDetail->default_purchase_unit_id,
                    'default_sale_unit_id'      => $purchaseDetail->default_sale_unit_id,
                    'default_purchase_unit'     => $purchaseDetail->defaultPurchaseUnits?$purchaseDetail->defaultPurchaseUnits->short_name:NULL,
                    'purchase_quantity'         => $purchaseDetail->quantity,
                    'purchase_unit_price_before_discount' => number_format($purchaseDetail->purchase_unit_price_before_discount,2,'.', ''),
                    'purchase_unit_price_before_tax' => number_format($purchaseDetail->purchase_unit_price_before_tax,2,'.', ''),
                    'sub_total_before_tax' => number_format(($purchaseDetail->sub_total_before_tax_amount),2,'.', ''),

                    'applicable_tax_for_purchase' => $productVar->applicable_tax_for_purchase,
                    'product_tax' => $productVar->applicable_tax_for_purchase == 1 ? $productVar->purchase_tax_amount : 0,

                    'discount_value_in_parcent' => 0,
                    'net_purchase_amount' => number_format($purchaseDetail->purchase_unit_price_before_tax,2,'.', ''),
                    'line_total' => number_format(($purchaseDetail->purchase_unit_price_before_tax * $purchaseDetail->quantity),2,'.', ''),

                    'profit_margin_parcent' => $purchaseDetail->profit_margin_parcent,
                    'unit_selling_price_inc_tax' =>number_format($purchaseDetail->unit_selling_price_inc_tax,2,'.', ''),
                    
                    'whole_sale_price' => number_format(($productVar->whole_sale_price * 1),2,'.', ''),
                    'mrp_price' => number_format(($productVar->mrp_price * 1),2,'.', ''),
                    'online_sale_price' => number_format(($productVar->online_sale_price * 1),2,'.', ''),
                ];
            }
            session(['quotationProductPurchaseCart' => $quotationProductPurchaseCart]);
        }
        return true;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Backend\Purchase\PurchaseQuotation  $purchaseQuotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // dd($request->all());
        $purchase_status_id = $request->purchase_status_id;
        $input = $request->except('_token');
        $validator = Validator::make($input,[
            'supplier_id'           => 'required',
            'chalan_no'             => 'nullable|max:150|unique:purchase_finals,chalan_no,'.$id,
            'reference_no'          => 'nullable|max:150|unique:purchase_finals,reference_no,'.$id,
            'invoice_no'            => 'nullable|max:150',
            'business_location_id'  => $purchase_status_id != 3 ?'required' : 'nullable',
            'purchaes_date'         => 'required',
            'stock_type_id'         => $purchase_status_id != 3 ?'required' : 'nullable',
            'stock_id'              => $purchase_status_id != 3 ?'required' : 'nullable',
            'purchase_status_id'    => 'required',
            'file'                  => 'nullable',
        ]);
        
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $supplier_id            = $request->supplier_id;
        $shipping_address       = $request->address;
        $additional_note        = $request->additional_note;
        $business_location_id   = $request->business_location_id;
        // Start transaction!
        DB::beginTransaction();
        try
        {
            $finalPurch =  $this->insertPurchaseFinal($request,$id);            
            $this->insertPurchaseShippingAddress($finalPurch,$supplier_id,$business_location_id,$shipping_address);
            $this->additionalNote($finalPurch,$supplier_id,$business_location_id,$additional_note);
            
            foreach ($finalPurch->purchaseDetails?? NULL as $key => $value)
            {
                $value->delete(); 
            }

            foreach ($request->product_variation_id as $key => $product_variationId) 
            {
                $this->insertPurchaseDetails($finalPurch ,$product_variationId,$key , $request);
            }

            DB::commit();
            session(['productPurchaseCart' => []]);
            if($purchase_status_id == 1 || $purchase_status_id == 2)
            {
                return redirect()->route('admin.purchase.index')->with('success','Purchase Successful!');
            }else{
                return redirect()->route('admin.purchase.quotation.index')->with('success','Quotation Created Successful!');
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


    public function insertPurchaseFinal($request,$id)
    {
        $supplier_id            = $request->supplier_id;
        $chalan_no              = $request->chalan_no;
        $reference_no           = $request->reference_no;
        $invoice_no             = $request->invoice_no;
        $business_location_id   = $request->business_location_id;
        $purchaes_date          = $request->purchaes_date;
        $purchase_status_id     = $request->purchase_status_id;
        $stock_id               = $request->stock_id;

        $discount_type          = $request->discount_type?$request->discount_type:NULL;
        $discount_value         = $request->discount_type?$request->discount_value:NULL;
        $discount_amount        = $request->discount_type?$request->discount_amount:NULL;

        $purchase_tax_applicable = $request->purchase_tax_applicable?$request->purchase_tax_applicable:NULL;
        $purchase_tax_in_parcent_value = $request->purchase_tax_applicable?$request->purchase_tax_in_parcent_value:NULL;
        $purchase_tax_amount    = $request->purchase_tax_applicable?$request->purchase_tax_amount:NULL;

        $additional_shipping_charge = $request->additional_shipping_cost;

        $purchase =  PurchaseFinal::find($id);
        $purchase->business_location_id         = $business_location_id;
        //$purchase->business_type_id = $business_location_id;
        $purchase->reference_no                 = $reference_no;
        //$purchase->invoice_no                   = $invoice_no;
        $purchase->chalan_no                    = $chalan_no;
        $purchase->supplier_id                  = $supplier_id;
        $purchase->stock_id                     = $stock_id;
        $purchase->stock_type_id                = $request->stock_type_id;
        $purchase->discount_type                = $discount_type;
        $purchase->discount_value               = $discount_value;
        $purchase->discount_amount              = $discount_amount;
        $purchase->purchase_tax_applicable      = $purchase_tax_applicable;
        $purchase->purchase_tax_in_parcent_value = $purchase_tax_in_parcent_value;
        $purchase->purchase_tax_amount          = $purchase_tax_amount;
        $purchase->additional_shipping_charge   = $additional_shipping_charge;
        $purchase->purchaes_date                = $purchaes_date;
        //$purchase->file = $file;
        $purchase->purchase_status_id           = $purchase_status_id;
        $purchase->purchase_created_by          = Auth::user()->id;
        $purchase->save();

        //---------for image file-------------
        if($purchase->file)
        {
            $this->imageDelete($id,$purchase->file);
            $imageFile                         = $this->insertUpdateimage($request->file('file'),$purchase->id);
            $purchase->file                    = $imageFile;
            $purchase->save();
        }
        return $purchase;
    }

    public function insertPurchaseDetails($finalPurchase ,$product_variation_id , $key , $request)
    {
        $purchase_status_id = $request->purchase_status_id;

        $purchaseData = new PurchaseDetail();
        $purchaseData->purchase_final_id    = $finalPurchase->id;
        $purchaseData->business_location_id = $request->business_location_id;
        //$purchaseData->business_type_id =
        //$purchaseData->branch_id =
        $purchaseData->reference_no         = $request->reference_no;
        $purchaseData->invoice_no           = $finalPurchase->invoice_no;
        $purchaseData->chalan_no            = $request->chalan_no;
        $purchaseData->supplier_id          = $request->supplier_id;
        $purchaseData->stock_id             = $request->stock_id;
        $purchaseData->stock_type_id        = $request->stock_type_id;
        $purchaseData->product_variation_id = $product_variation_id;
        $purchaseData->product_id           = $request->product_id[$key];
        $purchaseData->quantity             = $request->purchase_quantity[$key];
        $purchaseData->purchase_unit_price_before_discount = $request->purchase_unit_price_before_discount[$key];
        $purchaseData->discount_type        = 1;
        $purchaseData->discount_value       = $request->discount_value_in_parcent[$key];
        //---
        $purchase_unit_price_before_tax     = $request->purchase_unit_price_before_tax[$key];

        $purchaseData->discount_amount      = $request->purchase_unit_price_before_discount[$key] - $purchase_unit_price_before_tax;
        $purchaseData->purchase_unit_price_before_tax = $purchase_unit_price_before_tax;
        $purchaseData->sub_total_before_tax_amount = $request->sub_total_before_tax[$key];

        $purchase_unit_price_inc_tax        = $request->purchase_unit_price_inc_tax[$key];

        $purchaseData->product_tax          = $request->product_tax[$key];
        $purchaseData->purchase_unit_price_inc_tax = $purchase_unit_price_inc_tax;
        $purchaseData->purchase_sub_total_inc_tax_amount = $request->line_total[$key];
        $purchaseData->profit_margin_parcent = $request->profit_margin_parcent[$key];
        //--
        $unit_selling_price_inc_tax         = $request->unit_selling_price_inc_tax[$key];
        $purchaseData->profit_amount        = $unit_selling_price_inc_tax - $purchase_unit_price_inc_tax;
        $purchaseData->purchase_delivery_status_id  = $request->purchase_status_id == 1? 1:NULL;
        $purchaseData->purchase_status_id           = $request->purchase_status_id;

        $purchaseData->unit_selling_price_inc_tax = $unit_selling_price_inc_tax;

        $totalProfitAmount                  = (($purchase_unit_price_before_tax * $request->profit_margin_parcent[$key]) / 100) ;
        $unitSellingPriceExcTax             = $purchase_unit_price_before_tax + $totalProfitAmount;

        $purchaseData->unit_selling_price_exc_tax = $unitSellingPriceExcTax;
            //-------------------------------------
        $purchaseData->default_purchase_unit_id = $request->default_purchase_unit_id[$key];
        $purchaseData->default_sale_unit_id = $request->default_sale_unit_id[$key];

        //$purchaseData->whole_sale_price   = $request->whole_sale_price[$key];
        //$purchaseData->mrp_price          = $request->mrp_price[$key];
        //$purchaseData->online_sale_price  = $request->online_sale_price[$key];
        $purchaseData->save();

        if($purchase_status_id == 1 || $purchase_status_id == 2)
        {
            updateProductVariationIdByPVID_HH( 
                    $request->product_id[$key],
                    $product_variation_id,
                    $request->purchase_unit_price_before_discount[$key],
                    $purchase_unit_price_before_tax,
                    $purchase_unit_price_inc_tax,
                    $unit_selling_price_inc_tax,
                    $unitSellingPriceExcTax,

                    $request->whole_sale_price[$key],
                    $request->mrp_price[$key],
                    $request->online_sale_price[$key]
                );
        }
        if($purchase_status_id == 1 && $purchaseData)
        {
            increasingStockPurchase_HH($request->stock_type_id,$request->stock_id,$request->product_id[$key],$product_variation_id,$request->purchase_quantity[$key],$request->business_location_id,$request->default_purchase_unit_id[$key]);
            $this->receivePurchaseProductHistory($finalPurchase,$purchaseData->id,$product_variation_id,$key, $request);
        }
        return $purchaseData;
    }

   

    public function additionalNote($purchase,$supplier_id,$business_location_id,$additional_note)
    {
        if($purchase->additionalNote)
        {
            $note =  PurchaseFinalAdditionalNote::find($purchase->additionalNote->id);
        }else{
            $note = new PurchaseFinalAdditionalNote();
        }
        $note->purchase_final_id    = $purchase->id;
        $note->supplier_id          = $supplier_id;
        $note->business_location_id = $business_location_id;
        $note->additional_note      = $additional_note;
        $note->save();
        return $note;
    }
    
    public function insertPurchaseShippingAddress($purchase,$supplier_id,$business_location_id,$address)
    {
        if($purchase->shippingAddresses)
        {
            $shipaddress =  PurchaseShippingAddress::find($purchase->shippingAddresses->id);
        }else{
            $shipaddress = new PurchaseShippingAddress();
        }
        $shipaddress->purchase_final_id     = $purchase->id;
        $shipaddress->supplier_id           = $supplier_id;
        $shipaddress->business_location_id  = $business_location_id;
        $shipaddress->address               = $address;
        $shipaddress->save();
        return $shipaddress;
    }




    // insert update iamge
    public function insertUpdateimage($file,$id)
    {
        if ($file)
        {
            $ext = strtolower($file->getClientOriginalExtension());
            if ($ext != "jpg" && $ext != "jpeg" && $ext != "png" && $ext != "gif")
            {
                $ext = '';
            }
            else
            {
                if(!Storage::disk('public')->exists('purchase/chalan'))
                {
                    Storage::disk('public')->makeDirectory('purchase/chalan');
                }
                $image_name = $id.".".$ext;
                $imageSize = Image::make($file)->resize(150,150)->save($ext);
                Storage::disk('public')->put('purchase/chalan/'.$image_name,$imageSize);
                return $ext;
            }
        }
        else
        {
            return "";
        }
    }

    // delete image
    public function imageDelete($id,$ext)
    {
        if(Storage::disk('public')->exists('purchase/chalan/'.$id.".".$ext))
        {
            Storage::disk('public')->delete('purchase/chalan/'.$id.".".$ext);
        }
        /*
            if (file_exists("product-image/{$id}.{$ext}"))
            {
                unlink("product-image/{$id}.{$ext}");
            }
            $request->move("product-image/", "{$id}.{$ext}");
            return $ext;
        */
    }


    public function receivePurchaseProductHistory($finalPurchase,$purchase_detail_id,$product_variation_id,$key, $request)
    {
        $receive = new PurchaseProductReceiveHistory();
        $receive->purchase_final_id         = $finalPurchase?$finalPurchase->id:NULL;
        $receive->business_location_id      = $finalPurchase?$finalPurchase->business_location_id:NULL;
        $receive->business_type_id          = $finalPurchase?$finalPurchase->business_type_id:NULL;
        $receive->reference_no              = $finalPurchase?$finalPurchase->reference_no:NULL;
        $receive->invoice_no                = $request->invoice_no;
        $receive->chalan_no                 = $finalPurchase?$finalPurchase->chalan_no:NULL;

        $receive->supplier_id               = $request->supplier_id;

        $receive->purchase_detail_id        = $purchase_detail_id;

        $receive->product_variation_id      = $product_variation_id;
        $receive->product_id                = $request->product_id[$key];
        $receive->received_quantity         = $request->purchase_quantity[$key];
        $receive->received_by               = Auth::user()->id;
        $receive->received_at               = date('Y-m-d h:i:s');
        //$receive->received_from             = $request->received_from;
        //$receive->received_invo_cln_ref_no  = $request->received_invo_cln_ref_no;
        $receive->receiving_period          = 1;//1 = instant , 2== litter
        $receive->save();
    }


    /**Not use */
    public function insertPurchaseFinalPayment($request)
    {
        // payment part
        $advance_balance    = $request->advance_balance;
        $paymet_amount      = $request->paymet_amount;
        $payment_date       = $request->payment_date;
        $payment_method_id  = $request->payment_method_id;
        $bank_id            = $request->bank_id;
        $card_number        = $request->card_number;
        $card_holder_name   = $request->card_holder_name;
        $card_transaction_no = $request->card_transaction_no;
        $card_type          = $request->card_type;
        $expire_month       = $request->expire_month;
        $expire_year        = $request->expire_year;
        $card_security_code = $request->card_security_code;
        $cheque_no          = $request->cheque_no;
        $transfer_bank_account_no = $request->transfer_bank_account_no;
        $transaction_no     = $request->transaction_no;
        $payment_note       = $request->payment_note;
        $due_amount         = $request->due_amount;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Backend\Purchase\PurchaseQuotation  $purchaseQuotation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Start transaction!
        DB::beginTransaction();
        try 
        {
            $purchase = PurchaseFinal::where('id',$id)->where('purchase_status_id',3)->first();
            if(!$purchase || empty($purchase || $purchase == NULL))
            {
                return redirect()->back()->with([
                    'message' => 'Invalid Request!',
                    'alert-type' => 'error'
                ]);
            }
            foreach ($purchase->purchaseDetails?? NULL as $key => $value)
            {
                $value->delete(); 
            }
            if($purchase->additionalNotes)
            {
                $purchase->additionalNotes->delete();
            }
            if($purchase->shippingAddresses)
            {
                $purchase->shippingAddresses->delete();
            }
            $purchase->delete();

            DB::commit();
            return redirect()->back()->with([
                'message' => 'Purchase Deleted Successfully!',
                'alert-type' => 'success'
            ]);
            
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

        return $id;
        $purchase = PurchaseFinal::find($id);
        
        if($purchase->delete()){
            return redirect()->back()->with([
                'message' => 'Purchase Deleted Successfully!',
                'alert-type' => 'success'
            ]);
        }
    }
}
