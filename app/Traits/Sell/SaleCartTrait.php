<?php
    namespace App\Traits\Sell;

    use Illuminate\Http\Request;
    use App\Model\Backend\Sale\SaleFinal;
    use App\Model\Backend\Sale\SaleDetail;
    use Illuminate\Support\Facades\DB;
    use Validator;
    use Illuminate\Support\Facades\Auth;
    use App\Model\Backend\Product\ProductVariation;

    use App\Model\Backend\Unit\Unit;
    use App\Model\Backend\Stock\PrimaryStock;
    use App\Model\Backend\Stock\Stock;
/**
 *
 */
trait SaleCartTrait
{

    protected $cartName;
    protected $product_var_id;
    protected $saleDetails;
    protected $singleCartId;

    protected $productVariations;

    protected $changeType;
    protected $available_status;

    protected $discountType;
    protected $discountValue;
    protected $discountAmount;
    protected $saleUnitPrice;
    protected $sale_unit_price;
    protected $sale_quantity;
    protected $sale_return_quantity;

    protected $quantity;

    protected $identityNumber;
    protected $sale_from_stock_id;
    protected $sale_type_id;
    protected $sale_unit_id;
    protected $purchase_price;
    protected $sub_total;
    protected $selling_unit_name;


    public function cartInsertUpdateWhenReturnOrEditSale()
    {
        $cartName = [];
        $cartName           = session()->has($this->cartName) ? session()->get($this->cartName)  : [];

        $this->discountType     = $this->saleDetails->discount_type;
        $this->discountValue    = $this->saleDetails->discount_value;
        //$this->discountAmount   = $this->$saleDetails->discount_amount;

        $this->sale_unit_price  = $this->saleDetails->unit_price;
        $this->purchase_price   = $this->saleDetails->purchase_price;
        $this->sale_quantity    = $this->saleDetails->quantity;
        $this->sale_return_quantity = $this->saleDetails->return_quantity?$this->saleDetails->return_quantity:0;

        //$this->saleUnitPrice    = $this->netUnitSalePriceWithOutDiscount();

        $size           = $this->saleDetails->productVariations->sizes?$this->saleDetails->productVariations->sizes->name:NULL;
        $color          = $this->saleDetails->productVariations->colors?$this->saleDetails->productVariations->colors->name:NULL;
        $weight         = $this->saleDetails->productVariations->weights?$this->saleDetails->productVariations->weights->name:NULL;
        $productName    = $this->saleDetails->products->name ." ".  $size ." ". $color ." ". $weight;

        if(array_key_exists($this->product_var_id,$cartName))
            {
                //$cartName[$this->saleDetails->id]['sale_price']           = number_format($sale_price,2,'.', '');
                //$cartName[$this->saleDetails->id]['quantity']             = $quantity;
            }
        else{
            $cartName[$this->product_var_id] = [
                'productVari_id'            => $this->saleDetails->product_variation_id,
                'product_id'                => $this->saleDetails->product_id,
                'name'                      => $productName,
                'sale_price'                => number_format($this->sale_unit_price,2,'.', ''),
                'purchase_price'            => number_format($this->purchase_price,2,'.', ''),
                'discountType'              => $this->saleDetails->discount_type,
                'discountValue'             => $this->saleDetails->discount_value,
                'discountAmount'            => $this->saleDetails->discount_amount,
                'sub_total'                 => number_format((($this->sale_quantity * $this->sale_unit_price) - $this->discountAmount()),2,'.',''),
                'quantity'                  => $this->sale_quantity,
                'sale_unit_id'              => $this->saleDetails->sale_unit_id,
                'sale_from_stock_id'        => $this->saleDetails->sale_from_stock_id,
                'selling_unit_name'         => $this->saleDetails->units?$this->saleDetails->units->short_name:NULL,
                'sale_type_id'              => $this->saleDetails->sale_type_id,
                'identityNumber'            => $this->saleDetails->saleWarrantyGrarantees?$this->saleDetails->saleWarrantyGrarantees->identity_number:NULL,
            ];
        }
        session([$this->cartName => $cartName]);
        return true;
    }


