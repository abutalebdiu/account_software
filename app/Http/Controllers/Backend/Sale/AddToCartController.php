<?php

namespace App\Http\Controllers\Backend\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Model\Backend\Sale\SaleFinal;
use App\Model\Backend\Sale\SaleDetail;
use App\Models\Backend\Sale\Sale_warranty_guarantee;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Model\Backend\Product\ProductVariation;
use App\Model\Backend\Unit\Unit;
use App\Model\Backend\Stock\PrimaryStock;
use App\Model\Backend\Stock\Stock;

use App\Model\Backend\Payment\Bank;
use App\Model\Backend\Payment\PaymentMethod;
use App\Model\Backend\Customer\Customer;
class AddToCartController extends Controller
{


    public function createShowModal(Request $request)
    {
        //$data['product']  = Product::find($request->product_id);
        $data['product']        = ProductVariation::find($request->product_id);
                $base_unit_id   = $data['product']->defaultSaleUnits?$data['product']->defaultSaleUnits->base_unit_id:NULL;
        $data['sale_units']     = Unit::where('base_unit_id',$base_unit_id)->whereNull('deleted_at')->latest()->get();
        $data['stocks']         = Stock::where('business_location_id',1)->where('stock_type_id',2)->get();
        $data['primary_stocks'] = PrimaryStock::where('business_location_id',1)
                                                ->where('product_variation_id',$request->product_id)
                                                ->get();

        /*----====----Offer system-------====------*/
        $applicable_offer       = $data['product']->applicable_for_offer_promo_code;
        $promo_code_end_time    = $data['product']->promo_code_end_time;
        $promo_code_less_amount = $data['product']->offer_promo_code_less_amount?$data['product']->offer_promo_code_less_amount:0;
        $offer_promo_code       = $data['product']->offer_promo_code;
        $offer_promo_code       = NULL;

        $promo_offer_from   =  strtotime('2021-02-15 12:20');
        $promo_offer_to     =  strtotime('2021-02-20 12:20');
        $compareDate        = strtotime(date('Y-m-d h:i:s'));
        $applicable_offer = 1; //overwright
        $offer_activate = 0;
        if($promo_offer_from <= $compareDate && $promo_offer_to >= $compareDate && $applicable_offer)
        {
            $offer_activate = 1;
        }else{
            $offer_activate = 0;
        }
        $data['promo_offer_code'] = $offer_promo_code;
        $data['promo_offer_activate_status'] = $applicable_offer;
        $data['promo_offer_price'] = $data['product']->default_selling_price - $promo_code_less_amount;
        /*----====----Offer system-------====------*/

        return view('backend.sale_pos.ajax.create_show_modal',$data);
    }





