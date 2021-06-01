<?php

namespace App\Http\Controllers\Backend\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Backend\Supplier;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Product;
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
class PurchaseController extends Controller
{
    use IncreDecreMentStockTrait;
    use AddPaymentTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['purchases'] = PurchaseFinal::whereNull('deleted_at')
                                        ->latest()
                                        ->where('purchase_status_id','!=',3)
                                        ->get();
        return view('backend.purchase.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //session(['productPurchaseCart' => []]);
        $data['brands']         = Brand::all();
        $data['categories']     = Category::all();
        $data['units']          = Unit::all();
        $data['suppliers']      = Supplier::get();
        $data['stockTypes']     = StockType::whereNotIn('id',[1])->get();//
        $data['businessLocations'] = BusinessLocation::whereNull('deleted_at')->get();
        $data['payment_methods'] =  PaymentMethod::whereNull('deleted_at')->get();
        return view('backend.purchase.create',$data);
    }


    public function createBypassPurchase()
    {
        //session(['productPurchaseCart' => []]);
        $data['brands']         = Brand::all();
        $data['categories']     = Category::all();
        $data['units']          = Unit::all();
        $data['suppliers']      = Supplier::get();
        $data['stockTypes']     = StockType::whereNotIn('id',[1])->get();//
        $data['businessLocations'] = BusinessLocation::whereNull('deleted_at')->get();
        $data['payment_methods'] =  PaymentMethod::whereNull('deleted_at')->get();
        return view('backend.purchase.bypass.create',$data);
    }


