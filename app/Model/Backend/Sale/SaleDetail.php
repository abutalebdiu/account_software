<?php

namespace App\Model\Backend\Sale;

use Illuminate\Database\Eloquent\Model;
use App\Model\Backend\Product\ProductVariation;
use App\Model\Backend\Product\Product;
use App\Model\Backend\Unit\Unit;

use App\Model\Backend\Sale\SaleDetail;
use App\Model\Backend\Sale\SaleWarrantyGuarantee;
use App\Model\Backend\Sale\SaleReturnDetail;

use App\Model\Backend\Customer\Customer;
use DB;
use App\User;

use App\Model\Backend\Payment\AccountPaymentHistory;
use App\Model\Backend\Payment\AccountPaymentHistoryDetail;
use App\Backend\Reference;
class SaleDetail extends Model
{
    private $discountAbleOrNot;

    public function productVariations()
    {
        return $this->belongsTo(ProductVariation::class,'product_variation_id','id');
    }
    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function units()
    {
        return $this->belongsTo(Unit::class,'sale_unit_id','id');
    }


    private $discountAmount;
    /*get sub discount from sale_details table*/
    public function discountAmounts()
    {
        $data =   SaleDetail::select(
                    DB::raw('SUM(CASE 
                    WHEN discount_type = "percentage" 
                    THEN discount_value *  quantity*unit_price / 100
                    ELSE discount_value 
                    END) as subTotaldiscountAmount')
                    )
                ->where('invoice_status',1)
                ->where('id',$this->id)
                ->whereNull('deleted_at')
                //->where('sale_final_id',$this->id)
                ->get();
        if($this->quantity > 0)
        {   
            return number_format($data->sum('subTotaldiscountAmount'),2,'.','');
        }
        return number_format(0,2,'.','') ;
    }
    /*get sub discount from sale_details table*/

    public function subTotalAmount()
    {
       return number_format(($this->unit_price * $this->quantity) - $this->discountAmounts() ,2,'.','');
    }
    /*********************************************************************************************************/


    //not use
    public function totalReturnQuantity()
    {
        SaleReturnDetail::where('product_variation_id',$this->product_variation_id)
                        //->where('business_type_id',1)
                        //->where('business_location_id',1)
                        ->where('sale_final_id',$this->sale_final_id)
                        ->whereNull('deleted_at')
                        ->get();
    }


    /**Sale Warranty guarantee */
    public function saleWarrantyGrarantees()
    {
        return $this->hasOne(SaleWarrantyGuarantee::class,'sale_detail_id',$this->id)->whereNull('deleted_at'); 
    }
    /**Sale Warranty guarantee */





    

    /*********************************************************************************************************** */
            /*****quotation***** */
    /*********************************************************************************************************** */
    /*get sub discount from sale_details table*/
    public function quotationDiscountAmounts()
    {
        $data =   SaleDetail::select(
                    DB::raw('SUM(CASE 
                    WHEN discount_type = "percentage" 
                    THEN discount_value *  quantity*unit_price / 100
                    ELSE discount_value 
                    END) as subTotaldiscountAmount')
                    )
                ->where('invoice_status',2)
                ->where('id',$this->id)
                ->whereNull('deleted_at')
                //->where('sale_final_id',$this->id)
                ->get();
        if($this->quantity > 0)
        {   
            return number_format($data->sum('subTotaldiscountAmount'),2,'.','');
        }
        return number_format(0,2,'.','') ;
    }
    /*get sub discount from sale_details table*/

    public function quotationSubTotalAmount()
    {
       return number_format(($this->unit_price * $this->quantity) - $this->quotationDiscountAmounts() ,2,'.','');
    }
    /*********************************************************************************************************** */

    public function referenceBy()
    {
        return $this->belongsTo(Reference::class,'reference_id','id');
    }
}