    private function discountAmount()
    {
        $distAmount = 0;
        if($this->discountType == 'percentage')
        {
            $distAmount = number_format((($this->sale_unit_price * ($this->sale_quantity) * $this->discountValue) / 100),2,'.','');
        }else{
            $distAmount = $this->discountValue;
        }
        return  number_format(($distAmount),2,'.','');
    }


    private function netUnitSalePriceWithOutDiscount()
    {
        $disAmount = 0;
        if($this->discountType == 'percentage')
        {
            $disAmount = number_format((($this->sale_unit_price * ($this->sale_quantity + $this->sale_return_quantity) * $this->discountValue) / 100),2,'.','');
        }else{
            $disAmount = $this->discountValue;
        }
        $singleDiscount = ($disAmount / ($this->sale_quantity + $this->sale_return_quantity));
       return  number_format((($this->sale_unit_price) - $singleDiscount),2,'.','');
    }



    /*Remove Single Data From  Cart Working Properly*/
    public function removeSingleDataFromCart()
    {
        $cartName           = session()->has($this->cartName) ? session()->get($this->cartName)  : [];
		unset($cartName[$this->product_var_id]);
        session([$this->cartName => $cartName]);
        return true;
    }

    /*Remove All Data From Cart Working Properly*/
    public function removeAllDataFromSaleEditCreateCart()
    {
        session([$this->cartName => []]);
        return true;
    }




    /*When changing quantity*/
    public function whenChangingQuantityFromCartList()
    {   
        $cartName               =   session()->has($this->cartName) ? session()->get($this->cartName)  : [];

        if(array_key_exists($this->product_var_id,$cartName))
        {
            $this->available_status   = NULL;
            if($this->changeType == 'minus')
            {
                if((double) $cartName[$this->product_var_id]['quantity'] ==  1)
                {
                    $this->quantity = 1;
                }
                else if((double) $cartName[$this->product_var_id]['quantity'] > 1)
                {
                    $this->quantity =  $cartName[$this->product_var_id]['quantity'] - 1;
                }
            }
            else if($this->changeType == 'plus')
            {
                $stock_id = $cartName[$this->product_var_id]['sale_from_stock_id'];
                $business_location_id   = 1;
                $avlQty                 = checkPrimaryStockQtyByPVIDWithoutProductId_HH($stock_id,$business_location_id,$cartName[$this->saleDetails]['productVari_id']);
                $availAbleQty           = $avlQty?$avlQty->available_stock :0;

                $availableStock = availableStock_HH($cartName[$this->product_var_id]['sale_unit_id'],$availAbleQty);
                $this->available_status   = 'not_available';
                if($availableStock > $cartName[$this->product_var_id]['quantity'])
                {
                    $this->quantity     = $cartName[$this->product_var_id]['quantity'] + 1;
                    $availableStock     = $availableStock - $this->quantity;
                    $this->available_status   = 'available';
                }else{
                    $this->quantity     = $cartName[$this->product_var_id]['quantity'];
                }
            }

            if($cartName[$this->product_var_id]['discountType'] == "percentage" && $cartName[$this->product_var_id]['discountValue'])
            {
                $totalDiscountAmount =  ($this->quantity *  $cartName[$this->product_var_id]['sale_price']) * ($cartName[$this->product_var_id]['discountValue']) /100;
            }
            else if($cartName[$this->product_var_id]['discountType'] == "fixed" && $cartName[$this->product_var_id]['discountValue'])
            {
                $totalDiscountAmount =  $cartName[$this->product_var_id]['discountValue'] ;
            }
            else{
                $totalDiscountAmount = 0 ;
            }
            $cartName[$this->product_var_id]['quantity']    =  $this->quantity;
            $cartName[$this->product_var_id]['sub_total']   =  number_format(($this->quantity *  $cartName[$this->product_var_id]['sale_price']) - $totalDiscountAmount,2,'.', '');
        }
        session([$this->cartName => $cartName]);   
    } /*When changing quantity*/

        