    public function checkQtyAvailableByStockIdPvId(Request $request)
    {
        $unit_id                =  $request->unit_id;
        $unit_name              =  $request->unit_name;

        $stock_id               =  $request->stock_id;
        $stock_name             =  $request->stock_name;
        $product_variation_id   =  $request->product_variation_id;
        $pressing_qty           =  $request->pressing_qty;
        $available_stock        = PrimaryStock::where('business_location_id',1)
                                    ->where('product_variation_id',$request->product_variation_id)
                                    ->where('stock_id',$request->stock_id)
                                    ->sum('available_stock');

        $availableStock = availableStock_HH($unit_id,$available_stock);

        $product = ProductVariation::where('id',$product_variation_id)
                            ->select('default_sale_unit_id','default_selling_price','default_purchase_price','whole_sale_price','offer_promo_code_less_amount')
                            ->first();

        $default_sale_unit_id   =   $product->default_sale_unit_id;

        $default_selling_price  =   $product->default_selling_price;
        $default_purchase_price =   $product->default_purchase_price;
        $whole_sale_price       =   $product->whole_sale_price;
            $promo_code_less_amount = $product->offer_promo_code_less_amount?$product->offer_promo_code_less_amount:0;
        $promo_offer_price = $product->default_selling_price - $promo_code_less_amount;

        /**default sale base unit rate */
        $dftSaleBaseUnit        = Unit::find($default_sale_unit_id);
        $dftSellingBaseUnit     = $dftSaleBaseUnit->calculation_result;

        $dftSaleBaseUnitId      = $dftSaleBaseUnit->base_unit_id;

        $dftCalculationSellingBaseResult = Unit::find($dftSaleBaseUnitId)->calculation_result;

        $pressingUnit   =   Unit::find($unit_id)->calculation_result;
        /**default sale base unit rate */

        /* default_selling_price */
        $defaultSellingPricePerBaseUnit = ($default_selling_price  / $dftSellingBaseUnit) * $dftCalculationSellingBaseResult ;
        $new_default_selling_price = $defaultSellingPricePerBaseUnit * $pressingUnit;
        /* default_selling_price */

        /* default_purchase_price */
        $defaultPurchasePricePerBaseUnit = ($default_purchase_price  / $dftSellingBaseUnit) * $dftCalculationSellingBaseResult ;
        $new_default_purchase_price = $defaultPurchasePricePerBaseUnit * $pressingUnit;
        /* default_purchase_price */

        /* default_purchase_price */
        $defaultWholeSalePricePerBaseUnit = ($whole_sale_price  / $dftSellingBaseUnit) * $dftCalculationSellingBaseResult ;
        $new_whole_sale_price = $defaultWholeSalePricePerBaseUnit * $pressingUnit;
        /* default_purchase_price */

        /* promo_offer_price */
        $defaultPromoPricePerBaseUnit = ($promo_offer_price  / $dftSellingBaseUnit) * $dftCalculationSellingBaseResult ;
        $new_promo_offer_price = $defaultPromoPricePerBaseUnit * $pressingUnit;
        /* promo_offer_price */

        return response()->json([
            'status' => true,
            'available_stock'   => $availableStock,
            'pressing_qty'      => $pressing_qty,
            'stock_id'          => $stock_id,
            'pressing_unit_id'  => $unit_id,
            'stock_name'        => $stock_name,
            'unit_name'         => $unit_name,
            'pro_variation_id'  => $product_variation_id,

            'default_selling_price'  => $new_default_selling_price,
            'default_purchase_price' => $new_default_purchase_price,
            'whole_sale_price'       => $new_whole_sale_price,
            'promo_offer_price'      => $new_promo_offer_price,
        ]);
        return $request;
    }



    /**Add TO Cart  Working Properly*/
    public function addToCartWhenSubmitingFromModal(Request $request)
    {
        //session(['cartName' => []]);
       // $data['product']   = Product::find($request->product_id);
        $cartName = [];
        $sale_type_id       =  $request->sale_type_id;
        $sale_from_stock_id =  $request->sale_from_stock_id;
        $sale_unit_id       =  $request->sale_unit_id;
        $selling_unit_name  =  $request->selling_unit_name;

        $product_var_id     =  $request->product_variation_id;
        $sale_price         =  $request->sale_price;
        $purchase_price     =  $request->purchase_price;
        $discountType       =  $request->discountType;
        $quantity           =  $request->quantity;
        $discountValue      =  $request->discountValue;
        $netTotalAmount     =  $request->netTotalAmount;
        $identityNumber     =  $request->identityNumber;
        $cartName           = session()->has('cartName') ? session()->get('cartName')  : [];
        $productVari        =  ProductVariation::find($product_var_id);
        if($productVari)
        {
            $size           = $productVari->sizes?$productVari->sizes->name:NULL;
            $color          = $productVari->colors?$productVari->colors->name:NULL;
            $weight         = $productVari->weights?$productVari->weights->name:NULL;
            $productName    = $productVari->products->name ." ".  $size ." ". $color ." ". $weight;

            if(array_key_exists($productVari->id,$cartName))
                {
                    $newQty = $quantity;
                    if($sale_unit_id == $cartName[$productVari->id]['sale_unit_id']) $newQty = $cartName[$productVari->id]['quantity'] + $quantity;
                    $newNetAmount = number_format($sale_price * $newQty ,2,'.', '');
                    
                    //number_format(1000.5, 0, ',', '');

                    if($discountType == 'percentage')
                    {
                        $disAmount =   ($newNetAmount * $discountValue) / 100;
                    }else{
                        $disAmount  = $discountValue;
                    }
                    $newTotalNetAmount = $newNetAmount - $disAmount;
                    $cartName[$productVari->id]['purchase_price']       = number_format($purchase_price,2,'.', '');
                    $cartName[$productVari->id]['sale_price']           = number_format($sale_price,2,'.', '');
                    $cartName[$productVari->id]['discountType']         = $discountType;
                    $cartName[$productVari->id]['discountValue']        = $discountValue;
                    $cartName[$productVari->id]['quantity']             = $newQty;
                    $cartName[$productVari->id]['netTotalAmount']       = number_format($newTotalNetAmount ,2,'.', '');
                    $cartName[$productVari->id]['identityNumber']       = $identityNumber;

                    $cartName[$productVari->id]['sale_type_id']         = $sale_type_id;
                    $cartName[$productVari->id]['sale_from_stock_id']   = $sale_from_stock_id;
                    $cartName[$productVari->id]['sale_unit_id']         = $sale_unit_id;
                    $cartName[$productVari->id]['selling_unit_name']    = $selling_unit_name;
                }
            else{
                $cartName[$productVari->id] = [
                    'productVari_id' => $productVari->id,
                    'name' => $productName,
                    'purchase_price' => number_format($purchase_price,2,'.', ''),
                    'sale_price' => number_format($sale_price,2,'.', ''),
                    'discountType' => $discountType,
                    'quantity' => $quantity,
                    'discountValue' => $discountValue,
                    'netTotalAmount' => number_format($netTotalAmount,2,'.', ''),
                    'identityNumber' => $identityNumber,
                    'sale_type_id'  => $sale_type_id,
                    'sale_from_stock_id' => $sale_from_stock_id,
                    'sale_unit_id' => $sale_unit_id,
                    'selling_unit_name' => $selling_unit_name,
                ];
            }
            session(['cartName' => $cartName]);
        }
        return view('backend.sale_pos.ajax.add_to_cart_show');
    }


