<?php

namespace App\Http\Controllers\Sale\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Backend\Sale\Sale_final;
use App\Models\Backend\Sale\Sale_detail;
use App\Models\Backend\Sale\Sale_warranty_guarantee;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Auth;
class AjaxController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProductDetailsByModalForAddingCart(Request $request)
    {
        $data['product']   = Product::find($request->product_id);
        return view('backend.sale.ajax.product_detail_show_by_modal_adding_cart',$data);
    }



    public function createShowModal(Request $request)
    {
        $data['product']   = Product::find($request->product_id);
        return view('backend.sale_pos.ajax.create_show_modal',$data);
    }


    public function addToCartFromModal(Request $request)
    {
        //session(['cartName' => []]);
       // $data['product']   = Product::find($request->product_id);
        $cartName = [];
        $product_id     =  $request->product_id;
        $sale_price     =  $request->sale_price;
        $discountType   =  $request->discountType;
        $quantity       =  $request->quantity;
        $discountValue  =  $request->discountValue;
        $netTotalAmount =  $request->netTotalAmount;
        $identityNumber =  $request->identityNumber;
        $cartName = session()->has('cartName') ? session()->get('cartName')  : [];
        $product =  Product::find($request->product_id);
        if($product)
        {
            if(array_key_exists($product->id,$cartName))
                {
                    $cartName[$product->id]['sale_price'] = number_format($sale_price,2);  
                    $cartName[$product->id]['discountValue'] = $discountValue;  
                    $cartName[$product->id]['quantity'] =  $quantity;  
                    $cartName[$product->id]['netTotalAmount'] = number_format($quantity * $sale_price ,2);
                    $cartName[$product->id]['identityNumber'] = $identityNumber;
                    //$cartName[$product->id]['quantity'] = $cartName[$product->id]['quantity'] + $quantity;  
                    //$cartName[$product->id]['netTotalAmount'] = $cartName[$product->id]['quantity'] * $sale_price;
                }
            else{
                $cartName[$product->id] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'sale_price' => number_format($sale_price,2),
                    'discountType' => $discountType,
                    'quantity' => $quantity,
                    'discountValue' => $discountValue,
                    'netTotalAmount' => number_format($netTotalAmount,2),
                    'identityNumber' => $identityNumber,
                ];
            }
            session(['cartName' => $cartName]);
        }
        return view('backend.sale.ajax.add_to_cart_show');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeQuantityFromCart(Request $request)
    {
        //session(['cartName' => []]);
        $data['product']   = Product::find($request->product_id);
        $cartName = [];
        $product_id =  $request->product_id;
        $change_type =  $request->change_type;
        $sale_price =  $request->sale_price;
        $discountType =  $request->discountType;
        $quantity =  $request->quantity;
        $discountValue =  $request->discountValue;
        $netTotalAmount =  $request->netTotalAmount;
        $identityNumber =  $request->identityNumber;
        $cartName = session()->has('cartName') ? session()->get('cartName')  : [];
        $product =  Product::find($request->product_id);
        if($product)
        {
            if(array_key_exists($product->id,$cartName))
                {
                    if($change_type == 'minus' && $cartName[$product->id]['quantity'] > 1)
                    {
                        $quantity = $cartName[$product->id]['quantity'] - 1;
                    }
                    else if($change_type == 'plus')
                    {
                        $quantity = $cartName[$product->id]['quantity'] + 1;
                    }
                    
                    if($cartName[$product->id]['discountType'] == "percentage" && $cartName[$product->id]['discountValue'])
                    {
                      $totalDiscountAmount =  ($quantity *  $cartName[$product->id]['sale_price']) * ($cartName[$product->id]['discountValue']) /100;
                    }
                    else if($cartName[$product->id]['discountType'] == "fixed" && $cartName[$product->id]['discountValue'])
                    {
                        $totalDiscountAmount =  $cartName[$product->id]['discountValue'] ;
                    }
                    else{
                        $totalDiscountAmount = 0 ;
                    }
                    $cartName[$product->id]['product_id']       =  $request->product_id;  
                    $cartName[$product->id]['name']             =  $cartName[$product->id]['name'] ;  
                    $cartName[$product->id]['sale_price']       =  number_format($cartName[$product->id]['sale_price'],2) ;  
                    $cartName[$product->id]['discountType']     =  $cartName[$product->id]['discountType'] ;  
                    $cartName[$product->id]['discountValue']    =  $cartName[$product->id]['discountValue'] ;  
                    $cartName[$product->id]['quantity']         =  $quantity;  
                    $cartName[$product->id]['netTotalAmount']   =  number_format(($quantity *  $cartName[$product->id]['sale_price']) - $totalDiscountAmount,2);
                    $cartName[$product->id]['identityNumber']   =  $cartName[$product->id]['identityNumber'] ;
                    //$cartName[$product->id]['quantity'] = $cartName[$product->id]['quantity'] + $quantity;  
                    //$cartName[$product->id]['netTotalAmount'] = $cartName[$product->id]['quantity'] * $sale_price;
                }
            else{
                $cartName[$product->id] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'sale_price' => number_format($sale_price,2),
                    'discountType' => $discountType,
                    'quantity' => $quantity,
                    'discountValue' => $discountValue,
                    'netTotalAmount' => number_format($netTotalAmount,2),
                    'identityNumber' => $identityNumber,
                ];
            }
            session(['cartName' => $cartName]);
        }
        return view('backend.sale.ajax.add_to_cart_show',$data);
    }



    public function showCartIfExisting()
    {
        $cartName = session()->has('cartName') ? session()->get('cartName')  : [];
        if($cartName)
        {
            return view('backend.sale.ajax.add_to_cart_show');
        }else{
            return false;
        }
       
    }

    public function removeSingleCart(Request $request)
    {
        $cartName = session()->has('cartName') ? session()->get('cartName')  : [];
		unset($cartName[$request->input('product_id')]);	
        session(['cartName'=>$cartName]);
        return view('backend.sale.ajax.add_to_cart_show');
    }

    public function removeAllDataFromCart()
    {
        session(['cartName' => []]);
        return view('backend.sale.ajax.add_to_cart_show');
    }











     /**
     * Show Product Details By Modal For Editing Cart
     *
     * @return \Illuminate\Http\Response
     */
    public function showProductDetailsByModalForEditingCart(Request $request)
    {
        $product =  Product::find($request->product_id);
        $data['product']   = $product ;

        $cartName = session()->has('cartName') ? session()->get('cartName')  : [];
        
        $data['sale_price']     = "";
        $data['discountType']  = "";
        $data['discountValue']  = "";
        $data['quantity']       = "";
        $data['netTotalAmount'] = "";
        $data['identityNumber'] = "";
        if(array_key_exists($product->id,$cartName))
        {
           $data['sale_price']     =  $cartName[$product->id]['sale_price'] ;  
           $data['discountType']   =  $cartName[$product->id]['discountType'] ;  
           $data['discountValue']  =  $cartName[$product->id]['discountValue'] ;  
           $data['quantity']       =  $cartName[$product->id]['quantity'] ;  
           $data['netTotalAmount'] =  $cartName[$product->id]['netTotalAmount'] ;
           $data['identityNumber'] =  $cartName[$product->id]['identityNumber'] ;
        }

        return view('backend.sale.ajax.product_detail_show_by_modal_editing_cart',$data);
    }



    public function editAddToCartFromModal(Request $request)
    {
        //session(['cartName' => []]);
        $data['product']   = Product::find($request->product_id);
        $cartName = [];
        $product_id =  $request->product_id;
        $sale_price =  $request->sale_price;
        $discountType =  $request->discountType;
        $quantity =  $request->quantity;
        $discountValue =  $request->discountValue;
        $netTotalAmount =  $request->netTotalAmount;
        $identityNumber =  $request->identityNumber;
        $cartName = session()->has('cartName') ? session()->get('cartName')  : [];
        $product =  Product::find($request->product_id);
        if($product)
        {
            if(array_key_exists($product->id,$cartName))
            {
                if($cartName[$product->id]['discountType'] == "percentage" && $cartName[$product->id]['discountValue'])
                {
                    $totalDiscountAmount =  ($quantity *  $sale_price) * ($discountValue) /100;
                }
                else if($cartName[$product->id]['discountType'] == "fixed" && $cartName[$product->id]['discountValue'])
                {
                    $totalDiscountAmount =  $discountValue ;
                }
                else{
                    $totalDiscountAmount = 0 ;
                }

                $cartName[$product->id]['sale_price'] = number_format($sale_price,2);  
                $cartName[$product->id]['discountValue'] = $discountValue;  
                $cartName[$product->id]['quantity'] =  $quantity;  
                $cartName[$product->id]['identityNumber'] = $identityNumber;
                $cartName[$product->id]['netTotalAmount']   =  number_format(($quantity *  $sale_price) - $totalDiscountAmount ,2);
                // $cartName[$product->id]['netTotalAmount'] = $quantity * $sale_price;
            }
            else{
                $cartName[$product->id] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'sale_price' => number_format($sale_price,2),
                    'discountType' => $discountType,
                    'quantity' => $quantity,
                    'discountValue' => $discountValue,
                    'netTotalAmount' => $netTotalAmount,
                    'identityNumber' => $identityNumber,
                ];
            }
            session(['cartName' => $cartName]);
        }
        return view('backend.sale.ajax.add_to_cart_show',$data);
    }








    public function showPaymentModalForSubmitingCart(Request $request)
    {
        $data['customer_id'] = $request->customerId;
        $data['employee_Id'] = $request->employeeId;
        $data['fianl_total_item'] = $request->totalItem;
        $data['final_sub_total_amount'] = number_format($request->subTotalAmount,2);
        $data['final_discount_type'] = $request->discountType;
        $data['final_discount_value'] = number_format($request->discountValue,2);
        $data['final_discount_amount'] = $request->discountAmount?number_format($request->discountAmount,2):'';
        $data['fianl_other_cost'] = number_format($request->otherCost,2);
        $data['fianl_payable_amount'] = number_format($request->payableAmount,2);
        return view('backend.sale.ajax.payment.payment_modal',$data);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function storeAddToCartWithPayment(Request $request)
    {
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
                $data = new Sale_final();
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
                            $sale_detail                    =  new Sale_detail();
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