    // Edit Cart
    public function saleEditShowModalWhenWantToEditCartModal()
    {
        $data['product']        = ProductVariation::find($this->product_var_id);
                $base_unit_id   = $data['product']->defaultSaleUnits?$data['product']->defaultSaleUnits->base_unit_id:NULL;
        $data['sale_units']     = Unit::where('base_unit_id',$base_unit_id)->whereNull('deleted_at')->latest()->get();
        $data['stocks']         = Stock::where('business_location_id',1)->where('stock_type_id',2)->get();
        $data['primary_stocks'] = PrimaryStock::where('business_location_id',1)
                                                ->where('product_variation_id',$this->product_var_id)
                                                ->get();

        /*----====----Offer system-------====------*/
        $applicable_offer       = $data['product']->applicable_for_offer_promo_code;
        $promo_code_end_time    = $data['product']->promo_code_end_time;
        $promo_code_less_amount = $data['product']->offer_promo_code_less_amount?$data['product']->offer_promo_code_less_amount:0;
        $offer_promo_code       = $data['product']->offer_promo_code;
        $offer_promo_code       = NULL;

        $promo_offer_from   =  strtotime('2021-02-15 12:20');
        $promo_offer_to     =  strtotime('2021-02-20 12:20');
        $compareDate        =  strtotime(date('Y-m-d h:i:s'));
        $applicable_offer = 1; //overwright
        $offer_activate = 0;
        if($promo_offer_from <= $compareDate && $promo_offer_to >= $compareDate && $applicable_offer)
        {
            $offer_activate = 1;
        }else{
            $offer_activate = 0;
        }
        $data['promo_offer_code'] = $offer_promo_code;
        $data['promo_offer_activate_status'] = $applicable_offer;
        $data['promo_offer_price'] = $data['product']->default_selling_price - $promo_code_less_amount;
        /*----====----Offer system-------====------*/

        $cartName = [];
        $cartName               =   session()->has($this->cartName) ? session()->get($this->cartName)  : [];
        $productVari            =   $data['product'];

        if(array_key_exists($this->product_var_id,$cartName))
        {
            $data['productVari_id']     =  $cartName[$this->product_var_id]['productVari_id']  ;
            $data['product_id']         =  $cartName[$this->product_var_id]['product_id']  ;
            $data['name']               =  $cartName[$this->product_var_id]['name']  ;

            $data['sale_price']         =  $cartName[$this->product_var_id]['sale_price']  ;
            $data['purchase_price']     =  $cartName[$this->product_var_id]['purchase_price']  ;
            $data['discountType']       =  $cartName[$this->product_var_id]['discountType'] ;
            $data['discountValue']      =  $cartName[$this->product_var_id]['discountValue'] ;
            $data['quantity']           =  $cartName[$this->product_var_id]['quantity']      ; 
            $data['netTotalAmount']     =  $cartName[$this->product_var_id]['sub_total'] ;
            $data['identityNumber']     =  $cartName[$this->product_var_id]['identityNumber'] ;

            $data['sale_type_id']       =  $cartName[$this->product_var_id]['sale_type_id'];         
            $data['sale_from_stock_id'] =  $cartName[$this->product_var_id]['sale_from_stock_id'];
            $data['sale_unit_id']       =  $cartName[$this->product_var_id]['sale_unit_id']   ;     
            $data['selling_unit_name']  =  $cartName[$this->product_var_id]['selling_unit_name'];
        }   
        return $data;
    }


    //update cart
    public function updateSaleCartWhenUpdatingFromEditModalOfSaleEdit()
    {
        $cartName = [];
        $cartName           = session()->has($this->cartName) ? session()->get($this->cartName)  : [];
        
        if(array_key_exists($this->product_var_id,$cartName))
        {
            $cartName[$this->product_var_id]['productVari_id']       = $this->product_var_id;
            //$cartName[$this->product_var_id]['product_id']           = ;
            $cartName[$this->product_var_id]['sale_price']           = number_format($this->sale_unit_price,2,'.', '');
            $cartName[$this->product_var_id]['purchase_price']       = number_format($this->purchase_price,2,'.', '');
            $cartName[$this->product_var_id]['discountType']         = $this->discountType;
            $cartName[$this->product_var_id]['discountValue']        = $this->discountValue;
            $cartName[$this->product_var_id]['quantity']             = $this->quantity;
            $cartName[$this->product_var_id]['sub_total']            = number_format($this->sub_total ,2,'.', '');
            $cartName[$this->product_var_id]['identityNumber']       = $this->identityNumber;

            $cartName[$this->product_var_id]['sale_type_id']         = $this->sale_type_id;
            $cartName[$this->product_var_id]['sale_from_stock_id']   = $this->sale_from_stock_id;
            $cartName[$this->product_var_id]['sale_unit_id']         = $this->sale_unit_id;
            $cartName[$this->product_var_id]['selling_unit_name']    = $this->selling_unit_name;
        }
        else{

        }
        session([$this->cartName => $cartName]);
        
        return true;
    }


