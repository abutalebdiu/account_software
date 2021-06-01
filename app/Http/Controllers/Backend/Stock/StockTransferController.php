<?php

namespace App\Http\Controllers\Backend\Stock;

use App\Http\Controllers\Controller;
use App\Model\Backend\Stock\PrimaryStock;
use App\Model\Backend\Stock\SecondaryStock;
use App\Model\Backend\Stock\Stock;
use App\Model\Backend\Stock\StockTransferHistory;
use App\Model\Backend\Stock\StockType;
use Illuminate\Http\Request;
use DB;
class StockTransferController extends Controller
{

    public function stockTransferModal(Request $request) 
    {
        $pStockId                   = $request->id;
        $stock_type_id              = $request->stock_type_id;
        if($stock_type_id == 2)
        {
            $stockId                    = PrimaryStock::findOrFail($pStockId);
        }else if($stock_type_id == 3)
        {
            $stockId                    = SecondaryStock::findOrFail($pStockId);
        }
       
        $data['stocks']             = Stock::whereNotIn('id',[$pStockId])
                                        ->where('stock_type_id',$stock_type_id)
                                        ->whereNull('deleted_at')
                                        ->get();

        $stockFrom                  = Stock::find($stockId->stock_id);
        $data['stockName']          = $stockFrom->name;
        $data['stockId']            = $stockFrom->id;

        $stockTypeFrom              = StockType::find($stock_type_id);
        $data['stockTypeName']      = $stockTypeFrom->name;
        $data['stockTypeId']        = $stockTypeFrom->id;
        $data['stock_types']        = StockType::whereNotIn('id',[1])->whereNull('deleted_at')->get();

        $pName      =  $stockId->productVariations?$stockId->productVariations->products?$stockId->productVariations->products->name:NULL:NULL;
        $pSize      =  $stockId->productVariations?$stockId->productVariations->sizes?" (".$stockId->productVariations->sizes->name .") ":NULL:NULL;
        $pColor     =  $stockId->productVariations?$stockId->productVariations->colors?" (".$stockId->productVariations->colors->name .") ":NULL:NULL;
        $pWeight    =  $stockId->productVariations?$stockId->productVariations->weights?" (".$stockId->productVariations->weights->name .") ":NULL:NULL;
        
        $data['productName']        = $pName . $pSize .  $pColor .$pWeight ;
        
        $avl_stock = availableStock_HH($stockId->productVariations?$stockId->productVariations->defaultPurchaseUnits?$stockId->productVariations->default_purchase_unit_id:NULL:NULL,$stockId->available_stock);
        
        $data['availableQty']       = number_format($avl_stock,3) ;
        $data['purchaseUnit']       =  $stockId->productVariations?$stockId->productVariations->defaultPurchaseUnits?$stockId->productVariations->defaultPurchaseUnits->short_name:NULL:NULL;
        $data['purchaseUnitId']     =  $stockId->productVariations?$stockId->productVariations->defaultPurchaseUnits?$stockId->productVariations->defaultPurchaseUnits->id:NULL:NULL;
        
        $data['product_id']           = $stockId->product_id;
        $data['product_variation_id'] = $stockId->product_variation_id;
        return view('backend.stock.primary_stock.ajax.transfer',$data);
    }



