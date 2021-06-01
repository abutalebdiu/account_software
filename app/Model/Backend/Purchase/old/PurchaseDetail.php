<?php

namespace App\Model\Backend\Purchase;

use Illuminate\Database\Eloquent\Model;
use App\Model\Backend\Product\ProductVariation;
use App\Model\Backend\Unit\Unit;
use App\Model\Backend\PurchaseProductReceiveHistory\PurchaseProductReceiveHistory;
class PurchaseDetail extends Model
{
    public function productVariations()
    {
        return $this->belongsTo(productVariation::class,'product_variation_id','id');
    }
    
    public function defaultPurchaseUnits()
    {
        return $this->belongsTo(Unit::class,'default_purchase_unit_id','id');
    }
    
    /*********** Receive Purchase Product************/
    public function totalReceivedQtys()
    {
        return PurchaseProductReceiveHistory::where('purchase_detail_id',$this->id)
                                    ->whereNull('deleted_at')
                                    ->sum('received_quantity');
        
    } 
    /*********** Receive Purchase Product************/
}
