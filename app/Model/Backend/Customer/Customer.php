<?php

namespace App\Model\Backend\Customer;

use Illuminate\Database\Eloquent\Model;
use App\Model\Backend\Sale\SaleDetail;
use App\Model\Backend\Sale\SaleFinal;

use App\Model\Backend\Sale\SaleReturnFinal;
use App\Model\Backend\Sale\SaleReturnDetail;
use DB;
use App\User;

use App\Model\Backend\Payment\AccountPaymentHistory;
use App\Model\Backend\Payment\AccountPaymentHistoryDetail;


class Customer extends Model
{
    public function totalSellInvoiceAmount()
    {
        return SaleFinal::whereNull('deleted_at')
                    ->where('customer_id',$this->id)
                    ->get();
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
            //'quantity','unit_price','customer_id','deleted_at',
            $data =   SaleDetail::select(
                                            DB::raw('sum(quantity*unit_price) as subTotalAmount')
                                        )
                                    //->where('sale_final_id',$this->id)
                                    ->where('customer_id',$this->id)
                                    ->whereNull('deleted_at')
                                    ->get();
            return number_format($data->sum('subTotalAmount'),2,'.','');
        }
        /*get sub total from sale_details table*/

        /*get sub discount from sale_details table*/
        public function discountAmounts()
        {
            // 'quantity','discount_type','percentage','discount_value','','fixed','deleted_at','','customer_id',
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
                    //->where('sale_final_id',$this->id)
                    ->where('customer_id',$this->id)
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


        public function additionalShippingCharges()
        {
            $ads =  SaleFinal::whereNull('deleted_at')
                ->where('customer_id',$this->id)
                ->get();
            return number_format($ads->sum('shipping_cost'),2,'.','');
        }

        public function additionalOthersCharges()
        {
            $data =  SaleFinal::whereNull('deleted_at')
            ->where('customer_id',$this->id)
            ->get();
            return number_format($data->sum('others_cost'),2,'.','');
        }


        public function discountAmountOfSaleFinal()
        {
            //'sale_finals.id','sale_finals.discount_type','','sale_finals.discount_value','sale_finals.percentageValue','sale_finals.fixedValue','sale_finals.deleted_at','sale_finals.customer_id',
            //'sale_details.quantity','sale_details.unit_price','sale_details.deleted_at','sale_details.customer_id','sale_details.id','sale_details.sale_final_id',
            $data =   SaleFinal::join('sale_details','sale_details.sale_final_id','=','sale_finals.id')
                ->select(
                DB::raw('SUM(CASE
                WHEN  sale_finals.discount_type = "percentageValue"
                    THEN sale_finals.discount_value *  (sale_details.quantity * sale_details.unit_price) / 100
                WHEN sale_finals.discount_type = "fixedValue"
                    THEN sale_finals.discount_value
                END) as subTotaldiscountAmount'),
                DB::raw('sum(sale_details.quantity*sale_details.unit_price) as subTotalAmount')
                )
                ->whereNull('sale_finals.deleted_at')
                ->whereNull('sale_details.deleted_at')
                ->where('sale_finals.customer_id',$this->id)
                ->where('sale_details.customer_id',$this->id)
                ->get();
            return number_format($data->sum('subTotaldiscountAmount'),2,'.','');
            return number_format($data->sum('subTotalAmount'),2,'.',''); //this is perfect working
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
                        ->where('module_id',module_HH()['sale'])
                        ->where('client_supplier_id',$this->id)
                        //->where('module_invoice_id',$this->id)
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

        public function totalOrderInvoice()
        {
            return SaleFinal::whereNull('deleted_at')
                            ->where('customer_id',$this->id)
                            //->where('sale_final_id',$this->id)
                            ->count();
        }

        public function totalOrderQuantity()
        {
            return SaleDetail::whereNull('deleted_at')
                            ->where('customer_id',$this->id)
                            //->where('sale_final_id',$this->id)
                            ->count();
        }

        public function totalReturnQuantity()
        {
            return SaleReturnDetail::whereNull('deleted_at')
                            ->where('customer_id',$this->id)
                            //->where('sale_final_id',$this->id)
                            ->sum('return_quantity');
        }


        public function saleProductQuantity()
        {
            return $sale = SaleDetail::whereNull('deleted_at')
                        ->select(DB::raw('sum(quantity) as quantity'))
                        //->where('sale_final_id',$this->id)
                        ->where('customer_id',$this->id)
                        ->sum('quantity');
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
                            ->where('module_id',module_HH()['sale previous bill'])
                            ->where('client_supplier_id',$this->id)
                            ->get();
                $totalIncome    = $data->sum('income');
                $totalExpenese  = $data->sum('expense');
                return number_format($totalIncome - $totalExpenese,2,'.','') ;
                //cdf_HH()['credit'];
                //payment_type_HH()['income'];

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
            ->where('module_id',module_HH()['sale'])
            ->where('client_supplier_id',$this->id)
            //->where('module_invoice_id',$this->id)
            ->get();
            $totalIncome    = $data->sum('income');
            $totalExpenese  =  $data->sum('expense');
            return number_format($totalIncome - $totalExpenese,2,'.','') ;
        }
        /*********** Payment history************/    
        public function totalSaleFinals()
        {
            return $this->hasMany(SaleFinal::class,'customer_id','id')->whereNull('deleted_at');
        }
        public function totalSaleDetails()
        {
            return $this->hasMany(SaleDetail::class,'customer_id','id')->whereNull('deleted_at');
        }


}
