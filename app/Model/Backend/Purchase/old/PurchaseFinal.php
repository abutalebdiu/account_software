<?php

namespace App\Model\Backend\Purchase;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Backend\Purchase\PurchaseDetail;
use App\Model\Backend\Supplier;
use DB;
class PurchaseFinal extends Model
{
    public function createdBy()
    {
        return $this->belongsTo(User::class,'purchase_created_by','id');
    }
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    //-------========== Total and sub total with discount , tax, shipping -----=====-------
        public function subTotalPurchaseAmount()
        {
            //return PurchaseDetail::where('purchase_final_id',$this->id)->sum('purchase_sub_total_inc_tax_amount');
                $data =   PurchaseDetail::select(DB::raw('sum(quanity*purchase_unit_price_inc_tax) as sub_total'))
                                    ->where('purchase_final_id',$this->id)
                                    ->get();
            return $data->sum('sub_total');
        }

        protected $disAmount;
        public function discountAmounts()
        {
            $this->disAmount =  0;
            if($this->discount_type)
            {
                if($this->discount_type ==1)
                {
                    $this->disAmount = $this->discount_value * $this->subTotalPurchaseAmount() / 100;
                }else{
                    $this->disAmount = $this->discount_value;
                }
            }
            return number_format($this->disAmount,2);
        }

        protected $taxAmt;
        public function taxAmounts()
        {
            $this->taxAmt =  0;
            if($this->purchase_tax_applicable)
            {
                if($this->purchase_tax_applicable ==1)
                {
                    $this->taxAmt = ($this->purchase_tax_in_parcent_value * ($this->subTotalPurchaseAmount() - $this->discountAmounts())) / 100;
                }else{
                    $this->taxAmt = $this->purchase_tax_in_parcent_value;
                }
            }
            return number_format($this->taxAmt,2);
        }

        protected $addinShipChg;
        public function additionalShippingCharges()
        {
            $this->addinShipChg = 0;
            if($this->additional_shipping_charge)
            {
                $this->addinShipChg = $this->additional_shipping_charge;
            }
            return number_format($this->addinShipChg,2);
        }

        public function totalPurchaseAmount()
        {
            return  ($this->subTotalPurchaseAmount() + $this->taxAmounts() + $this->additionalShippingCharges()) - $this->discountAmounts();

        }
        public function totalPaidAmount()
        {
            return 0 ;
        }
        public function totalDueAmount()
        {
            return  ($this->totalPurchaseAmount() - $this->totalPaidAmount());
        }
    //-------========== Total and sub total with discount , tax, shipping -----=====-------
}
