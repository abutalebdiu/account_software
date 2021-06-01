<?php

namespace App\Model\Backend;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Model\Backend\Purchase\PurchaseDetail;
use App\Model\Backend\Supplier;
use DB;
use App\Model\Backend\Purchase\PurchaseFinal;

use App\Model\Backend\Purchase\PurchaseFinalAdditionalNote;
use App\Model\Backend\Purchase\PurchaseShippingAddress;
use App\Model\Backend\PurchaseProductReceiveHistory\PurchaseProductReceiveHistory;

use App\Model\Backend\Payment\AccountPaymentHistory;
use App\Model\Backend\Payment\AccountPaymentHistoryDetail;
class Supplier extends Model
{

    public function createdBy()
    {
        return $this->belongsTo(User::class,'purchase_created_by','id');
    }
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class,'purchase_final_id','id')->whereNull('deleted_at');
    }

    public function additionalNotes(){
        return $this->hasOne(PurchaseFinalAdditionalNote::class, 'purchase_final_id','id')->whereNull('deleted_at');
    }
    public function shippingAddresses(){
        return $this->hasOne(PurchaseShippingAddress::class, 'purchase_final_id','id')->whereNull('deleted_at');
    }


    /************* Total and sub total with discount , tax, shipping************/
        public function subTotalPurchaseAmount()
        {
            //return PurchaseDetail::where('purchase_final_id',$this->id)->sum('purchase_sub_total_inc_tax_amount');
                $data =   PurchaseDetail::select(DB::raw('sum(quantity*purchase_unit_price_inc_tax) as sub_total'))
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
            $data = AccountPaymentHistory::whereNull('deleted_at')
                                ->select(
                                DB::raw('SUM(CASE
                                WHEN payment_type_id = 1
                                    THEN payment_amount
                                END) as income'),
                                DB::raw('SUM(CASE
                                WHEN payment_type_id = 2
                                    THEN payment_amount
                                END) as expense')
                                )
                                ->where('module_id',module_HH()['purchase'])
                                ->where('module_invoice_id',$this->id)
                                ->get();
                $totalIncome    = $data->sum('income');
                $totalExpenese  =  $data->sum('expense');
            return number_format($totalExpenese - $totalIncome,2,'.','') ;

           /*  $data = AccountPaymentHistory::whereNull('deleted_at')
                ->where('module_id',module_HH()['purchase'])
                ->where('module_invoice_id',$this->id)
                ->sum('payment_amount');
                return number_format($data,2,'.','') ; */
                //cdf_HH()['credit'];
                //payment_type_HH()['income'];
        }
        public function totalDueAmount()
        {
           return  ($this->totalPurchaseAmount() - $this->totalPaidAmount());
        }

        public function totalPurchaseItem()
        {
            return $this->hasMany(PurchaseDetail::class,'purchase_final_id','id')->whereNull('deleted_at')->count();
            return PurchaseDetail::where('purchase_final_id',$this->id)
                                ->whereNull('deleted_at')
                                ->count();
        }
       
        /***********************************************************************/
    /************* Total and sub total with discount , tax, shipping************/


    /*********** Receive Purchase Product************/
        //working properly
        public function receivedPurchaseProducts()
        {
            return $this->hasMany(PurchaseProductReceiveHistory::class,'purchase_final_id','id')->whereNull('deleted_at');
        }
        public function totalReceivedQuantity()
        {
            $data =  PurchaseProductReceiveHistory::where('purchase_final_id',$this->id)
                ->select(DB::raw('sum(received_quantity) received_quantity'))
                ->whereNull('deleted_at')
                ->get();
            return $data->sum('received_quantity');
        }
        public function totalPurchaseQuantity()
        {
            $data =  PurchaseDetail::where('purchase_final_id',$this->id)
                    ->select(DB::raw('sum(quantity) quantity'))
                    ->whereNull('deleted_at')
                    ->get();
            return $data->sum('quantity');
        }
    /*********** Receive Purchase Product************/


    /***********Payment history************/
        public function payments()
        {
            return $this->hasMany(AccountPaymentHistory::class,'module_invoice_id','id')
            ->where('module_id',module_HH()['purchase'])
            ->whereNull('deleted_at')
            ->latest();
        }
    /*********** Payment history************/



        public function details(){
            return $this->hasMany('App\Model\Backend\Purchase\PurchaseDetail', 'purchase_final_id');
        }

        public function note(){
            return $this->hasOne('App\Model\Backend\Purchase\PurchaseFinalAdditionalNote', 'purchase_final_id','id');
        }

        public function shipping(){
            return $this->hasOne('App\Model\Backend\Purchase\PurchaseShippingAddress', 'purchase_final_id','id');
        }





    /*
    |--------------------------------------------------------------------------------
    | Previous Due Bill
    |--------------------------------------------------------------------------------
    */
        /**Total Sale Amount*/
        public function previousDueAmount()
        {
            return  number_format(($this->previous_due),2,'.','');
        }
        /**Total Paid Amount*/
        public function previousDueBillPaidAmount()
        {
            $data = AccountPaymentHistory::whereNull('deleted_at')
                        //'deleted_at','payment_type_id','payment_amount','module_id','client_supplier_id',
                        ->select(
                        DB::raw('SUM(CASE
                        WHEN payment_type_id = 1
                            THEN payment_amount
                        END) as income'),
                        DB::raw('SUM(CASE
                        WHEN payment_type_id = 2
                            THEN payment_amount
                        END) as expense')
                        )
                        ->where('module_id',module_HH()['purchase previous bill'])//module_HH()['purchase previous bill']
                        ->where('client_supplier_id',$this->id)
                        ->get();
            $totalIncome    = $data->sum('income');
            $totalExpenese  = $data->sum('expense');
            return number_format($totalExpenese - $totalIncome,2,'.','') ;
        }
        /**Total Previous Due Amount*/
        public function totalPreviousDueAmount()
        {
            return  number_format(($this->previousDueAmount() - $this->previousDueBillPaidAmount()),2,'.','');
        }
        /**Total Previous Due Amount */
    /*
    |--------------------------------------------------------------------------------
    | Previous Due Bill
    |--------------------------------------------------------------------------------
    */






     /***********************************************************************/
     public function totalOrderInvoice()
     {
         return PurchaseFinal::whereNull('deleted_at')
                         ->where('supplier_id',$this->id)
                         ->count();
     }

     public function totalOrderQuantity()
     {
         return PurchaseDetail::whereNull('deleted_at')
                         ->where('supplier_id',$this->id)
                         ->count();
     }

        /***********Payment history************/
         public function paymentAmount()
         {

            $data = AccountPaymentHistory::whereNull('deleted_at')
                        //'deleted_at','payment_type_id','payment_amount','module_id','client_supplier_id',
                        ->select(
                        DB::raw('SUM(CASE
                        WHEN payment_type_id = 1
                            THEN payment_amount
                        END) as income'),
                        DB::raw('SUM(CASE
                        WHEN payment_type_id = 2
                            THEN payment_amount
                        END) as expense')
                        )
                        ->where('module_id',module_HH()['purchase'])
                        ->where('client_supplier_id',$this->id)
                        ->get();
            $totalIncome    = $data->sum('income');
            $totalExpenese  = $data->sum('expense');
            return number_format($totalExpenese - $totalIncome,2,'.','') ;
         }
     /*********** Payment history************/
 
    public function totalPurchaseFinals()
    {
        return $this->hasMany(PurchaseFinal::class,'supplier_id','id')->whereNull('deleted_at');
    }
    public function totalPurchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class,'supplier_id','id')->whereNull('deleted_at');
    }
 

}