    /**Add TO Cart  Working Properly*/
    public function addToCartWhenSubmitingEditFromModal(Request $request)
    {
        //session(['cartName' => []]);
       // $data['product']   = Product::find($request->product_id);
        $cartName = [];
        $sale_type_id       =  $request->sale_type_id;
        $sale_from_stock_id =  $request->sale_from_stock_id;
        $sale_unit_id       =  $request->sale_unit_id;
        $selling_unit_name  =  $request->selling_unit_name;

        $product_var_id     =  $request->product_variation_id;
        $purchase_price     =  $request->purchase_price;
        $sale_price         =  $request->sale_price;
        $discountType       =  $request->discountType;
        $quantity           =  $request->quantity;
        $discountValue      =  $request->discountValue;
        $netTotalAmount     =  $request->netTotalAmount;
        $identityNumber     =  $request->identityNumber;
        $cartName           = session()->has('cartName') ? session()->get('cartName')  : [];
        $productVari        =  ProductVariation::find($product_var_id);
        if($productVari)
        {
            $size           = $productVari->sizes?$productVari->sizes->name:NULL;
            $color          = $productVari->colors?$productVari->colors->name:NULL;
            $weight         = $productVari->weights?$productVari->weights->name:NULL;
            $productName    = $productVari->products->name ." ".  $size ." ". $color ." ". $weight;

            if(array_key_exists($productVari->id,$cartName))
                {
                    $cartName[$productVari->id]['purchase_price']       = number_format($purchase_price,2,'.', '');
                    $cartName[$productVari->id]['sale_price']           = number_format($sale_price,2,'.', '');
                    $cartName[$productVari->id]['discountType']         = $discountType;
                    $cartName[$productVari->id]['discountValue']        = $discountValue;
                    $cartName[$productVari->id]['quantity']             = $quantity;
                    $cartName[$productVari->id]['netTotalAmount']       = number_format($netTotalAmount ,2,'.', '');
                    $cartName[$productVari->id]['identityNumber']       = $identityNumber;

                    $cartName[$productVari->id]['sale_type_id']         = $sale_type_id;
                    $cartName[$productVari->id]['sale_from_stock_id']   = $sale_from_stock_id;
                    $cartName[$productVari->id]['sale_unit_id']         = $sale_unit_id;
                    $cartName[$productVari->id]['selling_unit_name']    = $selling_unit_name;
                }
            else{
                $cartName[$productVari->id] = [
                    'productVari_id' => $productVari->id,
                    'name' => $productName,
                    'purchase_price' => number_format($purchase_price,2,'.', ''),
                    'sale_price' => number_format($sale_price,2,'.', ''),
                    'discountType' => $discountType,
                    'quantity' => $quantity,
                    'discountValue' => $discountValue,
                    'netTotalAmount' => number_format($netTotalAmount,2,'.', ''),
                    'identityNumber' => $identityNumber,
                    'sale_type_id'  => $sale_type_id,
                    'sale_from_stock_id' => $sale_from_stock_id,
                    'sale_unit_id' => $sale_unit_id,
                    'selling_unit_name' => $selling_unit_name,
                ];
            }
            session(['cartName' => $cartName]);
        }
        return view('backend.sale_pos.ajax.add_to_cart_show');
    }


