<?php

namespace App\Http\Controllers\Backend\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Backend\Sale\SaleFinal;
use App\Model\Backend\Sale\SaleDetail;

use App\Model\Backend\Unit\Unit;
use App\Model\Backend\Product\ProductVariation;
use App\Model\Backend\Stock\Stock;

use App\Traits\Sell\SaleCartTrait;
class SaleEditCartController extends Controller
{
    use SaleCartTrait;
    // if  edit cart is exit
    public function saleEditWhenEditCartExit(Request $request)
    {
        $data['sale_final'] = SaleFinal::find($request->id);
        $saleDetails        = SaleDetail::whereNull('deleted_at')->where('sale_final_id',$request->id)->get();
        foreach ($saleDetails as $key => $value)
        {
            $this->cartName         = "saleEditCart";
            $this->product_var_id   = $value->product_variation_id;
            $this->saleDetails      = $value;
            $this->cartInsertUpdateWhenReturnOrEditSale();
        }
        $data['cartName'] = $this->cartName;
        return view('backend.sale_pos.edit.ajax.cart_item_list',$data);
    }

    //purchase_price
    // if  edit cart is exit
    public function changingQuantityFromSaleEditCartList(Request $request)
    {
        $this->cartName         = "saleEditCart";
        $this->saleDetails      = $request->product_var_id;
        $this->product_var_id   = $request->product_var_id;
        $this->changeType       = $request->change_type;
        $this->whenChangingQuantityFromCartList();
        $data['cartName'] = $this->cartName;
        $html =  view('backend.sale_pos.edit.ajax.cart_item_list',$data)->render();
        return response()->json([
            'status' => true,
            'available_status' => $this->available_status,
            'html'  => $html
        ]);
    }

    // remove single data from cart
    public function removeSingleDataFromEditSaleCart(Request $request)
    {
        $this->cartName         = "saleEditCart";
        $this->product_var_id   = $request->product_var_id;
        $this->removeSingleDataFromCart();
        $data['cartName'] = $this->cartName;
        return view('backend.sale_pos.edit.ajax.cart_item_list',$data);
    }
    // remove single data from cart
    public function removeAllDataFromEditSaleCart()
    {
        $this->cartName         = "saleEditCart";
        $this->removeAllDataFromSaleEditCreateCart();
        $data['cartName'] = $this->cartName;
        return view('backend.sale_pos.edit.ajax.cart_item_list',$data);
    }

    public function editSaleEditModal(Request $request)
    {
        $this->cartName         = "saleEditCart";
        $this->product_var_id   = $request->product_var_id;
        $data = $this->saleEditShowModalWhenWantToEditCartModal();
        $data['cartName']       = $this->cartName;
        $data['saleDetailId']   = $this->singleCartId;
        return view('backend.sale_pos.edit.ajax.edit_modal_show',$data);
    }

    public function editSaleUpdateCartFromModal(Request $request)
    {
        $this->cartName         = "saleEditCart";
        $this->singleCartId     = $request->saleDetailId;
        $this->product_var_id   = $request->product_variation_id;
        $this->saleDetails      = $request->saleDetailId;
        $this->discountType     = $request->discountType;
        $this->discountValue    = $request->discountValue;
        $this->discountValue    = 0;
        $this->sale_unit_price  = $request->sale_price;
        $this->$purchase_price  = $request->purchase_price;
        $this->identityNumber   = $request->identityNumber;
        $this->quantity         = $request->quantity;
        $this->sale_from_stock_id = $request->sale_from_stock_id;
        $this->sale_type_id    = $request->sale_type_id;
        $this->sale_unit_id    = $request->sale_unit_id;
        $this->sub_total       = $request->netTotalAmount;
        $this->selling_unit_name = $request->selling_unit_name;
        
        $this->updateSaleCartWhenUpdatingFromEditModalOfSaleEdit();
        $data['cartName'] = $this->cartName;
        return view('backend.sale_pos.edit.ajax.cart_item_list',$data);
    }



        /**search product by code... */
        public function searchProductBySkyBarCodeForAddToCartWhenSaleEdit(Request $request)
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
                $query->orWhere(function($q)use ($search){
                return $q->orWhere('products.company_code','like','%'.$search.'%');
                });
                $query->orWhere(function($q)use ($search){
                return $q->orWhere('products.custom_code','like','%'.$search.'%');
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
                    $this->cartName         = "saleEditCart";
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
                        $this->inserInToCartWhenSearchSingleProductBySkuBarCodePname();
                    }
                    $data['cartName'] = $this->cartName ;
                    $html =  view('backend.sale_pos.edit.ajax.cart_item_list',$data)->render();
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




        public function addToCartSingleProductByResultOfSearchingByAjax(Request $request)
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
                $this->cartName         = "saleEditCart";
                $this->productVariations = $productVariation;
                $this->product_var_id   = $productVariation->id;
                $this->discountType     = 'fixed';
                $this->discountValue    = 0;
                $this->discount_amount  = 0;
                $this->sale_unit_price  = $productVariation->default_selling_price;
                $this->purchase_price  = $productVariation->default_purchase_price;
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
                    $this->inserInToCartWhenSearchSingleProductBySkuBarCodePname();
                }
                $data['cartName'] = $this->cartName ;
            $html =  view('backend.sale_pos.edit.ajax.cart_item_list',$data)->render();
            return response()->json([
                'status'    => true,
                'match'     =>'single',
                'qty_status'=> $checkQty,
                'data'      => $html
            ]);
        }




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
