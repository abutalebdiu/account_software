<?php

namespace App\Http\Controllers\Backend\ReceivedPurchaseProduct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Backend\Supplier;
use App\Model\Backend\Purchase\PurchaseFinal;
use App\Model\Backend\Purchase\PurchaseDetail;
use App\Model\Backend\PurchaseProductReceiveHistory\PurchaseProductReceiveHistory;
class AddToCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function purchaseProductReceiveCartIfExist(Request $request)
    {
        return view('backend.receive_purchase_product.ajax.create_list');
    }

    public function searchAndAddToCart(Request $request)
    {
        $chalan_no      = $request->chalan_no;
        $reference_no   = $request->reference_no;
        $invoice_no     = $request->invoice_no;
        $supplier_id    = $request->supplier_id;
        $data = PurchaseDetail::where('purchase_final_id',$request->purchase_final_id)->whereNull('deleted_at')->get();
        foreach ($data as $key => $value)
        {
            $this->addToSessionForCart($value);
        }
        return view('backend.receive_purchase_product.ajax.create_list');
    }


    /**from pulling product by ajax */
    public function addToSessionForCart($purchase)
    {
        $receiveProductPurchaseCart = [];
        $receiveProductPurchaseCart = session()->has('receiveProductPurchaseCart') ? session()->get('receiveProductPurchaseCart')  : [];
        if($purchase)
        {
            $sizeName = NULL;$weightName = NULL;$colorName = NULL; $name =NULL;
            if($purchase->productVariations->sizes) $sizeName       = " - ".$purchase->productVariations->sizes->name;
            if($purchase->productVariations->colors) $colorName     = " - ".$purchase->productVariations->colors->name;
            if($purchase->productVariations->weights) $weightName   = " - ".$purchase->productVariations->weights->name;
            if($purchase->productVariations->products) $name        = $purchase->productVariations->products->name;
            $productName = $name . $sizeName . $colorName . $weightName;
            if(array_key_exists($purchase->id,$receiveProductPurchaseCart))
            {
                //$receiveProductPurchaseCart[$order->id]['total_price'] = $receiveProductPurchaseCart[$order->id]['quantity'] * $receiveProductPurchaseCart[$order->id]['unit_price'];
            }
            else{
                    $receiveProductPurchaseCart[$purchase->product_variation_id] = [
                    'product_var_id'        => $purchase->product_variation_id,
                    'product_name'          => $productName ,
                    'product_id'            => $purchase->product_id,
                    'default_purchase_unit_id' => $purchase->default_purchase_unit_id,
                    'default_purchase_unit' => $purchase->defaultPurchaseUnits?$purchase->defaultPurchaseUnits->short_name:NULL,
                    'purchase_quantity'     =>$purchase->quantity,
                    'total_received_qty'    => number_format($purchase->totalReceivedQtys(),2),
                    'receiving_qty'         => 0,
                    'total_due_qty'         => number_format((($purchase->quantity) - ($purchase->totalReceivedQtys())),2),
                ];
            }
            session(['receiveProductPurchaseCart' => $receiveProductPurchaseCart]);
        }
        return true;
    }
    /**from pulling product by ajax */


    public function updatePurchaseReceiveAddToCart(Request $request)
    {
        $product_variation_id              = $request->product_variation_id;
        $receivingQty                   = $request->receivingQty;
        $totalOrderQuantity             = $request->totalOrderQuantity;
        $totalOrderReceivedQuantity     = $request->totalOrderReceivedQuantity;
        $totalDueQty                    = $request->totalDueQty;

        $receiveProductPurchaseCart = [];
        $receiveProductPurchaseCart = session()->has('receiveProductPurchaseCart') ? session()->get('receiveProductPurchaseCart')  : [];
        if($product_variation_id)
        {
            if(array_key_exists($product_variation_id,$receiveProductPurchaseCart))
            {
                $receiveProductPurchaseCart[$product_variation_id]['receiving_qty'] = number_format($receivingQty,2);
                $receiveProductPurchaseCart[$product_variation_id]['total_due_qty'] = number_format($totalDueQty,2);
            }
            session(['receiveProductPurchaseCart' => $receiveProductPurchaseCart]);
        }
        return view('backend.receive_purchase_product.ajax.create_list');
    }
    


    /**remove single  purchase cart */
    public function removeSinglepurchaseProductReceiveCart(Request $request)
    {
        $receiveProductPurchaseCart = session()->has('receiveProductPurchaseCart') ? session()->get('receiveProductPurchaseCart')  : [];
        unset($receiveProductPurchaseCart[$request->input('product_variation_id')]);
        session(['receiveProductPurchaseCart'=>$receiveProductPurchaseCart]);
        return view('backend.receive_purchase_product.ajax.create_list');
    }
    /**remove all purchase cart */
    public function removeAllpurchaseProductReceiveCart(Request $request)
    {
        session(['receiveProductPurchaseCart' => []]);
        return view('backend.receive_purchase_product.ajax.create_list');
    }


}