    /** When Cart is exist Working Properly*/
    public function whenCartIsExist()
    {
        $cartName = session()->has('cartName') ? session()->get('cartName')  : [];
        if($cartName)
        {
            return view('backend.sale_pos.ajax.add_to_cart_show');
        }else{
            return false;
        }

    }


    /**/
    /*When changing quantity*/
    public function changeQuantityFromCartList(Request $request)
    {
        //session(['cartName' => []]);
        $cartName = [];
        $product_variation_id   =  $request->product_id;
        $change_type            =  $request->change_type;
        $quantity               =  $request->quantity;

        $cartName               =   session()->has('cartName') ? session()->get('cartName')  : [];
        $productVari            =  ProductVariation::find($product_variation_id);
        if($productVari)
        {
            if(array_key_exists($productVari->id,$cartName))
            {
                $available_status   = NULL;
                if($change_type == 'minus' && $cartName[$productVari->id]['quantity'] > 1)
                {
                    $quantity = $cartName[$productVari->id]['quantity'] - 1;
                }
                else if($change_type == 'plus')
                {
                    $stock_id = $cartName[$productVari->id]['sale_from_stock_id'];
                    $business_location_id = 1;
                    $avlQty = checkPrimaryStockQtyByPVIDWithoutProductId_HH($stock_id,$business_location_id,$product_variation_id);
                    $availAbleQty = $avlQty?$avlQty->available_stock :0;

                    $availableStock = availableStock_HH($cartName[$productVari->id]['sale_unit_id'],$availAbleQty);
                    $quantity       = $cartName[$productVari->id]['quantity'] + 1;
                    $available_status   = 'available';
                    /* $available_status   = 'not_available';
                    if($availableStock > $cartName[$productVari->id]['quantity'])
                    {
                        $quantity       = $cartName[$productVari->id]['quantity'] + 1;
                        $availableStock = $availableStock-$quantity;
                        $available_status   = 'available';
                    } */
                }

                /* 
                |---------------------------------------------------------------------------------------------------------
                |  if quantity is not available , then sell is stop.. but this part is  stop for only faridpur client  
                |------------------------------------------------------------------------------------------------
                    if($change_type == 'minus' && $cartName[$productVari->id]['quantity'] > 1)
                    {
                        $quantity = $cartName[$productVari->id]['quantity'] - 1;
                    }
                    else if($change_type == 'plus')
                    {
                        $stock_id = $cartName[$productVari->id]['sale_from_stock_id'];
                        $business_location_id = 1;
                        $avlQty = checkPrimaryStockQtyByPVIDWithoutProductId_HH($stock_id,$business_location_id,$product_variation_id);
                        $availAbleQty = $avlQty?$avlQty->available_stock :0;

                        $availableStock = availableStock_HH($cartName[$productVari->id]['sale_unit_id'],$availAbleQty);
                        $available_status   = 'not_available';
                        if($availableStock > $cartName[$productVari->id]['quantity'])
                        {
                            $quantity       = $cartName[$productVari->id]['quantity'] + 1;
                            $availableStock = $availableStock-$quantity;
                            $available_status   = 'available';
                        }
                    } 
                |------------------------------------------------------------------------------------------------
                |if quantity is not available , then sell is stop.. but this part is  stop for only faridpur client  
                |---------------------------------------------------------------------------------------------------------------
                */

                if($cartName[$productVari->id]['discountType'] == "percentage" && $cartName[$productVari->id]['discountValue'])
                {
                    $totalDiscountAmount =  ($quantity *  $cartName[$productVari->id]['sale_price']) * ($cartName[$productVari->id]['discountValue']) /100;
                }
                else if($cartName[$productVari->id]['discountType'] == "fixed" && $cartName[$productVari->id]['discountValue'])
                {
                    $totalDiscountAmount =  $cartName[$productVari->id]['discountValue'] ;
                }
                else{
                    $totalDiscountAmount = 0 ;
                }
                //$cartName[$product->id]['product_id']       =  $request->product_id;
                //$cartName[$product->id]['name']             =  $cartName[$product->id]['name'] ;
                //$cartName[$product->id]['sale_price']       =  number_format($cartName[$product->id]['sale_price'],2) ;
                //$cartName[$product->id]['discountType']     =  $cartName[$product->id]['discountType'] ;
                //$cartName[$product->id]['discountValue']    =  $cartName[$product->id]['discountValue'] ;
                $cartName[$productVari->id]['quantity']         =  $quantity;
                $cartName[$productVari->id]['netTotalAmount']   =  number_format(($quantity *  $cartName[$productVari->id]['sale_price']) - $totalDiscountAmount,2,'.', '');
                //$cartName[$product->id]['identityNumber']   =  $cartName[$product->id]['identityNumber'] ;
            }
            session(['cartName' => $cartName]);
        }
        $html =  view('backend.sale_pos.ajax.add_to_cart_show')->render();
        return response()->json([
            'status' => true,
            'available_status' => $available_status,
            'html'  => $html
        ]);
    }