    /**post method, transfer Stock Quantity */
    public function transferStockQuantity(Request $request)
    {
        // Start transaction!
        DB::beginTransaction();
        try
        {
            $product_id             = $request->product_id;
            $product_variation_id   = $request->product_variation_id;
            $purchase_unit_id       = $request->purchase_unit_id;
            $from_stock_type_id     = $request->from_stock_type_id;
            $from_stock_id          = $request->from_stock_id;
            $fromTransferAvlQuantity = $request->available_stock_quantity;
            $to_stock_type_id       = $request->to_stock_type_id;
            $to_stock_id            = $request->to_stock_id;
            $transfer_quantity      = $request->transfer_quantity;

            $total_transfer_qty     = getTotalQuantityByUnitId_HH($purchase_unit_id, $transfer_quantity);

            /**stock transfer history */
                $stockTransferHistory = new StockTransferHistory();
                $stockTransferHistory->business_location_id     = 1;
                $stockTransferHistory->business_type_id         = 1;
                $stockTransferHistory->from_stock_type_id       = $from_stock_type_id;
                $stockTransferHistory->from_stock_id            = $from_stock_type_id;
                $stockTransferHistory->from_product_id          = $product_id;
                $stockTransferHistory->from_product_variation_id = $product_variation_id;
                $stockTransferHistory->transfer_quantity        = $total_transfer_qty;
        
                $stockTransferHistory->to_stock_type_id         = $to_stock_type_id;
                $stockTransferHistory->to_stock_id              = $to_stock_id;
                $stockTransferHistory->to_product_id            = $product_id;
                $stockTransferHistory->to_product_variation_id = $product_variation_id;
                $stockTransferHistory->receive_quantity         = $total_transfer_qty;
                $stockTransferHistory->created_by               = auth()->user()->id;
                $stockTransferHistory->transfer_by               = auth()->user()->id;
                $stockTransferHistory->save();
            /**stock transfer history */

            /*********************************************************************************/
            /** decrement quantity from stock table */
                if($from_stock_type_id == 2)
                {
                    $query  = PrimaryStock::query();
                }
                else if($from_stock_type_id == 3)
                {           
                    $query  = SecondaryStock::query();
                }
                $fromOldStockId = $query->where('product_variation_id',$product_variation_id)
                                ->where('business_location_id',1)
                                //->where('business_type_id',1)
                                ->where('stock_id',$from_stock_id)
                                ->where('stock_type_id',$from_stock_type_id)
                                ->whereNull('deleted_at')
                                ->first();
                if($fromOldStockId)
                {
                    $fromOldStockId->available_stock  = $fromOldStockId->available_stock  - $total_transfer_qty;
                    $fromOldStockId->save();
                }
            /** decrement quantity from stock table */
            /*********************************************************************************/

            /*********************************************************************************/
                /** now change , transfer to table */
                if($to_stock_type_id == 2)
                {
                    $queryTo     = PrimaryStock::query();
                }else if($to_stock_type_id == 3)
                {
                    $queryTo    = SecondaryStock::query();
                }
                    $toExistStockId =    $queryTo->where('product_id',$product_id)
                            ->where('product_variation_id',$product_variation_id)
                            ->where('business_location_id',1)
                            //->where('business_type_id',1)
                            ->where('stock_id',$to_stock_id)
                            ->where('stock_type_id',$to_stock_type_id)
                            ->whereNull('deleted_at')
                            ->first();
                if($toExistStockId)
                {
                    $toExistStockId->available_stock  = $toExistStockId->available_stock  + $total_transfer_qty;
                    $toExistStockId->save();
                    DB::commit();
                    return redirect()->back()->with(array(
                        'message' => 'Transefer Successfully!',
                        'alert-type' => 'success'
                    ));
                }
                else
                {
                    $data["business_location_id"] = 1;
                    $data["business_type_id"] = 1;
                    $data["stock_type_id"] = $to_stock_type_id;
                    $data["company_id"] = 1;
                    $data["stock_id"] = $to_stock_id;
                    $data["product_variation_id"] = $product_variation_id;
                    $data["product_id"] = $product_id;
                    $data["available_stock"] =  $total_transfer_qty ;
                    $data["used_stock"] = 0;
                    $data["status"] = 1;
                    $data["created_by"] = auth()->user()->id;
                    $data["created_at"] = date('Y-m-d h:i:s');
                
                    if($to_stock_type_id == 2)
                    {
                    $table = "primary_stocks";
                    }
                    else if($to_stock_type_id == 3)
                    {
                        $table = "secondary_stocks";
                    }
                    $save =  DB::table($table)->insert($data);
                    DB::commit();
                    if($save)
                    {
                        return redirect()->back()->with(array(
                            'message' => 'Transefer Successfully!',
                            'alert-type' => 'success'
                        ));
                    }
                }
                /** now change , transfer to table */
            /*********************************************************************************/
            return redirect()->back()->with(array(
                'message' => 'Not Transefer!',
                'alert-type' => 'error'
            ));

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
    /**post method, transfer Stock Quantity */




    public function getStockByStockId(Request $request)
    {
        $stock_id       = $request->stock_id;
        $stock_type_id  = $request->stock_type_id;
        $stocks = Stock::where('stock_type_id',$stock_type_id)
                            ->whereNotIn('id',[$stock_id])
                            ->whereNull('deleted_at')
                            ->get();
        $html = "<option value=''>Select Stock</option>";
        foreach ($stocks as $stock) 
        {
            $html .= "<option value='$stock->id'>$stock->name</option>";
        }
        return ($html);
    }





    /* public function transfer(Request $request) 
    {
        // dd($request->all());
        // dd($request->from_stock_type_id);
        if ($request->to_stock_type_id == 2) {
            if ($request->from_stock_type_id == 2) {
                $existing_data = PrimaryStock::where("id", $request->primary_stock_id)->first();
                if (getTotalQuantityByUnitId_HH($existing_data->products->purchaseUnit->id, $request->transfer_quantity) > $existing_data->available_stock) {
                    return redirect()->back()->with(array(
                        'message' => 'Transefer Quantity is more than Available Quantity!',
                        'alert-type' => 'error'
                    ));
                }

                if (PrimaryStock::where(["product_id" => $existing_data->product_id, "stock_id" => $request->to_stock_id, "stock_type_id" => $request->to_stock_type_id])->where("id", "!=", $existing_data->id)->exists()) {
                    $newStock = PrimaryStock::where(["product_id" => $existing_data->product_id, "stock_id" => $request->to_stock_id, "stock_type_id" => $request->to_stock_type_id])->where("id", "!=", $existing_data->id)->first();
                } else {
                    $newStock = new PrimaryStock();
                }
            } else {
                $existing_data = SecondaryStock::where("id", $request->primary_stock_id)->first();
                if (getTotalQuantityByUnitId_HH($existing_data->products->purchaseUnit->id, $request->transfer_quantity) > $existing_data->available_stock) {
                    return redirect()->back()->with(array(
                        'message' => 'Transefer Quantity is more than Available Quantity!',
                        'alert-type' => 'error'
                    ));
                }
                if (SecondaryStock::where(["product_id" => $existing_data->product_id, "stock_id" => $request->to_stock_id, "stock_type_id" => $request->to_stock_type_id])->where("id", "!=", $existing_data->id)->exists()) {
                    $newStock = SecondaryStock::where(["product_id" => $existing_data->product_id, "stock_id" => $request->to_stock_id, "stock_type_id" => $request->to_stock_type_id])->where("id", "!=", $existing_data->id)->first();
                } else {
                    $newStock = new SecondaryStock();
                }
            }
        } else {
            if ($request->from_stock_type_id == 2) {
                $existing_data = PrimaryStock::where("id", $request->primary_stock_id)->first();
                if (getTotalQuantityByUnitId_HH($existing_data->products->purchaseUnit->id, $request->transfer_quantity) > $existing_data->available_stock) {
                    return redirect()->back()->with(array(
                        'message' => 'Transefer Quantity is more than Available Quantity!',
                        'alert-type' => 'error'
                    ));
                }
                if (PrimaryStock::where(["product_id" => $existing_data->product_id, "stock_id" => $request->to_stock_id, "stock_type_id" => $request->to_stock_type_id])->where("id", "!=", $existing_data->id)->exists()) {
                    $newStock = PrimaryStock::where(["product_id" => $existing_data->product_id, "stock_id" => $request->to_stock_id, "stock_type_id" => $request->to_stock_type_id])->where("id", "!=", $existing_data->id)->first();
                } else {
                    $newStock = new PrimaryStock();
                }
            } else {
                $existing_data = SecondaryStock::where("id", $request->primary_stock_id)->first();
                if (getTotalQuantityByUnitId_HH($existing_data->products->purchaseUnit->id, $request->transfer_quantity) > $existing_data->available_stock) {
                    return redirect()->back()->with(array(
                        'message' => 'Transefer Quantity is more than Available Quantity!',
                        'alert-type' => 'error'
                    ));
                }
                if (SecondaryStock::where(["product_id" => $existing_data->product_id, "stock_id" => $request->to_stock_id, "stock_type_id" => $request->to_stock_type_id])->where("id", "!=", $existing_data->id)->exists()) {
                    $newStock = SecondaryStock::where(["product_id" => $existing_data->product_id, "stock_id" => $request->to_stock_id, "stock_type_id" => $request->to_stock_type_id])->where("id", "!=", $existing_data->id)->first();
                } else {
                    $newStock = new SecondaryStock();
                }
            }
        }
        // dd($newStock);

        $newStock->business_location_id = 1;
        $newStock->business_type_id = 1;
        $newStock->stock_type_id = $request->to_stock_type_id;
        $newStock->stock_id = $request->to_stock_id;
        $newStock->product_id = $existing_data->product_id;
        $newStock->product_variation_id = $existing_data->product_variation_id;
        $newStock->available_stock += getTotalQuantityByUnitId_HH($existing_data->products->purchaseUnit->id, $request->receive_quantity);
        $newStock->stock_lock_applicable = 1;
        $newStock->save();

        $existing_data->available_stock -= getTotalQuantityByUnitId_HH($existing_data->products->purchaseUnit->id, $request->receive_quantity);
        $existing_data->save();


        $stockTransferHistory = new StockTransferHistory();
        $stockTransferHistory->business_location_id = 1;
        $stockTransferHistory->business_type_id = 1;
        $stockTransferHistory->from_stock_type_id = $existing_data->stock_type_id;
        $stockTransferHistory->from_stock_id = $existing_data->stock_id;
        $stockTransferHistory->from_product_id = $existing_data->product_id;
        $stockTransferHistory->from_product_variation_id = $existing_data->product_variation_id;
        $stockTransferHistory->transfer_quantity = getTotalQuantityByUnitId_HH($existing_data->products->purchaseUnit->id, $request->receive_quantity);

        $stockTransferHistory->to_stock_type_id = $newStock->stock_type_id;
        $stockTransferHistory->to_stock_id = $newStock->stock_id;
        $stockTransferHistory->to_product_id = $newStock->product_id;
        $stockTransferHistory->to_product_variation_id = $newStock->product_variation_id;
        $stockTransferHistory->receive_quantity = getTotalQuantityByUnitId_HH($existing_data->products->purchaseUnit->id, $request->receive_quantity);
        $stockTransferHistory->created_by = auth()->user()->id;

        if ($stockTransferHistory->save()) {
            $notification = array(
                'message' => 'Successfully Product Transfer!',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Someting Went Wrong!',
                'alert-type' => 'error'
            );
        }
        return redirect()->back()->with($notification);
    } */

    public function getStock(PrimaryStock $primaryStock)
    {
        return $request;
       /*  $primaryStock->stock = $primaryStock->stocks;
        $primaryStock->stock_type = $primaryStock->stockType;
        $primaryStock->product = $primaryStock->products;
        $primaryStock->available_stock = availableStock_HH($primaryStock->productVariations ? $primaryStock->products->purchaseUnit->id  : NULL, $primaryStock->available_stock);
        $productVariation = (!empty($primaryStock->productVariations->sizes) ? "{" . $primaryStock->productVariations->sizes->name . "}" : "");
        $productVariation .= (!empty($primaryStock->productVariations->colors) ? "{" . $primaryStock->productVariations->colors->name . "}" : "");
        $productVariation .= (!empty($primaryStock->productVariations->weights) ? "{" . $primaryStock->productVariations->weights->name . "}" : "");
        $primaryStock->productVariation = $productVariation;
        $primaryStock->unit = $primaryStock->products->purchaseUnit->full_name;
        $data["primaryStock"] = $primaryStock;
        $data["stockTypes"] = StockType::whereIn("id", [2, 3])->get();
        return $data; */
    }
    public function getStockSecondary(SecondaryStock $secondaryStock)
    {
        // dd($secondaryStock);
        $primaryStock = $secondaryStock;
        $primaryStock->stock = $primaryStock->stocks;
        $primaryStock->stock_type = $primaryStock->stockType;
        $primaryStock->product = $primaryStock->products;
        $primaryStock->available_stock = availableStock_HH($primaryStock->productVariations ? $primaryStock->products->purchaseUnit->id  : NULL, $primaryStock->available_stock);
        $productVariation = (!empty($primaryStock->productVariations->sizes) ? "{" . $primaryStock->productVariations->sizes->name . "}" : "");
        $productVariation .= (!empty($primaryStock->productVariations->colors) ? "{" . $primaryStock->productVariations->colors->name . "}" : "");
        $productVariation .= (!empty($primaryStock->productVariations->weights) ? "{" . $primaryStock->productVariations->weights->name . "}" : "");
        $primaryStock->productVariation = $productVariation;
        $primaryStock->unit = $primaryStock->products->purchaseUnit->full_name;
        $data["primaryStock"] = $primaryStock;
        $data["stockTypes"] = StockType::whereIn("id", [2, 3])->get();
        return $data;
    }

    public function getStocks(StockType $stock_type)
    {
        return Stock::where("stock_type_id", $stock_type->id)->get();
    }
}
