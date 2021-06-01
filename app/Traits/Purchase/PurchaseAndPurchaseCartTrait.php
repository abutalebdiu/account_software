<?php

    namespace App\Traits\Purchase;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Validator;
    use Illuminate\Support\Facades\Auth;
    use App\Model\Backend\Stock\Stock;
    use App\Model\Backend\Stock\MainStock;
    use App\Model\Backend\Stock\PrimaryStock;
    use App\Model\Backend\Stock\SecondaryStock;
    use App\Model\Backend\Unit\Unit;
    use App\Model\Backend\Product\ProductVariation;

    use App\Model\Backend\Purchase\PurchaseDetail;
/**
 *
 */
trait PurchaseAndPurchaseCartTrait
{

    protected $product_variation_id;
    protected $quantity;
    protected $stock_id;

    private $totalIncrementableQuantity;

    protected $stock_type_id;
    protected $product_id;
    protected $defaultPurchaseUnitId;
    protected $receivedQuantity;

    protected $purchase_final_id;

    public function decrementPurchaseQuantityFromPurchaseDetails()
    {
        $sold = PurchaseDetail::where('purchase_final_id',$this->purchase_final_id)
                        ->where('product_variation_id',$this->product_variation_id)
                        ->where('product_id',$this->product_id)
                        ->whereNull('deleted_at')
                        ->first();
        if($sold)
        {
            $sold->quantity                             = ($sold->quantity) - ($this->quantity);
            $sold->purchase_sub_total_inc_tax_amount    = ($sold->purchase_sub_total_inc_tax_amount) - ($this->quantity * $sold->purchase_sub_total_inc_tax_amount);
            $sold->return_quantity                      = ($sold->return_quantity?$sold->return_quantity:0) + ($this->quantity);
            $sold->save();
            if($sold->quantity == 0)
            {
                $sold->discount_value = 0;
                $sold->discount_amount = 0;
                $sold->purchase_sub_total_inc_tax_amount = 0;
                $sold->save();
            }
            return $sold;
        }
    }
}