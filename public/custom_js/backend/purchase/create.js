
        $(document).ready(function(){
            totalQtyAndTotalAmountSetAsText();

        });

    /*
    |-----------------------------------------------------
    | All document bind by on Method is predefined here
    |----------------------------------------------
    */
        $(document).on('change','.supplier_id',function(){
            searchBarCodeSkyDisableEnable($(this).val());
        });

        //Pull Low Stock Product
        $(document).on('click','#pullingLowProductListByAjax',function(){
            pullLowStockProduct();

        });

        //Remove Single Cart
        $(document).on('click','.removePurchaseSingleCart',function(e){
            e.preventDefault();
            removePurchaseSingleCart($(this).data('id'));

        });

        //Remove All  Cart
        $(document).on('click','#removeAllCart',function(e){
            e.preventDefault();
            removePurchaseAllCart();

        });


        //get current data by class
        $(document).on('keyup','.get_current_data_class',function(e){
            e.preventDefault();
            getCurrentData($(this).data('id'),$(this).data('name'));
            /* if($(this).data('name') == "unit_selling_price_inc_tax")
            {
                console.log('unit Sell - ');
                console.log($(this).data('name'));
            }
            else{
                console.log('others - ');
                console.log($(this).data('name'));
            } */
            totalQtyAndTotalAmountSetAsText();
        });

        //Middle Part [discount,purchae,shipping ,total Purchase Amount ]
        $(document).on('change keyup','.discount_type_id_class ,.discount_value_class,.purchase_tax_applicable_id_class,.purchase_tax_in_parcent_value_id_class,.additional_shipping_cost_id_class,.payment_amount_now_class',function(e)
        {
            e.preventDefault();
            discountTaxShippingCalculation();

        });
        //Middle Part [discount,purchae,shipping ,total Purchase Amount ]


        // update value of cart by blur
        $(document).on('blur','.get_current_data_class',function(e){
            e.preventDefault();
            updateCurrentValueOfCart($(this).data('id'));
            totalQtyAndTotalAmountSetAsText();

        });
        // update value of cart by blur

        /** Search and Add to Cart By Product Name/SKU/Bar Code **/
        //$(document).ready(function(){
            var ctrlDown = false,
            ctrlKey = 17,
            cmdKey = 91,
            vKey = 86,
            cKey = 67;
            $(document).on('keyup','#p_name_sku_bar_code_id',function(e){
                e.preventDefault();
                if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
                if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey)) return false;
                searchAndAddToCartByPNameSkuBarcode();
            });
        //);

        /** Search and Add to Cart By Product Name/SKU/Bar Code **/
    /*
    |----------------------------------------------
    | All document bind by on Method is predefined here END
    |---------------------------------------------------------
    */



    /*
    |-----------------------------------------------------
    |  Number and Decimal check and Protection
    |----------------------------------------------
    */
        $(document).on('keypress','.get_current_data_class',function(e){
            return isNumber(e, this);
        });

        $(document).on('keypress','.discount_value_class,.purchase_tax_in_parcent_value_id_class,.additional_shipping_cost_id_class',function(e)
        {
            return isNumber(e, this);
        });

        //function of Number and Decimal check
        function isNumber(evt, element)
        {
            //return isNumber(event, this);//call
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (
                (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // Check minus and only once.
                (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // Check dot and only once.
                (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    /*
    |----------------------------------------------
    | Number and Decimal check and Protection END ]
    |---------------------------------------------------------
    */




    /*
    |-----------------------------------------------------
    | Calculation with ajax
    |----------------------------------------------
    */
        function getCurrentData(id,name)
        {
            // ================== get value first ==================
            var getPurchaseQuantity             = nanCheck(parseFloat($('#purchase_quantity_id_'+id).val()));
            var purchaseUnitPriceBeforeDiscount = nanCheck(parseFloat($('#purchase_unit_price_before_discount_id_'+id).val()));
            var discountValueInParcent          =  nanCheck(parseFloat($('#discount_value_in_parcent_id_'+id).val()));
            var purchaseUnitPriceBeforeTax      =  nanCheck(parseFloat($('#purchase_unit_price_before_tax_id_'+id).val()));

            var getSubtotalCurrentValue         =  nanCheck(parseFloat($('#sub_total_before_tax_id_'+id).val()));

            var productTaxValue                 =  nanCheck(parseFloat($('#product_tax_id_'+id).val()));
            var getNetCost                      =  nanCheck(parseFloat($('#net_cost_id_'+id).val()));
            var getLineTotal                    =  nanCheck(parseFloat($('#line_total_id_'+id).val()));
            var getProfitMarginInParcent        =  nanCheck(parseFloat($('#profit_margin_parcent_id_'+id).val()));
            var unitSellingPriceIncTax          =  nanCheck(parseFloat($('#unit_selling_price_inc_tax_id_'+id).val()));


            var wholeSalePrice                  =  nanCheck(parseFloat($('#whole_sale_price_'+id).val()));
            var mrpPrice                        =  nanCheck(parseFloat($('#mrp_price_'+id).val()));
            var onlineSalePrice                 =  nanCheck(parseFloat($('#online_sale_price_'+id).val()));
            // ================== get value first end==================


            //final discount amount #[after discount calcuation]
            var discountAmount =  discountCal(1,purchaseUnitPriceBeforeDiscount,discountValueInParcent);

            //final purchase price after discount amount
            var purchasePriceAfterDiscount = purchaseUnitPriceBeforeDiscount - discountAmount ;

            var setSubTotalBreforeTax =  purchasePriceAfterDiscount * getPurchaseQuantity ;

            //again setting new data after calculation
            $('#purchase_unit_price_before_tax_id_'+id).val(parseFloat(purchasePriceAfterDiscount).toFixed(2));
            $('#sub_total_before_tax_id_'+id).val(parseFloat(setSubTotalBreforeTax).toFixed(2));

            // tax calculation after discount price
            var taxAmount =   taxCal(1,purchasePriceAfterDiscount,productTaxValue);
            var netCostIncTax = purchasePriceAfterDiscount + taxAmount;
            // tax calculation after discount price end
            $('#net_cost_id_'+id).val(parseFloat(netCostIncTax).toFixed(2));

            // total line Cost
            var totalLineCostIncTax = netCostIncTax * getPurchaseQuantity;
            $('#line_total_id_'+id).val(parseFloat(totalLineCostIncTax).toFixed(2));
            // total line Cost


            if(name == "unit_selling_price_inc_tax")
            {
                var profitParcent = getParcentAmountFromUnitSellingPriceIncTax(getNetCost,unitSellingPriceIncTax);
                $('#profit_margin_parcent_id_'+id).val(parseFloat(profitParcent).toFixed(2));
            }
            else{
                //profit margin
                var profitAmount = discountCal(1,netCostIncTax,getProfitMarginInParcent);
                var finalUnitSellingPriceIncTax = netCostIncTax + profitAmount;

                $('#unit_selling_price_inc_tax_id_'+id).val(parseFloat(finalUnitSellingPriceIncTax).toFixed(2));
                //profit margin
            }
        }
    /*
    |----------------------------------------------
    | Calculation with ajax
    |---------------------------------------------------------
    */


    /*
    |------------------------------------------------------------------------------------------
    | Update mrp, whole sale, online price modal and set price Current Value of Pruchase Cart
    |-----------------------------------------------------------------------------------
    */
        $(document).on('click','.edit_base_on_mrp',function(){

            allFieldEmptyWhenCloseCalculationModal();
            var id                  = $(this).data('id');
            var regular_price       = $(this).data('regular_price');
            var mrp_price           = $(this).data('mrp_price');
            var whole_sale_price    = $(this).data('whole_sale_price');
            var online_sale_price   = $(this).data('online_sale_price');

            $('.reset_mrp_price').val(mrp_price);
            $('.reset_regular_sale_price').val(regular_price);
            $('.reset_whole_sale_price').val(whole_sale_price);
            $('.reset_online_sale_price').val(online_sale_price);

            var changeType = 1;
            var priceType = 'reset';

            var setRegularSaleProfitAmount   =  seperateAmountByCalculationType(changeType,mrp_price,priceType,regular_price);
            var setWholeSaleProfitAmount     =  seperateAmountByCalculationType(changeType,mrp_price,priceType,whole_sale_price);
            var setOnlineSaleProfitAmount    =  seperateAmountByCalculationType(changeType,mrp_price,priceType,online_sale_price);

            $('.product_id').val(id);

            $('.set_regular_sale_price').val(setRegularSaleProfitAmount);
            $('.set_whole_sale_price').val(setWholeSaleProfitAmount);
            $('.set_online_sale_price').val(setOnlineSaleProfitAmount);

            $('#baseOnMrpPriceModal').modal('show');
        });


        $(document).on('click','.closeCalculationModel',function(){
            allFieldEmptyWhenCloseCalculationModal();
            $('#baseOnMrpPriceModal').modal('hide');
        });

        function allFieldEmptyWhenCloseCalculationModal()
        {
            $('.makeEmptyField').val('');
            $('.product_id').val('');
        }

        function seperateAmountByCalculationType(changeType,mrp,priceType,amount)
        {
            var profitAmount    = 0;
            var finalResult     = 0;
            if(priceType == 'reset') // set , reset
            {
                profitAmount = mrp - amount;
            }else{
                profitAmount = amount;
            }
            if(changeType == 1)//percent
            {
                if(priceType == 'reset') // set , reset
                {
                    finalResult = ((profitAmount / mrp) * 100).toFixed(2) ;
                }else{
                    finalResult = ((profitAmount * mrp ) / 100).toFixed(2) ;
                }
            }else{
                finalResult = profitAmount;
            }
            return finalResult;
        }

         /**calculation when keyup or change press */
        $(document).on('change keyup','.keyup_change',function(){
            var data_id     = $(this).data('id');
            var mrp_price   = nanCheck(parseFloat($('.reset_mrp_price').val()));
            if($(this).data('id') != 'mrp')
            {
                setAndResetAllPriceAfterKeyupChanges(data_id);
            }else{
                    $('.all_mrp').each(function() {
                        setAndResetAllPriceAfterKeyupChanges($(this).data('id'));
                });
            }
            function setAndResetAllPriceAfterKeyupChanges(data_id)
            {
                var changeType  =  $("option:selected", $("#"+data_id+'cng')).val();
                var calType     =  $("option:selected", $("#"+data_id+'cal')).val();
                var setAmount   =  nanCheck(parseFloat($("#"+data_id+'set').val()));

                var priceType = 'set';

                var resetProfitAmount   =  nanCheck(parseFloat(seperateAmountByCalculationType(changeType,mrp_price,priceType,setAmount)));
                var final_result = 0;
                if(calType == 1)
                {
                    final_result = mrp_price + resetProfitAmount;
                }else{
                    final_result = mrp_price - resetProfitAmount;
                }
                $("#"+data_id+'rst').val(final_result.toFixed(2));
            }
        });
        /**calculation when keyup or change press */

        /**update value in  the cart */
        $(document).on('click','.updateResultCalculationModel',function(){
            var id                  = $('.product_id').val();

            var mrp_price           = $('.reset_mrp_price').val();
            var regular_price       = $('.reset_regular_sale_price').val();
            var whole_sale_price    = $('.reset_whole_sale_price').val();
            var online_sale_price   = $('.reset_online_sale_price').val();


            var purchaePrice    = $('#purchase_unit_price_before_tax_id_'+id).val();
            var profit          = regular_price - purchaePrice ;
            var profitMargin    = ((profit / purchaePrice) * 100).toFixed(2) ;

            $('#unit_selling_price_inc_tax_id_'+id).val(regular_price);
            $('#profit_margin_parcent_id_'+id).val(profitMargin);
            $('#whole_sale_price_'+id).val(whole_sale_price);
            $('#mrp_price_'+id).val(mrp_price);
            $('#online_sale_price_'+id).val(online_sale_price);

            updateCurrentValueOfCart(id);

            allFieldEmptyWhenCloseCalculationModal();
            $('#baseOnMrpPriceModal').modal('hide');
        });
        /**update value in  the cart */
    /*
    |------------------------------------------------------------------------------------------
    | Update mrp, whole sale, online price modal and set price Current Value of Pruchase Cart
    |-----------------------------------------------------------------------------------
    */


    /*
    |------------------------------------------------------------------------------------------
    | Update Current Value of Pruchase Cart
    |-----------------------------------------------------------------------------------
    */
        function updateCurrentValueOfCart(id)
        {
            // ================== get value first ==================
            var purchase_quantity                   = nanCheck(parseFloat($('#purchase_quantity_id_'+id).val()));
            var purchase_unit_price_before_discount = nanCheck(parseFloat($('#purchase_unit_price_before_discount_id_'+id).val()));
            var discount_value_in_parcent           =  nanCheck(parseFloat($('#discount_value_in_parcent_id_'+id).val()));
            var purchase_unit_price_before_tax      =  nanCheck(parseFloat($('#purchase_unit_price_before_tax_id_'+id).val()));

            var sub_total_before_tax                =  nanCheck(parseFloat($('#sub_total_before_tax_id_'+id).val()));

            var product_tax                         =  nanCheck(parseFloat($('#product_tax_id_'+id).val()));
            var net_purchase_amount                 =  nanCheck(parseFloat($('#net_cost_id_'+id).val()));
            var line_total                          =  nanCheck(parseFloat($('#line_total_id_'+id).val()));
            var profit_margin_parcent               =  nanCheck(parseFloat($('#profit_margin_parcent_id_'+id).val()));
            var unit_selling_price_inc_tax          =  nanCheck(parseFloat($('#unit_selling_price_inc_tax_id_'+id).val()));

            var wholeSalePrice                      =  nanCheck(parseFloat($('#whole_sale_price_'+id).val()));
            var mrpPrice                            =  nanCheck(parseFloat($('#mrp_price_'+id).val()));
            var onlineSalePrice                     =  nanCheck(parseFloat($('#online_sale_price_'+id).val()));
            // ================== get value first end==================
            var product_var_id = id;
            //console.log(unit_selling_price_inc_tax);
            var url = $('#updateSinglePurchaseCartByAjax').val();
            //setTimeout(function (){
                $.ajax({
                    url: url,
                    data: {product_var_id,purchase_quantity,purchase_unit_price_before_discount,discount_value_in_parcent,
                    purchase_unit_price_before_tax,sub_total_before_tax,product_tax,net_purchase_amount,
                    line_total,profit_margin_parcent,unit_selling_price_inc_tax,
                    wholeSalePrice:wholeSalePrice,mrpPrice:mrpPrice,onlineSalePrice:onlineSalePrice
                    },
                    type: "GET",
                    //datatype:"JSON",
                    beforeSend:function(){
                        //$('.loading').fadeIn();
                    },
                    success: function(response){
                        $('#showResult').html(response);
                        totalQtyAndTotalAmountSetAsText();
                    },
                    complete:function(){
                        //$('.loading').fadeOut();
                    },
                });
            //}, 200)
            //end ajax
        }

    /*
    |----------------------------------------------------------------------------------
    | Update Current Value of Pruchase Cart END ]
    |------------------------------------------------------------------------------------------------
    */



    /*
    |-----------------------------------------------------------------------
    |  Middle Part [discount,purchae,shipping ,total Purchase Amount ]
    |-------------------------------------------
    */
        function  discountTaxShippingCalculation()
        {
            //---------discount--------------------
            var  totalPurchaseAmount    =  totalLineCost();
            var discountType            = nanCheck(parseFloat($('.discount_type_id_class').val()));
            var parcentValue            =  nanCheck(parseFloat($('.discount_value_class').val()));
            var finalDiscountAmount     = parcentValue;
            if(discountType)
            {
                finalDiscountAmount = discountCal(discountType, totalPurchaseAmount,parcentValue);
            }else{
                finalDiscountAmount = 0;
                //$('.discount_value_class').val(0);
            }
            $('#discount_amount_id').val(finalDiscountAmount.toFixed(2));
            //---------discount--------------------


            //------------------ tax-------------------
            var discountAmount          = nanCheck(parseFloat($('#discount_amount_id').val()));
            var totalPurchaseAmountAfterDiscount     = totalLineCost() - discountAmount;
            var parcentType             = nanCheck(parseFloat($('.purchase_tax_applicable_id_class').val()));
            var taxParcentValue         = nanCheck(parseFloat($('.purchase_tax_in_parcent_value_id_class').val()));
            var finalTaxAmount = taxParcentValue;
            if(parcentType)
            {
                finalTaxAmount = taxCal(parcentType, totalPurchaseAmountAfterDiscount,taxParcentValue);
            }else{
                finalTaxAmount = 0;
                //$('.purchase_tax_in_parcent_value_id_class').val(0);
            }
            $('.purchase_tax_amount_class').val(finalTaxAmount.toFixed(2));
            //------------------ tax End-------------------

            var shippingCost = nanCheck(parseFloat($('.additional_shipping_cost_id_class').val()));


            var totalCost =  shippingCost + finalTaxAmount; //total charge
            var totalFinalPurchaseAmount =   ((totalPurchaseAmount - finalDiscountAmount) + totalCost) ;
            $('.total_purchase_amount_class').val(totalFinalPurchaseAmount.toFixed(2));

            /**from payment part */
            var total_payment_now       = nanCheck(parseFloat($('.payment_amount_now_class ').val()));
            if(total_payment_now > totalFinalPurchaseAmount)
            {
                $('.payment_amount_now_class ').val(totalFinalPurchaseAmount);
            }
            total_payment_now       = nanCheck(parseFloat($('.payment_amount_now_class ').val()));
            var total_due_after_payment = (totalFinalPurchaseAmount - total_payment_now).toFixed(2);
            $('.total_due_amount_after_payment_class').val(total_due_after_payment);
        }
    /*
    |-----------------------------------------------------
    | Middle Part [discount,purchae,shipping ,total Purchase Amount End]
    |-----------------------------------------------------------------------
    */





    /*
    |------------------------------------------------------------
    | final Result set in the strong tag. and its uses more
    |--------------------------------------------------
    */
        function totalQtyAndTotalAmountSetAsText()
        {
            $('#totalQty').text(totalQty());
            $('#totalAmount').text(totalLineCost());

            discountTaxShippingCalculation();

            /** submit button enable and disable */
            $('.sumbitButton').attr('disabled','disabled');
            if(totalQty() > 0)
            {
                $('.sumbitButton').removeAttr('disabled','disabled');
            }
            else{
                $('.sumbitButton').attr('disabled','disabled');
            }
            /** submit button enable and disable */

        }
    /*
    |-----------------------------------------------------
    | final Result set in the strong tag. and its uses more END
    |--------------------------------------------------------------
    */




    /*
    |------------------------------------------------------------
    | Total Qty and Amount
    |-------------------------------------------
    */
        function totalQty()
        {
            var sum = 0;
            $('.total_qty_class').each(function() {
                sum += nanCheck(parseFloat($(this).val()));
            });
            return sum;
        }

        function totalLineCost()
        {
            var sum = 0;
            $('.line_total_class').each(function() {
                sum += nanCheck(parseFloat($(this).val()));
            });
            return sum.toFixed(2);
        }
    /*
    |----------------------------------------------
    | Total Qty and Amount END
    |---------------------------------------------------------
    */




    /*
    |----------------------------------------------------------------
    | get Parcent Amount From Selling Unit Price inc Tax
    |-----------------------------------
    */
        function getParcentAmountFromUnitSellingPriceIncTax(lineTotalAmount,SellingPriceIncTax)
        {
           var profitAmount =  SellingPriceIncTax - lineTotalAmount;
           return ( profitAmount * 100) / lineTotalAmount;
        }

    /*
    |----------------------------------------------
    | get Parcent Amount From Selling Unit Price inc Tax END
    |---------------------------------------------------------------------
    */

    /*
    |----------------------------------------------------------------
    | Discount Calculation
    |-----------------------------------
    */
        function discountCal(parcentType = 1 , calculateAmount,parcentValue)
        {
            if(parcentType == 1)//parcent
            {
              return   (calculateAmount * parcentValue) / 100;
            }else{
               return parcentValue;
            }
        }

    /*
    |----------------------------------------------
    | Discount Calculation END
    |---------------------------------------------------------------------
    */



    /*
    |----------------------------------------------------------------
    | tax Calculation
    |-----------------------------------
    */
        function taxCal(parcentType = 1 , calculateAmount,parcentValue)
        {
            if(parcentType == 1)//parcent
            {
              return   (calculateAmount * parcentValue) / 100;
            }else{
               return parcentValue;
            }
        }

    /*
    |----------------------------------------------
    | tax Calculation End
    |---------------------------------------------------------------------
    */




    /*
    |-----------------------------------------------------------------
    | Product Name/SKU/Bar Code auto focus againest of bussiness id
    |----------------------------------------------------
    */
        $(document).ready(function(){
            $('#p_name_sku_bar_code_id').attr('disabled','disabled');
            var businesslocation = $('.supplier_id').val();
            searchBarCodeSkyDisableEnable(businesslocation);
        });
        function searchBarCodeSkyDisableEnable(businesslocation)
        {
            if(businesslocation)
            {
                $('#p_name_sku_bar_code_id').removeAttr('disabled','disabled');
                $('#p_name_sku_bar_code_id').focus();
            }
            else{
                $('#p_name_sku_bar_code_id').attr('disabled','disabled');
            }
        }
    /*
    |----------------------------------------------------
    | Product Name/SKU/Bar Code End auto focus againest of bussiness id
    |-----------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------------------
    | Search and Add to Cart By Product Name/SKU/Bar Code
    |----------------------------------------------------------------
    */
        function searchAndAddToCartByPNameSkuBarcode()
        {
            var pNameSkuBarCode = $('.p_name_sku_bar_code_id_class').val();
            var supplier_id     =  $("option:selected", $(".supplier_id")).val();
            var url = $('#searchingProductByAjax').val();
            if(pNameSkuBarCode.length > 1)
            {
                setTimeout(function (){
                    $.ajax({
                        url: url,
                        type: "GET",
                        data: {pNameSkuBarCode:pNameSkuBarCode,supplier_id:supplier_id},
                        success: function(response)
                        {
                            if(response.match == "single")
                            {
                                $('#product_list').fadeOut();
                                $('#showResult').html(response.data);
                                totalQtyAndTotalAmountSetAsText();
                                $('#p_name_sku_bar_code_id').val('');
                                $('#p_name_sku_bar_code_id').focus();
                            }
                            else if(response.match == "multiple")
                            {
                                $('#product_list').fadeIn();
                                $('#product_list').html(response.data);
                            }
                        },
                    });
                }, 700)
            }else{
                $('#product_list').fadeOut();
            }
        }

        /*
        |-----------------
        |	After searchAndAddToCartByPNameSkuBarcode Result
        |-----------------
        */
            var ctrlDown = false,
            ctrlKey = 17,
            cmdKey = 91,
            vKey = 86,
            cKey = 67;
            $(document).on('click','.dropdown_class',function(e){
                e.preventDefault();
                if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
                if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey)) return false;
                //$('#p_name_sku_bar_code_id').val($(this).data('id'));
                $('#product_list').fadeOut();

                    var pNameSkuBarCode = $(this).data('id');
                    var url = $('#addToCartSingleProductByResultOfSearchingByAjax').val();
                    $.ajax({
                    url: url,
                    type: "GET",
                    data: {pNameSkuBarCode:pNameSkuBarCode},
                    success: function(response)
                    {
                        if(response.match == "single")
                        {
                            $('#showResult').html(response.data);
                            totalQtyAndTotalAmountSetAsText();
                            $('#p_name_sku_bar_code_id').val('');
                            //$('#p_name_sku_bar_code_id').focus();
                        }
                    },
                });
            });
            $(document).click(function(){
                $('#product_list').fadeOut();
                $('#p_name_sku_bar_code_id').val('');
                //$('#p_name_sku_bar_code_id').focus();
            });
        /*
        |-----------------
        |	After searchAndAddToCartByPNameSkuBarcode Result
        |-----------------
        */
    /*
    |----------------------------------------------------------------
    | Search and Add to Cart By Product Name/SKU/Bar Code
    |--------------------------------------------------------------------------------------------
    */









    /*
    |----------------------------------------------------------------
    | Pull Low Stock Product
    |------------------------------
    */
        function pullLowStockProduct()
        {
            var url             = $('#pullingLowProductListByAjax').data('url');
            var alert_quantity  = getValueFromInputField('low_quantity_id_class');
            var unit_id         = getValueFromSelectOption('unit_id_class');
            var category_id     = getValueFromSelectOption('category_id_class');
            var brand_id        = getValueFromSelectOption('brand_id_classs');
            $.ajax({
                url: url,
                data: {alert_quantity:alert_quantity,unit_id:unit_id,category_id:category_id,brand_id:brand_id},
                type: "GET",
                //datatype:"JSON",
                beforeSend:function(){
                    //$('.loading').fadeIn();
                },
                success: function(response){
                    //console.log(response);
                    $('#showResult').html(response);
                    $('#pullLowStockProduct').modal('hide')
                    totalQtyAndTotalAmountSetAsText();
                },
                complete:function(){
                    //$('.loading').fadeOut();
                },
            });
            //end ajax
        }
    /*
    |-------------------------------
    | Pull Low Stock Product End
    |---------------------------------------------------------------
    */




    /*
    |----------------------------------------------
    | Purchaes single cart remove
    |------------------------------------------
    */
        function removePurchaseSingleCart(productVarId)
        {
            var url   = $('#removeSinglePurchaseCart').val();
            $.ajax({
                url: url,
                type: "GET",
                data:{productVarId:productVarId},
                //datatype:"JSON",
                beforeSend:function(){
                    //$('.loading').fadeIn();
                },
                success: function(response){
                    $('#showResult').html(response);
                    totalQtyAndTotalAmountSetAsText();
                },
                complete:function(){
                    //$('.loading').fadeOut();
                },
            });
        }
    /*
    |----------------------------------------------
    | Purchaes single cart remove
    |---------------------------------------------------------
    */





    /*
    |----------------------------------------------
    | Purchaes All cart remove
    |------------------------------------------
    */
        function removePurchaseAllCart()
        {
            var url   = $('#removeAllPurchaseCart').val();
            $.ajax({
                url: url,
                type: "GET",
                //datatype:"JSON",
                beforeSend:function(){
                    //$('.loading').fadeIn();
                },
                success: function(response){
                    $('#showResult').html(response);
                    totalQtyAndTotalAmountSetAsText();
                },
                complete:function(){
                    //$('.loading').fadeOut();
                },
            });
        }
    /*
    |----------------------------------------------
    | Purchaes All cart remove
    |---------------------------------------------------------
    */





    /*
    |----------------------------------------------
    | Purchaes Cart If Exist
    |------------------------------------------
    */
        $(document).ready(function () {
            var url   = $('#purchaseCartIfExist').val();
            $.ajax({
                url: url,
                type: "GET",
                //datatype:"JSON",
                beforeSend:function(){
                    //$('.loading').fadeIn();
                },
                success: function(response){
                    $('#showResult').html(response);
                    totalQtyAndTotalAmountSetAsText();
                },
                complete:function(){
                    //$('.loading').fadeOut();
                },
            });
        });
    /*
    |----------------------------------------------
    | Purchaes Cart If Exist
    |---------------------------------------------------------
    */








    $(document).on('change','.stock_type_id_class',function(){
        var stock_type_id = $(this).val();
        var url   = $('#getStockByStockId').val();
            $.ajax({
                url: url,
                type: "GET",
                data:{stock_type_id:stock_type_id},
                datatype:"JSON",
                beforeSend:function(){
                    //$('.loading').fadeIn();
                },
                success: function(response){
                    $('.stock_id_class').html(response);
                },
                complete:function(){
                    //$('.loading').fadeOut();
                },
            });
    });




    /*
    |-----------------------------------------------------------------
    | get Value From Select Option and Radio Button by calss
    |---------------------------------------------------------------
    */
        function getValueFromSelectOption(className)
        {
            return $('.'+className).val();
        }
        function getValueFromInputField(className)
        {
            return $('.'+className).val();
        }
        function getValueFromInputFieldByID(IdName)
        {
            return $('#'+IdName).val();
        }

        function getValueFromRadioButton(className)
        {
            return $('.'+className+':checked').val();
            //return  $('.gold_color:checked').val();
            //console.log($('.parcel_type_id_class:checked').val());
        }
    /*
    |-------------------------------------------------------------
    | get Value From Select Option and Radio Button by calss  End
    |-------------------------------------------------------------------
    */





    /*
    |-----------------------------------------------------------------
    | Nan Check
    |-------------------------------------------------------------
    */
        function nanCheck(val)
        {
            var nanResult = 0;
            if(isNaN(val)) {
                nanResult = 0;
            }
            else{
                nanResult = val;
            }
            return nanResult;
        }
    /*
    |-----------------------------------------------------------------
    | Nan Check
    |-------------------------------------------------------------
    */
