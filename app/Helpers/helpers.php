<?php

    use App\Model\Backend\Stock\MainStock;
    use App\Model\Backend\Stock\PrimaryStock;
    use App\Model\Backend\Stock\SecondaryStock;
    use App\Model\Backend\Unit\Unit;
    use App\Model\Backend\Product\ProductVariation;
    use App\Model\Backend\Sale\SaleDetail;
    /*
    |-----------------------------------------------------------------------------------------------------
    | days,months, years converters
    |-----------------------------------------------------------------------------------------------------
    */
        function daysMonthsYearsConverters_HH($types="days", $value = 0)
        {
            if($value > 0)
            {
                date_default_timezone_set("Asia/dhaka"); //
                return  $expireTime = date("Y-m-d h:i:s",strtotime(date("Y-m-d h:i:s")." +" . $value .$types));
            }else{
                return "NULL";
            }
        }
    /*
    |-------------------------------------------------------------------------------------------------------
    | days,months, years converters End
    |-------------------------------------------------------------------------------------------------------
    */



    /*
    |--------------------------------------------------------------------------------
    | Discount calculate , calculate_with = 500, calculate_by = 5, type = "percent";
    | calculate like..... 500*5/100
    |--------------------------------------------------------------------------------
    */
        function discountCalculate_HH($types="fixed",$calculate_with = 0, $calculate_by = 0)
        {
            if($types != "fixed")
            {
                $parcentage = 100;
               return $calculate_with * $calculate_by / $parcentage;
            }else{
                return $calculate_by;
            }
        }
    /*
    |-----------------------------------------------------------------------------------
    | Discount calculate End
    |-----------------------------------------------------------------------------------
    */






    /*
    |------------------------------------------------------------------
    | User Role  Start
    |------------------
    */
        define('userRoleIdSuperAdmin_HH',1);  // Super Admin
        define('userRoleIdAdmin_HH',2); // Admin
        define('userRoleIdSubAdmin_HH',3);  // Sub Admin
        define('userRoleIdMerchant_HH',4);  // Merchant
        define('userRoleIdManpower_HH',5); // Manpower
        define('userRoleIdOfficeStaff_HH',6); // Office Staff
        define('userRoleIdSubOfficeAdmin_HH',7); // Sub Office Admin
        define('userRoleIdHubAdmin_HH',8); // Hub Admin
        define('userRoleIdAgentAdmin_HH',9); // Agent Admin
    /*
    |---------------
    | User Role  End
    |------------------------------------------------------------------
    */


    /*
    |------------------------------------------------------------------
    | User approval status  | user_approval_status_id
    |------------------
    */
        define('userApprovalStatusPending_HH',1);  // Pending
        define('userApprovalStatusVerified_HH',2); // Verified
        define('userApprovalStatusSuspended_HH',3);  // Suspend
    /*
    |---------------
    | User approval status  | user_approval_status_id End
    |------------------------------------------------------------------
    */


    /*
    |------------------------------------------------------------------
    | Redirect URL And Route login After Login   Start
    |------------------
    */
        //Merchant Login Form Route Name
        define('showMerchantLoginFormRoute_HH','showMerchantLoginFormRoute');
        define('showMerchantLoginFormUrl_HH','merchant/login');
        define('merchantLoginFormSubmitRoute_HH','login');

        define('merchantDashboardRoute_HH','merchantDashboardRoute');
        define('merchantDashboardUrl_HH','merchant/dashboard');

        //Manpower Login Form Route Name
        define('showManpowerLoginFormRoute_HH','showManpowerLoginFormRoute');
        define('showManpowerLoginFormUrl_HH','manpower/login');
        define('manpowerDashboardRoute_HH','manpowerDashboardRoute');
        define('manpowerLoginFormSubmitRoute_HH','login');
        define('manpowerDashboardUrl_HH','manpower/dashboard');



        //Admin Login Form Route Name
        define('showOfficialUsersLoginFormRoute_HH','officialUserLoginFormRoute');
        define('showOfficialUsersLoginFormUrl_HH','official/user/login');

        // opt expire time , its not using.. using Helper/setting.php file
        define('merchantLoginOptExpireTime_HH',1); // merchant login expire otp time
        define('merchantLoginOptExpireTimeType_HH','minutes'); // merchant login expire otp time type , minutes, seconds , hour
    /*
    |---------------
    | Redirect URL And Route login After Login   End
    |------------------------------------------------------------------
    */









    /*
    |------------------------------------------------------------------
    | Company and  Business Type , Branch id
    |------------------
    */
        function businessTypeId_HH()
        {
            return 1;
        }

        function companyId_HH()
        {
            return 1;
        }
        function branchId_HH()
        {
            return 1;
        }
    /*
    |---------------
    | Company and Business Type , Branch id End
    |------------------------------------------------------------------
    */

    /*
    |------------------------------------------------------------------
    | Payment Module Name && CDF, Credit , debit formula,Payment_type
    |----------------------------------------------------------------
    */
        function module_HH()
        {
            return [
                'purchase' => 1,
                'sale' => 2,
                'purchase previous bill' => 3,
                'sale previous bill' => 4,
                'loan' => 5,
            ];
        }
        function cdf_HH()
        {
            return [
                'credit' => 1,
                'debit' => 2,
            ];
        }

        function payment_type_HH()
        {
            return [
                'income' => 1,
                'expense' => 2,
            ];
        }

        function getModuleName_HH($serachKey)
        {
           return ucfirst(array_search ($serachKey, module_HH()));
        }

        function getCDFName_HH($serachKey)
        {
           return ucfirst(array_search ($serachKey, cdf_HH()));
        }
    /*
    |------------------------------------------------------------------
    | Payment Module Name && CDF, Credit , debit formula,Payment_type
    |----------------------------------------------------------------
    */

    
    /*
    |------------------------------------------------------------------
    | Card Type
    |----------------------------------------------------------------
    */
        function cardType_HH()
        {
            return [
                1 => [
                    'id' => 1,
                    'name' => "Credit Card"
                ],
                2 => [
                    'id' => 2,
                    'name' => "Debit Card"
                ],
                3 => [
                    'id' => 3,
                    'name' => "Visa Card"
                ],
                4 => [
                    'id' => 4,
                    'name' => "Master Card"
                ],
            ];
        }
    /*
    |------------------------------------------------------------------
    | Card Type
    |----------------------------------------------------------------
    */

    /*
    |------------------------------------------------------------------
    | Month , Year 08.02.2021
    |-----------------------------------------------------------------
    */

        function months_HH()
        {
            return [
                1 => [
                    'id' => 1,
                    'name' => "January"
                ],
                2 => [
                    'id' => 2,
                    'name' => "February"
                ],
                3 => [
                    'id' => 3,
                    'name' => "March"
                ],
                4 => [
                    'id' => 4,
                    'name' => "April"
                ],
                5 => [
                    'id' => 5,
                    'name' => "May"
                ],
                6 => [
                    'id' => 6,
                    'name' => "June"
                ],
                7 => [
                    'id' => 7,
                    'name' => "July"
                ],
                8 => [
                    'id' => 8,
                    'name' => "August"
                ],
                9 => [
                    'id' => 9,
                    'name' => "September"
                ],
                10 => [
                    'id' => 10,
                    'name' => "October"
                ],
                11 => [
                    'id' => 11,
                    'name' => "November"
                ],
                12 => [
                    'id' => 12,
                    'name' => "December"
                ]
            ];
        }

        function years_HH()
        {
            $allYear = [];
            $year = 2021;
            $tillYear = 2051;
            for ($year; $year < $tillYear ; $year++) {
               $allYear[] = $year;
            }
            return $allYear;
        }
    /*
    |----------------------------------------------------------------
    | Month , Year
    |-----------------------------------------------------------------
    */


    /*
    |----------------------------------------------------------------
    | Default Profit Margin from setting
    |-----------------------------------------------------------------
    */
        function defaultProfitMargin_HH()
        {
            return 25;
        }
        function lowQuantityPullProduct_HH()
        { return 10;}

        function addAmountForWholeSaleWithPruchasePriceIncTax_HH()
        {return 10 ;}
    /*
    |----------------------------------------------------------------
    | Default Profit Margin from setting
    |-----------------------------------------------------------------
    */



    /*
    |----------------------------------------------------------------
    | Stock Purchase time   [increase Stock]
    |-----------------------------------------------------------------
    */
        function increasingStockPurchase_HH($stock_type_id,$stock_id,$product_id,$product_variation_id,$purchase_quantity,$business_location_id,$defaultPurchaseUnitI)
        {
            if($stock_type_id == 1)// main stock
            {
                increasingMainStockWhenPurchase_HH($stock_id,$product_id,$product_variation_id,$purchase_quantity,$business_location_id,$defaultPurchaseUnitI);
            }
            else if($stock_type_id == 2)// primary stock
            {
                increasingPrimaryStockWhenPurchase_HH($stock_id,$product_id,$product_variation_id,$purchase_quantity,$business_location_id,$defaultPurchaseUnitI);
            }
            else if($stock_type_id == 3)// secondary stock
            {
                increasingSecondaryStockWhenPurchase_HH($stock_id,$product_id,$product_variation_id,$purchase_quantity,$business_location_id,$defaultPurchaseUnitI);
            }
        }

        function increasingMainStockWhenPurchase_HH($stock_id = 1,$product_id,$product_variation_id,$purchase_quantity,$business_location_id,$defaultPurchaseUnitI)
        {
            $unitCalResult  = unitCalculationResultByUnitId_HH($defaultPurchaseUnitI);
            $prevousQty     = checkPreviousMainStocktQty_HH($stock_id = 1,$business_location_id,$product_variation_id,$product_id);
            $totalNewQty    = $purchase_quantity * $unitCalResult;
            if($prevousQty)
            {
                $prevousQty->available_stock = $prevousQty->available_stock + ($totalNewQty);
                $prevousQty->save();
                return $prevousQty;
            }
            else{
                $data = new MainStock();
                $data->business_location_id = $business_location_id;
                $data->business_type_id = 1;
                //$data->company_id = $pr;
                $data->stock_type_id = 1;
                $data->stock_id = $stock_id;
                $data->product_variation_id = $product_variation_id;
                $data->product_id = $product_id;
                $data->available_stock = ($totalNewQty);
                $data->status = 1;
                $data->save();
                return $data;
            }
        }



        function increasingPrimaryStockWhenPurchase_HH($stock_id,$product_id,$product_variation_id,$purchase_quantity,$business_location_id,$defaultPurchaseUnitI)
        {
            increasingMainStockWhenPurchase_HH(1,$product_id,$product_variation_id,$purchase_quantity,$business_location_id,$defaultPurchaseUnitI);

            $unitCalResult  = unitCalculationResultByUnitId_HH($defaultPurchaseUnitI);
            $prevousQty     = checkPreviousPrimaryStockQty_HH($stock_id,$business_location_id,$product_variation_id,$product_id);
            $totalNewQty    = $purchase_quantity * $unitCalResult;
            if($prevousQty)
            {
                $prevousQty->available_stock = $prevousQty->available_stock + ($totalNewQty);
                $prevousQty->save();
                return $prevousQty;
            }

            $data = new PrimaryStock();
            $data->business_location_id = $business_location_id;
            $data->business_type_id = 1;
            //$data->company_id = $pr;
            $data->stock_type_id = 2;
            $data->stock_id = $stock_id;
            $data->product_variation_id = $product_variation_id;
            $data->product_id = $product_id;
            $data->available_stock = ($totalNewQty);
            $data->status = 1;
            $data->save();
            return $data;
        }

        function increasingSecondaryStockWhenPurchase_HH($stock_id,$product_id,$product_variation_id,$purchase_quantity,$business_location_id,$defaultPurchaseUnitI)
        {
            increasingMainStockWhenPurchase_HH(1,$product_id,$product_variation_id,$purchase_quantity,$business_location_id,$defaultPurchaseUnitI);

            $unitCalResult  = unitCalculationResultByUnitId_HH($defaultPurchaseUnitI);
            $prevousQty     = checkPreviousSecondaryStockQty_HH($stock_id,$business_location_id,$product_variation_id,$product_id);
            $totalNewQty    = $purchase_quantity * $unitCalResult;
            if($prevousQty)
            {
                $prevousQty->available_stock = $prevousQty->available_stock + ($totalNewQty);
                $prevousQty->save();
                return $prevousQty;
            }

            $data = new SecondaryStock();
            $data->business_location_id = $business_location_id;
            $data->business_type_id = 1;
            //$data->company_id = $pr;
            $data->stock_type_id = 3;
            $data->stock_id = $stock_id;
            $data->product_variation_id = $product_variation_id;
            $data->product_id = $product_id;
            $data->available_stock = ($totalNewQty);
            $data->status = 1;
            $data->save();
            return $data;
        }

        function checkPreviousMainStocktQty_HH($stock_id,$business_location_id,$product_variation_id,$product_id)
        {
            return MainStock::where('business_location_id',$business_location_id)
                        ->where('stock_id',$stock_id)
                        ->where('product_variation_id',$product_variation_id)
                        ->where('product_id',$product_id)
                        ->whereNull('deleted_at')
                        ->first();
        }

        function checkPreviousPrimaryStockQty_HH($stock_id,$business_location_id,$product_variation_id,$product_id)
        {
            return PrimaryStock::where('business_location_id',$business_location_id)
                        ->where('stock_id',$stock_id)
                        ->where('product_variation_id',$product_variation_id)
                        ->where('product_id',$product_id)
                        ->whereNull('deleted_at')
                        ->first();
        }
        function checkPreviousSecondaryStockQty_HH($stock_id,$business_location_id,$product_variation_id,$product_id)
        {
            return SecondaryStock::where('business_location_id',$business_location_id)
            ->where('stock_id',$stock_id)
            ->where('product_variation_id',$product_variation_id)
            ->where('product_id',$product_id)
            ->whereNull('deleted_at')
            ->first();
        }

        function updateProductVariationIdByPVID_HH($product_id,$product_variation_id,$purchase_unit_price_before_discount,
            $purchase_unit_price_before_tax,$purchase_unit_price_inc_tax,$unit_selling_price_inc_tax,$unit_selling_price_exc_tax
        )
        {
            $data =  ProductVariation::find($product_variation_id);
            $data->purchase_unit_price_before_discount   = $purchase_unit_price_before_discount;
            $data->purchase_unit_price_before_tax        = $purchase_unit_price_before_tax;
            $data->purchase_unit_price_inc_tax           = $purchase_unit_price_inc_tax;
            $data->unit_selling_price_inc_tax            = $unit_selling_price_inc_tax;
            $data->unit_selling_price_exc_tax            = $unit_selling_price_exc_tax;
            $data->default_purchase_price                = $purchase_unit_price_inc_tax;
            $data->default_selling_price                 = $unit_selling_price_inc_tax;

                $for_whole_sale = ($purchase_unit_price_inc_tax * addAmountForWholeSaleWithPruchasePriceIncTax_HH())/100;

            $data->whole_sale_price                     = $purchase_unit_price_inc_tax + $for_whole_sale;
            $data->save();
            return $data;
        }
    /*
    |----------------------------------------------------------------
    | Purchase time   [increase Stock]
    |-----------------------------------------------------------------
    */

    /*
    |----------------------------------------------------------------
    | Unit Calculation Result By Unit Id [calculation_result]
    |-----------------------------------------------------------------
    */
        function unitCalculationResultByUnitId_HH($id)
        {
            $data =  Unit::find($id);
            return $data? $data->calculation_result:0;
        }
    /*
    |----------------------------------------------------------------
    | Unit Calculation Result By Unit Id [calculation_result]
    |-----------------------------------------------------------------
    */

        function getTotalQuantityByUnitId_HH($unit_id, $quantity)
        {
            $calculation_result = unitCalculationResultByUnitId_HH($unit_id);
            return $calculation_result * $quantity;
        }

    /*
    |----------------------------------------------------------------
    | total Available Stock after calculation  [available_stock]
    |-----------------------------------------------------------------
    */
        function availableStock_HH($unit_id,$availableQty)
        {
            $calculationResult =  unitCalculationResultByUnitId_HH($unit_id);
            return $availableQty / $calculationResult ;
        }
    /*
    |----------------------------------------------------------------
    | total Available Stock after calculation  [available_stock]
    |-----------------------------------------------------------------
    */


    /*
    |----------------------------------------------------------------
    | additionProductQuantity  [available_stock]
    |-----------------------------------------------------------------
    */
        function additionStockQuantity_HH($product_variation_id,$stock_id,$sale_unit_id,$quantity)
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
                $stock->available_stock = ($stock->available_stock) + ($total_sale_quantity);
                $stock->used_stock      = ($stock->used_stock?$stock->used_stock:0) - ($total_sale_quantity);
                $stock->save();
            }

                /*addition with main stock*/
                $mstock  =  MainStock::where('product_variation_id',$product_variation_id)
                    //->where('business_location_id',$business_location_id)
                    //->where('stock_id',$stock_id)
                    //->where('company_id',$company_id)
                    ->whereNull('deleted_at')
                    ->first();
                if($mstock)
                {
                    $mstock->available_stock = ($mstock->available_stock) + ($total_sale_quantity);
                    $mstock->used_stock      = ($mstock->used_stock?$mstock->used_stock:0) - ($total_sale_quantity);
                    $mstock->save();
                }
                /*addition with main stock*/

            return $stock;
        }
    /*
    |----------------------------------------------------------------
    | additionProductQuantity  [available_stock]
    |-----------------------------------------------------------------
    */




    /*
    |----------------------------------------------------------------
    | subtractionProductQuantity  [available_stock]
    |-----------------------------------------------------------------
    */
        function subtractionStockQuantity_HH($product_variation_id,$stock_id,$sale_unit_id,$quantity)
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

                /*subtraction from main stock*/
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
                /*subtraction from main stock*/
            return $stock;
        }
    /*
    |----------------------------------------------------------------
    | subtractionProductQuantity  [available_stock]
    |-----------------------------------------------------------------
    */


    /*
    |----------------------------------------------------------------
    | Check Primary Stock by Product Variation id  [available_stock]
    |-----------------------------------------------------------------
    */
        function checkPrimaryStockQtyByPVIDWithoutProductId_HH($stock_id,$business_location_id,$product_variation_id)
        {
            return PrimaryStock::where('business_location_id',$business_location_id)
                        ->where('stock_id',$stock_id)
                        ->where('product_variation_id',$product_variation_id)
                        ->whereNull('deleted_at')
                        ->first();
        }
    /*
    |----------------------------------------------------------------
    | Check Primary Stock by Product Variation id  [available_stock]
    |-----------------------------------------------------------------
    */



    /*
    |---------------------------------------------------------------------
    | subtraction from sale details quantity ,product_variation_id,sale_final_id
    |----------------------------------------------------------------------
    */
        function subtractionFromSaleDetailsQuantity_HH($sale_final_id,
            $product_variation_id,$sale_unit_id,$quantity
            )
        {
            //$calculation_result = unitCalculationResultByUnitId_HH($sale_unit_id);
            //$total_sale_quantity = $calculation_result * $quantity;

            $sold = SaleDetail::where('sale_final_id',$sale_final_id)
                            ->where('product_variation_id',$product_variation_id)
                            //->where('id',$sale_detail_id)
                            ->whereNull('deleted_at')
                            ->first();
            if($sold)
            {
                $sold->quantity          = ($sold->quantity) - ($quantity);

                $sold->sub_total         = ($sold->sub_total) - ($quantity * $sold->unit_price);
                $sold->return_quantity   = ($sold->return_quantity?$sold->return_quantity:0) + ($quantity);
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
    |---------------------------------------------------------------------
    | subtraction from sale details quantity ,product_variation_id,sale_final_id
    |----------------------------------------------------------------------
    */