    public function getStockByStockId(Request $request)
    {
        $stock_type_id = $request->stock_type_id;
        $stocks = Stock::where('stock_type_id',$stock_type_id)->whereNull('deleted_at')->get();
        $html = "<option value=''>Select Stock</option>";
        foreach ($stocks as $stock) {
            $html .= "<option value='$stock->id'>$stock->name</option>";
        }
        // echo $cityHtmlOption;
        return ($html);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $purchase_status_id = $request->purchase_status_id;
        $input = $request->except('_token');
        $validator = Validator::make($input,[
            'supplier_id'           => 'required',
            'chalan_no'             => 'nullable|max:150|unique:purchase_finals,chalan_no',
            'reference_no'          => 'nullable|max:150|unique:purchase_finals,reference_no',
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
            $finalPurch =  $this->insertPurchaseFinal($request);
            $this->insertPurchaseShippingAddress($finalPurch,$supplier_id,$business_location_id,$shipping_address);
            $this->additionalNote($finalPurch,$supplier_id,$business_location_id,$additional_note);
            
            foreach ($request->product_variation_id as $key => $product_variationId) {
                $this->insertPurchaseDetails($finalPurch ,$product_variationId,$key , $request);
            }

                // payment method
                if($request->payment_method_id)
                {
                    $this->payment_reference_no     = "PE".date("Y");
                    $this->module_id                = module_HH()['purchase'];
                    $this->module_invoice_no        = $finalPurch->invoice_no;
                    $this->module_invoice_id        = $finalPurch->id; 
                    $this->account_id               = $request->account_id;
                    $this->payment_method_id        = $request->payment_method_id;
                    $this->cdf_type_id              = cdf_HH()['debit'];
                    $this->payment_type_id          = payment_type_HH()['expense'];
                    $this->payment_amount           = $request->payment_amount;
                    $this->client_supplier_id       = $finalPurch->supplier_id;
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


    public function insertPurchaseFinal($request)
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

        $purchase = new PurchaseFinal();
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
        $purchase->invoice_no                   = "00".$purchase->id;
        //---------for image file-------------
       $imageFile                               = $this->insertUpdateimage($request->file('file'),$purchase->id);
       $purchase->file                          = $imageFile;
       $purchase->save();
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

    public function additionalNote($purchase,$supplier_id,$business_location_id,$additional_note)
    {
        $note = new PurchaseFinalAdditionalNote();
        $note->purchase_final_id    = $purchase->id;
        $note->supplier_id          = $supplier_id;
        $note->business_location_id = $business_location_id;
        $note->additional_note      = $additional_note;
        $note->save();
        return $note;
    }
    
    public function insertPurchaseShippingAddress($purchase,$supplier_id,$business_location_id,$address)
    {
        $shipaddress = new PurchaseShippingAddress();
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /**not working */
    public function show($id)
    {
        $data['purchase'] = PurchaseFinal::where('id', $id)->whereNull('deleted_at')->first();
        // $data['purchase']->createdBy;
        if(!$data['purchase'] || empty($data['purchase']))return redirect()->back();
        $data['purchase']->shipping;
        $data['purchase']->suppliers;

        foreach ($data['purchase']->details as $detail) {
            $detail->productVariations->products;
        }

        $data['subtotal'] = $data['purchase']->subTotalPurchaseAmount();
        $data['discount'] = $data['purchase']->discountAmounts();
        $data['tax'] = $data['purchase']->taxAmounts();
        $data['shippingAmount'] = $data['purchase']->additionalShippingCharges();
        $data['purchaseAmount'] = $data['purchase']->totalPurchaseAmount();
        $data['paidAmount'] = $data['purchase']->totalPaidAmount();
        $data['dueAmount'] = $data['purchase']->totalDueAmount();
        return view("backend.purchase.show", $data);
    }


    /**single show view working properly */
    public function showSingle(Request $request)
    {
        $data['purchase'] = PurchaseFinal::where('id', $request->id)->whereNull('deleted_at')->first();
        $data['purchase']->shipping;
        $data['purchase']->suppliers;

        foreach ($data['purchase']->purchaseDetails as $detail) {
            $detail->productVariations->products;
        }
        $data['subtotal'] = $data['purchase']->subTotalPurchaseAmount();
        $data['discount'] = $data['purchase']->discountAmounts();
        $data['tax'] = $data['purchase']->taxAmounts();
        $data['shippingAmount'] = $data['purchase']->additionalShippingCharges();
        $data['purchaseAmount'] = $data['purchase']->totalPurchaseAmount();
        $data['paidAmount'] = $data['purchase']->totalPaidAmount();
        $data['dueAmount'] = $data['purchase']->totalDueAmount();
        return view("backend.purchase.show_print_ajax.show", $data);
    }
    /**single show view working properly */ 

    /**single show print working properly */
    public function showSinglePrint(Request $request)
    {
        $data['purchase'] = PurchaseFinal::where('id', $request->id)->whereNull('deleted_at')->first();
        $data['purchase']->shipping;
        $data['purchase']->suppliers;
        foreach ($data['purchase']->purchaseDetails as $detail) {
            $detail->productVariations->products;
        }
        $data['subtotal'] = $data['purchase']->subTotalPurchaseAmount();
        $data['discount'] = $data['purchase']->discountAmounts();
        $data['tax'] = $data['purchase']->taxAmounts();
        $data['shippingAmount'] = $data['purchase']->additionalShippingCharges();
        $data['purchaseAmount'] = $data['purchase']->totalPurchaseAmount();
        $data['paidAmount'] = $data['purchase']->totalPaidAmount();
        $data['dueAmount'] = $data['purchase']->totalDueAmount();
        return view("backend.purchase.show_print_ajax.print", $data);
    }
    /**single show print working properly */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['banks']          = Bank::get();
        $data['paymentMethods'] = PaymentMethod::get();
        //return view('backend.payment_modal.add_payment',$data);

        $data['purchase'] = PurchaseFinal::where('id', $id)->whereNull('deleted_at')->first();

        $data['brands']         = Brand::all();
        $data['categories']     = Category::all();
        $data['units']          = Unit::all();
        $data['suppliers']      = Supplier::get();
        $data['stockTypes']     = StockType::whereNotIn('id',[1])->get();//
        $data['businessLocations'] = BusinessLocation::whereNull('deleted_at')->get();
        return view("backend.purchase.edit", $data);
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
      /**not used */
    public function destroy($id)
    {
        $purchase = PurchaseFinal::find($id);
        
        if($purchase->delete()){
            return redirect()->back()->with([
                'message' => 'Purchase Deleted Successfully!',
                'alert-type' => 'success'
            ]);
        }
    }




    
    /**working properly */
    public function deleteSinglePurchase(Request $request)
    {
        // Start transaction!
        DB::beginTransaction();
        try 
        {
            $purchase = PurchaseFinal::find($request->id);
            foreach ($purchase->purchaseDetails?? NULL as $key => $value)
            {
                $this->product_variation_id     = $value->product_variation_id;
                $this->product_id               = $value->product_id;
                $this->quantity                 = $value->quantity;
                $this->defaultPurchaseUnitId    = $value->default_purchase_unit_id;
                $this->stock_type_id            = $value->stock_type_id;
                $this->stock_id                 = $value->stock_id;
                $this->receivedQuantity         = $value->totalReceivedQtys();
                $this->decrementStockFromDifferentsStockWhenActionWithPurchaseDetails();
                $value->deleted_at = date('Y-m-d h:i:s');
                $value->save(); 
            }
            if($purchase->additionalNotes)
            {
                $purchase->additionalNotes->deleted_at = date('Y-m-d h:i:s');
                $purchase->additionalNotes->save();
            }
            if($purchase->shippingAddresses)
            {
                $purchase->shippingAddresses->deleted_at = date('Y-m-d h:i:s');
                $purchase->shippingAddresses->save();
            }
            foreach ($purchase->receivedPurchaseProducts?? NULL as $key => $receive)
            {
                $receive->deleted_at = date('Y-m-d h:i:s');
                $receive->save(); 
            }
            foreach ($purchase->payments?? NULL as $key => $payment)
            {
                $payment->deleted_at = date('Y-m-d h:i:s');
                $payment->save(); 
            }
            $purchase->deleted_at = date('Y-m-d h:i:s');
            $purchase->save();
            DB::commit();
            return $purchase;
            /* if relationship is hasMany, then below part is right
                foreach ($purchase->additionalNotes?? NULL as $key => $note)
                {
                    $note->deleted_at = date('Y-m-d h:i:s');
                    $note->save(); 
                }
                //if relationship is hasMany, then below part is right
                foreach ($purchase->shippingAddresses?? NULL as $key => $shipping)
                {
                    $shipping->deleted_at = date('Y-m-d h:i:s');
                    $shipping->save(); 
                } 
            */
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

    /**working properly */
    public function receive($id)
    {
        $data['suppliers'] = Supplier::get();
        $data['purchase'] = PurchaseFinal::where('id', $id)->whereNull('deleted_at')->first();
        if( $data['purchase'] == NULL || empty($data['purchase']))return redirect()->route('admin.purchase.index');
        $data['purchase_final_id'] = $id;
        session(['receiveProductPurchaseCart' => []]);
        return view('backend.purchase.receive',$data);
    }


    public function return($id)
    {
        $data['suppliers'] = Supplier::get();
        $data['purchase'] = PurchaseFinal::where('id', $id)->whereNull('deleted_at')->first();
        if( $data['purchase'] == NULL || empty($data['purchase']))return redirect()->route('admin.purchase.index');

        foreach ($data['purchase']->purchaseDetails as $detail) {
            $detail->productVariations->products;
        }
        $data['payment_methods'] =  PaymentMethod::whereNull('deleted_at')->get();
        return view('backend.purchase.return',$data);
    }

     /**working properly */
    public function duplicate($id)
    {
        $purchase = PurchaseFinal::where('id', $id)->whereNull('deleted_at')->first();
        DB::beginTransaction();
        try
        {
            $newPurchase = $purchase->replicate();
            $newPurchase->save();
            $newPurchase->invoice_no = "00".$newPurchase->id;
            $newPurchase->created_by = Auth::user()->id;
            $newPurchase->save();

            $newAdditionalNote      = $purchase->additionalNotes?$purchase->additionalNotes->replicate():NULL;
            $newShippingAddresses   = $purchase->shippingAddresses?$purchase->shippingAddresses->replicate():NULL;
            
            $this->additionalNote($newPurchase,$newPurchase->supplier_id,$newPurchase->business_location_id,$newPurchase->additional_note);
            $this->insertPurchaseShippingAddress($newPurchase,$newPurchase->supplier_id,$newPurchase->business_location_id,$newPurchase->address);
            
            foreach ($purchase->purchaseDetails as $detail) 
            {
                $newDetail = PurchaseDetail::where('id',$detail->id)->whereNull('deleted_at')->first()->replicate();
                $newDetail->purchase_final_id       = $newPurchase->id;
                $newDetail->invoice_no              = $newPurchase->invoice_no;
                $newDetail->created_by              = Auth::user()->id;
                $newDetail->save();

                $product = Product::find($newDetail->product_id);
                updateProductVariationIdByPVID_HH(
                        $newDetail->product_id,
                        $newDetail->product_variation_id,
                        $newDetail->purchase_unit_price_before_discount,
                        $newDetail->purchase_unit_price_before_tax,
                        $newDetail->purchase_unit_price_inc_tax,
                        $newDetail->unit_selling_price_inc_tax,
                        $newDetail->unit_selling_price_exc_tax,

                        $product?$product->whole_sale_price:0,
                        $product?$product->mrp_price:0,
                        $product?$product->online_sale_price:0
                    );
                if($newDetail->purchase_status_id == 1 && $newDetail)
                {
                    increasingStockPurchase_HH($newDetail->stock_type_id,$newDetail->stock_id,
                        $newDetail->product_id,$newDetail->product_variation_id,
                        $newDetail->quantity,
                        $newDetail->business_location_id,
                        $newDetail->default_purchase_unit_id
                    );
                }
            }
            foreach ($purchase->receivedPurchaseProducts?? NULL as $key => $receive)
            {
                $NewReceive = PurchaseProductReceiveHistory::where('id',$receive->id)->whereNull('deleted_at')->first()->replicate();
                $NewReceive->purchase_final_id      =  $newPurchase->id;
                $NewReceive->invoice_no             =  $newPurchase->invoice_no;
                $NewReceive->received_by            =  Auth::user()->id;
                $NewReceive->save();
            }

            DB::commit();
            return redirect()->back()->with([
                'alert-type' => 'success',
                'message' => 'Purchase Duplicated Successful!'
            ]);
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


    public function addSinglePayment(Request $request)
    {
        $data['purchase']           = PurchaseFinal::findOrFail($request->id);
        $data['banks']              = Bank::get();
        $data['payment_methods']    = PaymentMethod::whereNull('deleted_at')->get();
        return view('backend.payment_modal.add',$data);
    }

    public function viewSinglePayment(Request $request)
    {
        $data['purchaseFinal']  =   PurchaseFinal::findOrFail($request->id);

        $data['banks']              = Bank::get();
        $data['payment_methods']    = PaymentMethod::whereNull('deleted_at')->get();
        return view('backend.payment_modal.view',$data);
    }

     /**single payment delete */
     public function purchaseSinglePaymentDelete(Request $request)
     {
         //$id             = $request->id;
         //$purchase_final_id  = $request->purchase_final_id;
         $payment = AccountPaymentHistory::findOrfail($request->id);
         $payment->deleted_at = date('Y-m-d h:i:s');
         $payment->save();
         return true;
     }
    
    
    
    
   



}