    public function inserInToCartWhenSearchSingleProductBySkuBarCodePname()
    {
        $cartName = [];
        $cartName           = session()->has($this->cartName) ? session()->get($this->cartName)  : [];

        $this->sale_quantity    = $this->quantity;

        //$this->saleUnitPrice    = $this->netUnitSalePriceWithOutDiscount();

        $size           = $this->productVariations->sizes?$this->productVariations->sizes->name:NULL;
        $color          = $this->productVariations->colors?$this->productVariations->colors->name:NULL;
        $weight         = $this->productVariations->weights?$this->productVariations->weights->name:NULL;
        $productName    = $this->productVariations->products->name ." ".  $size ." ". $color ." ". $weight;

        if(array_key_exists($this->product_var_id,$cartName))
            {
                //$cartName[$this->saleDetails->id]['sale_price']           = number_format($sale_price,2,'.', '');
                //$cartName[$this->saleDetails->id]['quantity']             = $quantity;
            }
        else{
            $cartName[$this->product_var_id] = [
                'productVari_id'            => $this->product_var_id,
                'product_id'                => $this->productVariations->product_id,
                'name'                      => $productName,
                'sale_price'                => number_format($this->sale_unit_price,2,'.', ''),
                'purchase_price'            => number_format($this->purchase_price,2,'.', ''),
                'discountType'              => $this->discountType,
                'discountValue'             => $this->discountValue,
                'discountAmount'            => $this->discount_amount,
                'sub_total'                 => number_format((($this->sale_quantity * $this->sale_unit_price)),2,'.',''),
                'quantity'                  => $this->sale_quantity,
                'sale_unit_id'              => $this->sale_unit_id,
                'sale_from_stock_id'        => $this->sale_from_stock_id,
                'selling_unit_name'         => $this->selling_unit_name,
                'sale_type_id'              => $this->sale_type_id,
                'identityNumber'            => $this->identityNumber,
            ];
        }
        session([$this->cartName => $cartName]);
        return true;
    }


    //sale creating time add to cart 
    public function inserInToCartWhenSearchSingleProductBySkuBarCodePnameDuringSaleCreate()
    { 
        $cartName = [];
        $cartName           = session()->has($this->cartName) ? session()->get($this->cartName)  : [];

        $this->sale_quantity    = $this->quantity;

        //$this->saleUnitPrice    = $this->netUnitSalePriceWithOutDiscount();

        $size           = $this->productVariations->sizes?$this->productVariations->sizes->name:NULL;
        $color          = $this->productVariations->colors?$this->productVariations->colors->name:NULL;
        $weight         = $this->productVariations->weights?$this->productVariations->weights->name:NULL;
        $productName    = $this->productVariations->products->name ." ".  $size ." ". $color ." ". $weight;

        if(array_key_exists($this->product_var_id,$cartName))
            {
                //$cartName[$this->saleDetails->id]['sale_price']           = number_format($sale_price,2,'.', '');
                //$cartName[$this->saleDetails->id]['quantity']             = $quantity;
            }
        else{
            $cartName[$this->product_var_id] = [
                'productVari_id'            => $this->product_var_id,
                'name'                      => $productName,
                'sale_price'                => number_format($this->sale_unit_price,2,'.', ''),
                'purchase_price'            => number_format($this->purchase_price,2,'.', ''),
                'discountType'              => $this->discountType,
                'discountValue'             => $this->discountValue,
                'netTotalAmount'                 => number_format((($this->sale_quantity * $this->sale_unit_price)),2,'.',''),
                'quantity'                  => $this->sale_quantity,
                'sale_unit_id'              => $this->sale_unit_id,
                'sale_from_stock_id'        => $this->sale_from_stock_id,
                'selling_unit_name'         => $this->selling_unit_name,
                'sale_type_id'              => $this->sale_type_id,
                'identityNumber'            => $this->identityNumber,
            ];
        }
        session([$this->cartName => $cartName]);
        return true;
    }


}