    /*Remove Single Data From  Cart Working Properly*/
    public function removeSingleDataFromCart(Request $request)
    {
        $cartName = session()->has('cartName') ? session()->get('cartName')  : [];
		unset($cartName[$request->input('product_id')]);
        session(['cartName'=>$cartName]);
        return view('backend.sale_pos.ajax.add_to_cart_show');
    }

    /*Remove All Data From Cart Working Properly*/
    public function removeAllDataFromCreateCart()
    {
        session(['cartName' => []]);
        return view('backend.sale_pos.ajax.add_to_cart_show');
    }



    /*Popup Payment Modal before submiting from cart Working Properly*/
    public function popupPaymentModalBeforeSubmitingFromCart(Request $request)
    {
        $data['customer_id']            = $request->customerId;
        $data['reference_id']           = $request->reference_id;
        $data['fianl_total_item']       = $request->totalItem;
        $data['final_sub_total_amount'] = number_format($request->subTotalAmount,2,'.', '');
        $data['final_discount_type']    = $request->discountType;
        $data['final_discount_value']   = number_format($request->discountValue,2,'.', '');
        $data['final_discount_amount']  = $request->discountAmount?number_format($request->discountAmount,2,'.', ''):'';
        $data['fianl_other_cost']       = number_format($request->otherCost,2,'.', '');
        $data['fianl_payable_amount']   = number_format($request->payableAmount,2,'.', '');

        $data['banks']              = Bank::get();
        $data['payment_methods']    = PaymentMethod::whereNull('deleted_at')->get();
        $data['total_due_amount']   = Customer::findOrFail($request->customerId);  
        return view('backend.sale_pos.ajax.payment.payment_modal',$data);
    }

    /*Popup Payment Modal before submiting from cart Working Properly*/
    public function makeSaleQuotation(Request $request)
    {
        $data['customer_id']            = $request->customerId;
        $data['reference_id']           = $request->reference_id;
        $data['fianl_total_item']       = $request->totalItem;
        $data['final_sub_total_amount'] = number_format($request->subTotalAmount,2,'.', '');
        $data['final_discount_type']    = $request->discountType;
        $data['final_discount_value']   = number_format($request->discountValue,2,'.', '');
        $data['final_discount_amount']  = $request->discountAmount?number_format($request->discountAmount,2,'.', ''):'';
        $data['fianl_other_cost']       = number_format($request->otherCost,2,'.', '');
        $data['fianl_payable_amount']   = number_format($request->payableAmount,2,'.', '');

        $data['banks']              = Bank::get();
        $data['payment_methods']    = PaymentMethod::whereNull('deleted_at')->get();
        $data['total_due_amount']   = Customer::findOrFail($request->customerId);  
        return view('backend.sale_pos.ajax.hold.create_quotation_hold',$data);
    }




