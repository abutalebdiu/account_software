<?php
    namespace App\Traits\Stock;

    use Illuminate\Http\Request;
    use App\Model\Backend\Sale\SaleFinal;
    use Illuminate\Support\Facades\DB;
    use Validator;
    use Illuminate\Support\Facades\Auth;

    use App\Model\Backend\Stock\Stock;
    use App\Model\Backend\Stock\MainStock;
    use App\Model\Backend\Stock\PrimaryStock;
    use App\Model\Backend\Stock\SecondaryStock;
    use App\Model\Backend\Unit\Unit;
    use App\Model\Backend\Product\ProductVariation;
    use App\Model\Backend\Sale\SaleDetail;
/**
 *
 */
trait IncreDecreMentStockTrait
{

    protected $sale_final_id;
    protected $product_variation_id;
    protected $sale_detail_id;
    protected $quantity;
    protected $sale_unit_id;
    protected $stock_id;

    private $totalIncrementableQuantity;


    protected $stock_type_id;
    protected $product_id;
    protected $defaultPurchaseUnitId;
    protected $receivedQuantity;

    public function incrementStockQuantityToPrimaryStock()
    {
        $calculation_result = unitCalculationResultByUnitId_HH($this->sale_unit_id);
        $this->totalIncrementableQuantity = $calculation_result * $this->quantity;
       
        $stock = PrimaryStock::where('stock_id',$this->stock_id)
                        ->where('product_variation_id',$this->product_variation_id)
                        //->where('product_variation_id',$product_variation_id)
                        ->whereNull('deleted_at')
                        ->first();
        if($stock)
        {
            $stock->available_stock = ($stock->available_stock) + ($this->totalIncrementableQuantity);
            $stock->used_stock      = ($stock->used_stock?$stock->used_stock:0) - ($this->totalIncrementableQuantity);
            $stock->save();
        }

        $this->incrementStockQuantityToMainStock();
        return $stock;
    }

    /*addition with main stock*/
    public function incrementStockQuantityToMainStock()
    {
        $mstock  =  MainStock::where('product_variation_id',$this->product_variation_id)
                //->where('business_location_id',$business_location_id)
                //->where('stock_id',$stock_id)
                //->where('company_id',$company_id)
                ->whereNull('deleted_at')
                ->first();
        if($mstock)
        {
            $mstock->available_stock = ($mstock->available_stock) + ($this->totalIncrementableQuantity);
            $mstock->used_stock      = ($mstock->used_stock?$mstock->used_stock:0) - ($this->totalIncrementableQuantity);
            $mstock->save();
        }  
    }
    /*addition with main stock*/


    /**when return product from return sale */
    public function decrementStoctFromSaleDetails()
    {
        $sold = SaleDetail::where('sale_final_id',$this->sale_final_id)
                        ->where('product_variation_id',$this->product_variation_id)
                        ->where('id',$this->sale_detail_id)
                        ->whereNull('deleted_at')
                        ->first();
        if($sold)
        {
            $sold->quantity          = ($sold->quantity) - ($this->quantity);

            $sold->sub_total         = ($sold->sub_total) - ($this->quantity * $sold->unit_price);
            $sold->return_quantity   = ($sold->return_quantity?$sold->return_quantity:0) + ($this->quantity);
            $sold->save();
            if($sold->quantity == 0)
            {
                $sold->discount_value = 0;
                $sold->discount_amount = 0;
                $sold->sub_total = 0;
                $sold->save();
            }
            return $sold;
        }
    } 


    /*
    |-----------------------------------------------------------------------------------------
    | Decrement Stock from  differents stock [about purchase] 
    |-----------------------------------------------------------------
    */
        /** purchase when delete,edit,return */
        public function decrementStockFromDifferentsStockWhenActionWithPurchaseDetails()
        {
            if($this->stock_type_id == 2)// primary stock
            {
                $this->decrementStockFromPrimaryStockWhenPurchase();
            }
            else if($this->stock_type_id == 3)// secondary stock
            {
                $this->decrementStockFromSecondaryStockWhenPurchase();
            } 
        }

