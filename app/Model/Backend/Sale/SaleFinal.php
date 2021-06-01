<?php

namespace App\Model\Backend\Sale;

use Illuminate\Database\Eloquent\Model;
use App\Model\Backend\Sale\SaleDetail;
use App\Model\Backend\Quotation\QuotationInvoice;
use App\Model\Backend\Sale\SaleReturnFinal;
use App\Model\Backend\Sale\SaleReturnDetail;
use App\Model\Backend\Customer\Customer;
use DB;
use App\User;

use App\Model\Backend\Payment\AccountPaymentHistory;
use App\Model\Backend\Payment\AccountPaymentHistoryDetail;

use App\Backend\Reference;
class SaleFinal extends Model
{
    public function customers()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }


    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class,'sale_final_id','id')->where('invoice_status',1)->whereNull('deleted_at');
    }



    public function saleReturnFinals()
    {
        return $this->hasMany(SaleReturnFinal::class,'sale_final_id','id')->whereNull('deleted_at');
    }
    public function saleReturnDetails()
    {
        return $this->hasMany(SaleReturnDetail::class,'sale_final_id','id')->whereNull('deleted_at');
    }

    

    public function totalSaleItems()
    {
        return $this->hasMany(SaleDetail::class,'sale_final_id','id')->where('invoice_status',1)->whereNull('deleted_at')->count();
    }


    
        /*
        |--------------------------------------------------------------
        | Total and sub total with discount , tax, shipping
        |----------------------------------------------------------
        */
            /*************************************** */
            /*get sub total from sale_details table*/
            public function subTotalAmountFromSaleDetail()
            {
                $data =   SaleDetail::select(DB::raw('sum(quantity*unit_price) as sub_total'))
                                        ->where('sale_final_id',$this->id)
                                        ->where('invoice_status',1)
                                        ->whereNull('deleted_at')
                                        ->get();
                return number_format($data->sum('sub_total'),2,'.','');
            }
            /*get sub total from sale_details table*/

            /*get sub discount from sale_details table*/
            public function discountAmounts()
            {
                $data =   SaleDetail::select(
                     DB::raw('SUM(CASE 
                        WHEN quantity > 0 && discount_type = "percentage" 
                            THEN discount_value *  quantity*unit_price / 100
                        WHEN quantity > 0 && discount_type = "fixed" 
                            THEN discount_value 
                        WHEN quantity > 0 && discount_type = "" 
                            THEN discount_value 
                        WHEN quantity > 0 && discount_type = NULL 
                            THEN discount_value 
                        END) as subTotaldiscountAmount')
                        ) 
                        ->whereNull('deleted_at')
                        ->where('invoice_status',1)
                        ->where('sale_final_id',$this->id)
                        ->get();
                
                return number_format($data->sum('subTotaldiscountAmount'),2,'.','');
                    /*
                        DB::raw('SUM(CASE 
                        WHEN 
                            discount_type = "percentage" 
                                    THEN discount_value *  quantity*unit_price / 100
                        WHEN 
                            discount_type = "fixed"
                                THEN discount_value 
                        WHEN 
                            quantity = 0 
                                THEN 2 
                                
                        ELSE 0 END) subTotalDiscountAmount')
                        )

                        DB::raw('SUM(CASE 
                        WHEN quantity > 0 && discount_type = "percentage" 
                            THEN discount_value *  quantity*unit_price / 100
                        WHEN quantity > 0 && discount_type = "fixed" 
                            THEN discount_value 
                        ELSE 
                            discount_value
                        END) as subTotaldiscountAmount')
                    */       
            }
            /*get sub discount from sale_details table*/


            /*get total sub total  from sale_details table*/
            public function subTotalSaleAmount()
            {
                return  number_format(($this->subTotalAmountFromSaleDetail()- $this->discountAmounts()),2,'.','');
            }
            /*get total sub total  from sale_details table*/
            /*************************************** */


            /**All from sale final table  */
            /** Discount , Tax and Shipping cost of Final Sales */
            protected $taxAmt;
            public function taxAmounts()
            {
                $this->taxAmt =  0;
                /* if($this->purchase_tax_applicable)
                {
                    if($this->purchase_tax_applicable ==1)
                    {
                        $this->taxAmt = ($this->purchase_tax_in_parcent_value * ($this->subTotalSaleAmount() - $this->discountAmounts())) / 100;
                    }else{
                        $this->taxAmt = $this->purchase_tax_in_parcent_value;
                    }
                } */
                return number_format($this->taxAmt,2,'.','');
            }

            protected $addinShipChg;
            public function additionalShippingCharges()
            {
                $this->addinShipChg = 0;
                if($this->shipping_cost)
                {
                    $this->addinShipChg = $this->shipping_cost;
                } 
                return number_format($this->addinShipChg,2,'.','');
            }

            protected $otherCost;
            public function additionalOthersCharges()
            {
                $this->otherCost = 0;
                if($this->others_cost)
                {
                    $this->otherCost = $this->others_cost;
                } 
                return number_format($this->otherCost,2,'.','');
            }

            protected $saleFinalDisAmount;
            public function discountAmountOfSaleFinal()
            {
                $this->saleFinalDisAmount =  0;
                if($this->discount_type)
                {
                    if($this->discount_type =="percentageValue")
                    {
                       $this->saleFinalDisAmount =  number_format(($this->discount_value * $this->subTotalSaleAmount() / 100),2,'.','');
                    }else{
                        $this->saleFinalDisAmount = $this->discount_value;
                    }
                }
                return number_format($this->saleFinalDisAmount,2,'.','');
            }
            /** Discount , Tax and Shipping cost of Final Sales */

            /**Total Sale Amount*/
            public function totalSaleAmount()
            {
                return  number_format((($this->subTotalSaleAmount() + $this->taxAmounts() + $this->additionalShippingCharges() + $this->additionalOthersCharges()) - $this->discountAmountOfSaleFinal()),2,'.','');
            }
            /**Total Paid Amount*/
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
                               
                                ->where('module_id',module_HH()['sale'])
                                ->where('module_invoice_id',$this->id)
                                ->get();
                $totalIncome    = $data->sum('income');
                $totalExpenese  =  $data->sum('expense');
                return number_format($totalIncome - $totalExpenese,2,'.','') ;
                //cdf_HH()['credit'];
               //payment_type_HH()['income'];

            }
            /**Total Due Amount*/
            public function totalDueAmount()
            {
                return  number_format(($this->totalSaleAmount() - $this->totalPaidAmount()),2,'.','');
            }
            /**All from sale final table  */
        /*
        |--------------------------------------------------------------
        | Total and sub total with discount , tax, shipping
        |----------------------------------------------------------
        */

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }


    public function totalReturnQuantity()
    {
        return SaleReturnDetail::where('sale_final_id',$this->id)
                        ->whereNull('deleted_at')
                        ->sum('return_quantity');
    }
    
    
    public function saleProductQuantity()
    {
        return $sale = SaleDetail::where('sale_final_id',$this->id)
                    ->select(DB::raw('sum(quantity) as quantity'))
                    ->whereNull('deleted_at')
                    ->where('invoice_status',1)
                    ->sum('quantity');
    }

    /***********Payment history************/
        public function payments()
        {
               return $this->hasMany(AccountPaymentHistory::class,'module_invoice_id','id')
                    ->where('module_id',module_HH()['sale'])
                    ->whereNull('deleted_at')
                    ->latest();
        }
    /*********** Payment history************/





    /**************************************************************************************************** */
                            /******* Quotation*********** */
    /**************************************************************************************************** */
    public function quotationSaleDetails()
    {
        return $this->hasMany(SaleDetail::class,'sale_final_id','id')->where('invoice_status',2)->whereNull('deleted_at');
    }

    

    public function quotationTotalSaleItems()
    {
        return $this->hasMany(SaleDetail::class,'sale_final_id','id')->where('invoice_status',2)->whereNull('deleted_at')->count();
    }

    /*
    |--------------------------------------------------------------
    | Total and sub total with discount , tax, shipping
    |----------------------------------------------------------
    */
        /*************************************** */
        /*get sub total from sale_details table*/
        public function quotationSubTotalAmountFromSaleDetail()
        {
            $data =   SaleDetail::select(DB::raw('sum(quantity*unit_price) as sub_total'))
                                    ->where('sale_final_id',$this->id)
                                    ->where('invoice_status',2)
                                    ->whereNull('deleted_at')
                                    ->get();
            return number_format($data->sum('sub_total'),2,'.','');
        }
        /*get sub total from sale_details table*/

        /*get sub discount from sale_details table*/
        public function quotationDiscountAmounts()
        {
            $data =   SaleDetail::select(
                    DB::raw('SUM(CASE 
                    WHEN quantity > 0 && discount_type = "percentage" 
                        THEN discount_value *  quantity*unit_price / 100
                    WHEN quantity > 0 && discount_type = "fixed" 
                        THEN discount_value 
                    WHEN quantity > 0 && discount_type = "" 
                        THEN discount_value 
                    WHEN quantity > 0 && discount_type = NULL 
                        THEN discount_value 
                    END) as subTotaldiscountAmount')
                    ) 
                    ->whereNull('deleted_at')
                    ->where('invoice_status',2)
                    ->where('sale_final_id',$this->id)
                    ->get();
            return number_format($data->sum('subTotaldiscountAmount'),2,'.','');    
        }
        /*get sub discount from sale_details table*/


        /*get total sub total  from sale_details table*/
        public function quotationSubTotalSaleAmount()
        {
            return  number_format(($this->quotationSubTotalAmountFromSaleDetail()- $this->quotationDiscountAmounts()),2,'.','');
        }
        /*get total sub total  from sale_details table*/
        /*************************************** */


        /**All from sale final table  */
        /** Discount , Tax and Shipping cost of Final Sales */
        protected $qtaxAmt;
        public function quotationTaxAmounts()
        {
            $this->qtaxAmt =  0;
           
            return number_format($this->qtaxAmt,2,'.','');
        }

        protected $qaddinShipChg;
        public function quotationAdditionalShippingCharges()
        {
            $this->qaddinShipChg = 0;
            if($this->shipping_cost)
            {
                $this->qaddinShipChg = $this->shipping_cost;
            } 
            return number_format($this->qaddinShipChg,2,'.','');
        }

        protected $qotherCost;
        public function quotationAdditionalOthersCharges()
        {
            $this->qotherCost = 0;
            if($this->others_cost)
            {
                $this->qotherCost = $this->others_cost;
            } 
            return number_format($this->qotherCost,2,'.','');
        }

        protected $qsaleFinalDisAmount;
        public function quotationDiscountAmountOfSaleFinal()
        {
            $this->qsaleFinalDisAmount =  0;
            if($this->discount_type)
            {
                if($this->discount_type =="percentageValue")
                {
                    $this->qsaleFinalDisAmount =  number_format(($this->discount_value * $this->quotationSubTotalSaleAmount() / 100),2,'.','');
                }else{
                    $this->qsaleFinalDisAmount = $this->discount_value;
                }
            }
            return number_format($this->qsaleFinalDisAmount,2,'.','');
        }
        /** Discount , Tax and Shipping cost of Final Sales */

        /**Total Sale Amount*/
        public function quotationTotalSaleAmount()
        {
            return  number_format((($this->quotationSubTotalSaleAmount() + $this->quotationTaxAmounts() + $this->quotationAdditionalShippingCharges() + $this->quotationAdditionalOthersCharges()) - $this->quotationDiscountAmountOfSaleFinal()),2,'.','');
        }
        /**Total Paid Amount*/
        public function quotationTotalPaidAmount()
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
                            ->where('module_id',module_HH()['sale'])
                            ->where('module_invoice_id',$this->id)
                            ->get();
            $totalIncome    = $data->sum('income');
            $totalExpenese  =  $data->sum('expense');
            return number_format($totalIncome - $totalExpenese,2,'.','') ;
            //cdf_HH()['credit'];
            //payment_type_HH()['income'];

        }
        /**Total Due Amount*/
        public function quotationtotalDueAmount()
        {
            return  number_format(($this->quotationTotalSaleAmount() - $this->quotationTotalPaidAmount()),2,'.','');
        }
        /**All from sale final table  */
    /*
    |--------------------------------------------------------------
    | Total and sub total with discount , tax, shipping
    |----------------------------------------------------------
    */
    public function quotationSaleProductQuantity()
    {
        return $sale = SaleDetail::where('sale_final_id',$this->id)
                    ->select(DB::raw('sum(quantity) as quantity'))
                    ->whereNull('deleted_at')
                    ->where('invoice_status',2)
                    ->sum('quantity');
    }

    
    public function quotationInvoices()
    {
        return $this->hasOne(QuotationInvoice::class,'sale_final_id','id');
    }
    /**************************************************************************************************** */
    

    public function referenceBy()
    {
        return $this->belongsTo(Reference::class,'reference_id','id');
    }



    /**For Profit / Loss */
    /*get total purchase Amount from sale_details table*/
    public function getTotalPurchaseAmountFromSaleDetail()
    {
        $data =   SaleDetail::select(DB::raw('sum(quantity*purchase_price) as sub_total'))
                                ->where('sale_final_id',$this->id)
                                ->where('invoice_status',1)
                                ->whereNull('deleted_at')
                                ->get();
        return number_format($data->sum('sub_total'),2,'.','');
    }
    /*get total purchase Amount from sale_details table*/

    /*get total purchase Amount from sale_details table*/
    public function getQuotationTotalPurchaseAmountFromSaleDetail()
    {
        $data =   SaleDetail::select(DB::raw('sum(quantity*purchase_price) as sub_total'))
                                ->where('sale_final_id',$this->id)
                                ->where('invoice_status',2)
                                ->whereNull('deleted_at')
                                ->get();
        return number_format($data->sum('sub_total'),2,'.','');
    }
    /*get total purchase Amount from sale_details table*/
    /**For Profit / Loss */
}