    //not using this
    /*Store From Add To Cart With Payment Modal, Working Properly*/
    public function storeFromAddToCartWithPayment(Request $request)
    {
        return $request;
        $input = $request->except('_token');
        $validator = Validator::make($input,[
            //'sale_date' => 'required|min:10:max:10',
            'customer_id' => 'required',
            'final_sub_total_amount' => 'required',
            //'order_no' => 'required|min:2|max:30',
            'product_id.*' => 'nullable|max:100',
            //'description.*' => 'nullable|max:100',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($request->final_sub_total_amount < 1)
        {
            return redirect()->back()->with('error','Something went wrong!');
        }
        /* $y = substr($request->sale_date,6);;
        $d =  substr($request->sale_date,0,2);
        $m = substr($request->sale_date,3,2);
        $date = $y."-".$m."-".$d;
        $sale_date =  date('Y-m-d',strtotime($date)); */
        $sale_date =  date('Y-m-d h:s:i a');
        // Start transaction!
        DB::beginTransaction();
        try {
                $data = new SaleFinal();
                $data->customer_id          = $request->customer_id;
                $data->quantity             = 1;
                $data->sub_total            = $request->final_sub_total_amount;
                $data->discount_type        = $request->final_discount_type;
                $data->discount_value       = $request->final_discount_value;
                $data->discount_amount      = $request->final_discount_amount;
                $data->other_cost           = $request->fianl_other_cost;
                $data->final_total          = $request->fianl_payable_amount;
                $data->paid_total           = $request->paid_amount;
                $data->sale_date            = $sale_date;
                $data->payment_method_id    = $request->payment_method;
                $data->payment_note         = $request->account_note;
                $data->payment_date         = $sale_date;
                $data->payment_received_by  = Auth::user()->id;
                $data->created_by           = Auth::user()->id;
                $save = $data->save();
                $data->order_no = $data->id;
                $finalQuantity = 0;
                if($save)
                {
                    if($request->product_id)
                    {
                        foreach ($request->product_id as $key => $product)
                        {
                            $sale_detail                    =  new SaleDetail();
                            $sale_detail->sale_final_id     = $data->id;
                            $sale_detail->customer_id       = $request->customer_id;
                            $sale_detail->order_no          = $data->order_no;

                            $sale_detail->product_id        = $product;
                            $sale_detail->quantity          = $request->quantity[$key];
                            $sale_detail->unit_price        = $request->sale_price[$key];
                            $sale_detail->discount_type     = $request->discount_type[$key];
                            $sale_detail->discount_value    = $request->discount_value[$key];
                            $sale_detail->discount_amount   = (($request->quantity[$key] * $request->sale_price[$key])-($request->product_sub_Total_sale_amount[$key]));
                            $sale_detail->sub_total         = ($request->product_sub_Total_sale_amount[$key]);
                            $sale_detail->sale_date         = $sale_date;
                            //$sale_detail->description       = $request->description[$key];
                            $sale_detail->created_by        = Auth::user()->id;
                            $sale_detail->save();

                            $finalQuantity += $request->quantity[$key];
                        // product quantity subtraction from product table
                        //$this->subtractionProductQuantity($product,$request->quantity[$i]);
                        // product quantity subtraction from product table


                            if($request->identity_number[$key])
                            {
                                $productFind = Product::find($product);
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
                                $warranty_guarantee->sale_date                  = $sale_date;
                                $warranty_guarantee->warranty_guarantee_type    = $wG_type ;
                                $warranty_guarantee->quantity                   = $request->quantity[$key];
                                $warranty_guarantee->identity_number            = $request->identity_number[$key];;
                                $warranty_guarantee->save();
                            }
                        }//foreach end
                    } //if product have end
                }//save if end
                $data->quantity  = $finalQuantity;
                $data->save();
                session(['cartName' => []]);
            }
        catch(\Exception $e)
        {
            DB::rollback();
            if($e->getMessage())
            {
                $message = "Something went wrong! Please Try again";
            }
            return Redirect()->back()
                ->with('error',$message);
        }
            DB::commit();
        return redirect()->back()->with('success','Sale Added Successfully!');
        // session(['cartName' => []]);
    }
    //========================= product quantity subtraction from the product table when creating sale===============
    public function subtractionProductQuantity($product,$quantity)
    {
        $product =  Product::findOrFail($product);
       // $product->quantity               =  ($product->quantity - $quantity);
        $product->save();
    }
    //========================= product quantity subtraction from the product table when creating sale===============
    //========================= product quantity add to the product table when sale delete or update===============
    public function additionProductQuantity($product,$quantity)
    {
        $product =  Product::findOrFail($product);
        //$product->quantity               =  ($product->quantity + $quantity);
        $product->save();
    }
    //========================= product quantity add to the product table when sale delete or update===============






    // Edit Cart
    public function createShowEditModal(Request $request)
    {
        //$data['product']  = Product::find($request->product_id);
        $data['product']        = ProductVariation::find($request->product_id);
                $base_unit_id   = $data['product']->defaultSaleUnits?$data['product']->defaultSaleUnits->base_unit_id:NULL;
        $data['sale_units']     = Unit::where('base_unit_id',$base_unit_id)->whereNull('deleted_at')->latest()->get();
        $data['stocks']         = Stock::where('business_location_id',1)->where('stock_type_id',2)->get();
        $data['primary_stocks'] = PrimaryStock::where('business_location_id',1)
                                                ->where('product_variation_id',$request->product_id)
                                                ->get();

        /*----====----Offer system-------====------*/
        $applicable_offer       = $data['product']->applicable_for_offer_promo_code;
        $promo_code_end_time    = $data['product']->promo_code_end_time;
        $promo_code_less_amount = $data['product']->offer_promo_code_less_amount?$data['product']->offer_promo_code_less_amount:0;
        $offer_promo_code       = $data['product']->offer_promo_code;
        $offer_promo_code       = NULL;

        $promo_offer_from   =  strtotime('2021-02-15 12:20');
        $promo_offer_to     =  strtotime('2021-02-20 12:20');
        $compareDate        =  strtotime(date('Y-m-d h:i:s'));
        $applicable_offer = 1; //overwright
        $offer_activate = 0;
        if($promo_offer_from <= $compareDate && $promo_offer_to >= $compareDate && $applicable_offer)
        {
            $offer_activate = 1;
        }else{
            $offer_activate = 0;
        }
        $data['promo_offer_code'] = $offer_promo_code;
        $data['promo_offer_activate_status'] = $applicable_offer;
        $data['promo_offer_price'] = $data['product']->default_selling_price - $promo_code_less_amount;
        /*----====----Offer system-------====------*/


        $cartName = [];
       
        $cartName               =   session()->has('cartName') ? session()->get('cartName')  : [];
        $productVari            =   $data['product'];

            if(array_key_exists($productVari->id,$cartName))
            {
                $data['purchase_price']     =  $cartName[$productVari->id]['purchase_price'] ;
                $data['sale_price']         =  $cartName[$productVari->id]['sale_price']  ;
                $data['discountType']       =  $cartName[$productVari->id]['discountType'] ;
                $data['discountValue']      =  $cartName[$productVari->id]['discountValue'] ;
                $data['quantity']           =  $cartName[$productVari->id]['quantity'] ; 
                $data['netTotalAmount']     =  $cartName[$productVari->id]['netTotalAmount'];
                $data['identityNumber']     =  $cartName[$productVari->id]['identityNumber'];

                $data['sale_type_id']       =  $cartName[$productVari->id]['sale_type_id'];         
                $data['sale_from_stock_id'] =  $cartName[$productVari->id]['sale_from_stock_id'];
                $data['sale_unit_id']       =  $cartName[$productVari->id]['sale_unit_id'];     
                $data['selling_unit_name']  =  $cartName[$productVari->id]['selling_unit_name'];
            }   

        return view('backend.sale_pos.ajax.create_show_edit_modal',$data);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