        /**decrement stock from Primary stock */
        public function decrementStockFromPrimaryStockWhenPurchase()
        {
            $unitCalResult  = unitCalculationResultByUnitId_HH($this->defaultPurchaseUnitId);
            $business_location_id = 1;
            $totalNewQty    = $this->receivedQuantity * $unitCalResult;
            $data = PrimaryStock::where('business_location_id',$business_location_id)
                    ->where('stock_id',$this->stock_id)
                    ->where('product_variation_id',$this->product_variation_id)
                    ->where('product_id',$this->product_id)
                    ->whereNull('deleted_at')
                    ->first();
            if($data)
            {
                $data->available_stock = $data->available_stock - ($totalNewQty);
                $data->save();
            }
            $this->decrementStockFromMainStockWhenPurchase();
            return $data;
        }
        /**decrement stock from Primary stock */

        /**decrement stock from secondary stock */
        public function decrementStockFromSecondaryStockWhenPurchase()
        {
            $unitCalResult  = unitCalculationResultByUnitId_HH($this->defaultPurchaseUnitId);
            $business_location_id = 1;
            $totalNewQty    = $this->receivedQuantity * $unitCalResult;
            $data = SecondaryStock::where('business_location_id',$business_location_id)
                    ->where('stock_id',$this->stock_id)
                    ->where('product_variation_id',$this->product_variation_id)
                    ->where('product_id',$this->product_id)
                    ->whereNull('deleted_at')
                    ->first();
            if($data)
            {
                $data->available_stock = $data->available_stock - ($totalNewQty);
                $data->save();
            }
            $this->decrementStockFromMainStockWhenPurchase();
            return $data;
        }
        /**decrement stock from secondary stock */

        /**decrement stock from Primary stock */
        public function decrementStockFromMainStockWhenPurchase()
        {
            $unitCalResult  = unitCalculationResultByUnitId_HH($this->defaultPurchaseUnitId);
            $business_location_id = 1;
            $totalNewQty    = $this->receivedQuantity * $unitCalResult;
            $main_stock_id = 1;
            $data = MainStock::where('business_location_id',$business_location_id)
                    ->where('stock_id',$main_stock_id)
                    ->where('product_variation_id',$this->product_variation_id)
                    ->where('product_id',$this->product_id)
                    ->whereNull('deleted_at')
                    ->first();
            if($data)
            {
                $data->available_stock = $data->available_stock - ($totalNewQty);
                $data->save();
            }
            return $data;
        }
        /**decrement stock from Primary stock */
    /*
    |----------------------------------------------------------------
    | Decrement Stock from  differents stock [about purchase] End
    |------------------------------------------------------------------------------------------
    */



    /*
    |----------------------------------------------------------------
    | subtractionProductQuantity  [available_stock]
    |-----------------------------------------------------------------
    */
       /*  function subtractionStockQuantity_HH($product_variation_id,$stock_id,$sale_unit_id,$quantity)
        {
            $calculation_result = unitCalculationResultByUnitId_HH($sale_unit_id);
            $total_sale_quantity = $calculation_result * $quantity;
            // always quantity subtractions from primary stock table
            $stock = PrimaryStock::where('stock_id',$stock_id)
                            ->where('product_variation_id',$product_variation_id)
                            //->where('product_variation_id',$product_variation_id)
                            ->whereNull('deleted_at')
                            ->first();
            if($stock)
            {
                $stock->available_stock = ($stock->available_stock) - ($total_sale_quantity);
                $stock->used_stock      = ($stock->used_stock?$stock->used_stock:0) + ($total_sale_quantity);
                $stock->save();
            }

                //subtraction from main stock
                $mstock  =  MainStock::where('product_variation_id',$product_variation_id)
                    //->where('business_location_id',$business_location_id)
                    //->where('stock_id',$stock_id)
                    //->where('company_id',$company_id)
                    ->whereNull('deleted_at')
                    ->first();
                if($mstock)
                {
                    $mstock->available_stock = ($mstock->available_stock) - ($total_sale_quantity);
                    $mstock->used_stock      = ($mstock->used_stock?$mstock->used_stock:0) + ($total_sale_quantity);
                    $mstock->save();
                }
                //subtraction from main stock//
            return $stock;
        } */
    /*
    |----------------------------------------------------------------
    | subtractionProductQuantity  [available_stock]
    |-----------------------------------------------------------------
    */




    //disrement stock from purchase details table...when sale [Manage purchase invoice / reference no] 
    //increment stock to purchase details table...when sale return and [Manage purchase invoice / reference no] 



}
