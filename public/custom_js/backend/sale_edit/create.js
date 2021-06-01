




    /*
    |-------------------------------------------------------------
    |
    |-----------------------------------------------------
    */
        $(document).ready(function(){
            var url = $('.saleEditWhenEditCartExit_class').val();
            var id = $('.order_id_class').val();
            $.ajax({
                url: url,
                type: "GET",
                data: {id:id},
                success: function(response)
                {
                    $('#showResult').html(response);
                    setInputAndTextTypeOfThisMainOrder();
                },
            });
            
        });
    /*
    |-------------------------------------------------------------
    |
    |-----------------------------------------------------
    */

    /*
    |-------------------------------------------------------------
    |
    |-----------------------------------------------------
    */
       
    /*
    |-------------------------------------------------------------
    |
    |-----------------------------------------------------
    */

    /*
    |-------------------------------------------------
    | Remove Single Data From Cart
    |-------------------------------------------------------------------------------------
    */
        $(document).on('click','.pos_remove_row',function(e)
        {
            e.preventDefault();
            var url = $('.removeSingleDataFromEditSaleCart').val();
            var  id = $(this).data('id');
            var  product_var_id = $(this).data('product_var_id');
            $.ajax({
                url: url,
                type: "GET",
                data: {id:id,product_var_id:product_var_id},
                success: function(response)
                {
                    $('#showResult').html(response);
                    setInputAndTextTypeOfThisMainOrder();
                },
            });
        });
    /*
    |-------------------------------------------------
    | End Remove Single Data From Cart
    |-------------------------------------------------------------------------------------
    */



    /*
    |-------------------------------------------------
    | Remove All Data From Cart
    |-------------------------------------------------------------------------------------
    */
        $(document).on('click','.remove_all_row',function(e)
        {
            e.preventDefault();
            var url = $('.removeAllDataFromEditSaleCart').val();
            $.ajax({
                url: url,
                type: "GET",
                success: function(response)
                {
                    $('#showResult').html(response);
                    setInputAndTextTypeOfThisMainOrder();
                },
            });
        });
    /*
    |-------------------------------------------------
    | End Remove All Data From Cart
    |-------------------------------------------------------------------------------------
    */






    /*********************************************************************************** */


    /*
    |------------------------------------------------------------------------------
    | All Event Here
    |--------------------------------------------------------
    */
        /*when change price from 3/4 radio button item by click */
        $(document).on('click','.cr_priceClass',function(){
            setProductAmountDependsOnSelectedRadioButton();
            setAllInputAndTextAfterAllFinalCalculation();
        });


        /*when change  discount type by click */
        $(document).on('click','.cr_discountTypeClass',function(){
            setAllInputAndTextAfterAllFinalCalculation();
        });


        /*when change qty, amount/price and discount value , discount type */
        $(document).on('keyup change','.cr_discountValue ,.cr_current_quantity_class,.cr_sallingPrice',function(){
            setAllInputAndTextAfterAllFinalCalculation();
        });



        /*when change Sale Unit Id */
        //$(document).on('click','.cr_priceClass',function(){
        $(document).on('change','.cr_sale_unit_id_class',function(){
            setProductAmountFieldWhenFieldIsEmptyOrChangingUnitId();
            setAllInputAndTextAfterAllFinalCalculation();
        });



        /*when changing qty then check stock, if available not not */
        $(document).on('keyup change','.cr_current_quantity_class , .cr_sale_from_stock_class,.cr_sale_unit_id_class',function(e){
            //var event = e.currentTarget;
            var eventClass = $(this).data('class');
            stockAvailableOrNotWhenChangingSaleUnitQtyAndPrimaryStock(eventClass);
        });

    /*
    |-------------------------------------------------
    | All Event Here
    |-------------------------------------------------------------------------------------
    */


    /*
    |-------------------------------------------------------------------------------
    | PopUp Modal When Want to Create Cart
    |-------------------------------------------------------
    */
        $(document).on('click','.popupModalWhenWantToCreateCart',function(e)
        {
            var url = $('#popupModalWhenWantToCreateAddToCart').val();
            var product_id = $(this).data('id');
            $.ajax({
                url: url,
                type: "GET",
                data: {product_id:product_id},
                success: function(response)
                {
                    $('#popupProductModalWhenCreatingAddToCart').html(response).modal('show');

                    setProductAmountFieldWhenFieldIsEmptyOrChangingUnitId();
                    stockAvailableOrNotWhenChangingSaleUnitQtyAndPrimaryStock(e);
                    setAllInputAndTextAfterAllFinalCalculation();
                    setInputAndTextTypeOfThisMainOrder();
                },
            });
        });

    /*
    |-------------------------------------------------
    | PopUp Modal When Want to Create Cart
    |-------------------------------------------------------------------------------------
    */


    /*
    |-------------------------------------------------------------------------------
    | Edit PopUp Modal When Want to edit  Cart of Edit Sale
    |-------------------------------------------------------
    */
        $(document).on('click','.popupModalWhenWantToEditCart',function(e)
        {
            e.preventDefault();
            var url = $('#popupModalWhenWantToeditSaleEditModal').val();
            var id = $(this).data('id');
            var product_var_id = $(this).data('product_var_id');
            $.ajax({
                url: url,
                type: "GET",
                data: {id:id,product_var_id:product_var_id},
                success: function(response)
                {
                    $('#popupProductModalWhenEditOfCreatingAddToCart').html(response).modal('show');

                    //setProductAmountFieldWhenFieldIsEmptyOrChangingUnitId();
                    stockAvailableOrNotWhenChangingSaleUnitQtyAndPrimaryStock(e);
                    //setAllInputAndTextAfterAllFinalCalculation();
                    //setInputAndTextTypeOfThisMainOrder();
                },
            });
        });

    /*
    |-------------------------------------------------
    | Edit PopUp Modal When Want to edit  Cart of Edit Sale
    |-------------------------------------------------------------------------------------
    */




    /*
    |-------------------------------------------------------------------------
    |   Stock Availabe Or Not Check and Implements
    |-------------------------------------------------
    */
        function stockAvailableOrNotWhenChangingSaleUnitQtyAndPrimaryStock(eventClass)
        {
            $('.cr_addToCart_button').attr('disabled','disabled');
            /**sale unit id */
            var unit_id     =  $("option:selected", $(".cr_sale_unit_id_class")).val();
            var unit_name   =  $("option:selected", $(".cr_sale_unit_id_class")).text();

            var stock_id    =  $("option:selected", $(".cr_sale_from_stock_class")).val(); //$('.cr_sale_from_stock_class').val();
            var stock_name  =  $("option:selected", $(".cr_sale_from_stock_class")).text();

            var p_v_id      =  $('.cr_product_variation_id_class').val();
            var pressing_qty=  $('.cr_current_quantity_class').val();
            //console.log("stockId "+stock_id+ " pvid "+ p_v_id + " qty "+ pressing_qty+" name"+stock_name+' unitname ' +unit_name+"unit "+ unit_id);
            var url = $('.cr_checkQtyAvailableByStockIdPvId').val();
            setTimeout(function (){
                $.ajax({
                    url: url,
                    data: {
                            stock_id,product_variation_id:p_v_id,pressing_qty,stock_name,unit_id,unit_name
                        },
                    type: "GET",
                    //datatype:"JSON",
                    beforeSend:function(){
                        //$('.loading').fadeIn();
                    },
                    success: function(response){
                        //console.log(response);
                        $('.cr_selected_stock_name_class').text(response.stock_name);
                        $('.cr_selected_stock_quantity_class').text(response.available_stock.toFixed(2));
                        $('.cr_selected_stock_unit_name_class').text(response.unit_name);

                        $('.cr_finalSaleUnitId_class_text').val(response.unit_name);

                        /* available qty check and reset in the qty input field*/
                        if(response.available_stock < response.pressing_qty)
                        {
                            $('.cr_low_qty_alert_message').text('Limited Quantity, Available Quantity is '+response.available_stock.toFixed(2));
                            $('.cr_current_quantity_class').val(response.available_stock.toFixed(2));
                            $('.cr_totalQty_class').text(response.available_stock.toFixed(2));
                        }else{
                            $('.cr_low_qty_alert_message').text('');
                                if(response.pressing_qty > 0 && response.available_stock > 0)
                                {
                                    $('.cr_addToCart_button').removeAttr('disabled','disabled');
                                }else{
                                    $('.cr_addToCart_button').attr('disabled','disabled');
                                }
                        }
                        /* available qty check and reset in the qty input field*/

                        /* New all Sale Price set*/
                        $('.cr_defalutSalePriceClass').val(response.default_selling_price.toFixed(2)).change();
                        $('.cr_defalutSalePriceClass_text').text(response.default_selling_price.toFixed(2)).change();

                        $('.cr_defaultPurchasePriceClass').val(response.default_purchase_price.toFixed(2)).change();
                        $('.cr_defaultPurchasePriceClass_text').text(response.default_purchase_price.toFixed(2)).change();

                        $('.cr_wholeSalePriceClass').val(response.whole_sale_price.toFixed(2)).change();
                        $('.cr_wholeSalePriceClass_text').text(response.whole_sale_price.toFixed(2)).change();

                        $('.cr_offerSaleClass').val(response.promo_offer_price.toFixed(2)).change();
                        $('.cr_offerSaleClass_text').text(response.promo_offer_price.toFixed(2)).change();
                        /* New all Sale Price set*/

                        /* If Changes from sale Unit , then set price field */
                        if(eventClass == 'cr_sale_unit_class')
                        {
                            $('.cr_sallingPrice').val(response.default_selling_price.toFixed(2)).change();
                        }
                        /* If Changes from sale Unit , then set price field */

                        setAllInputAndTextAfterAllFinalCalculation();
                    },//end success
                    complete:function(){
                        //$('.loading').fadeOut();
                    },
                });
            }, 200)
            //setAllInputAndTextAfterAllFinalCalculation();
        }
    /*
    |---------------------------------------------------------
    |   Stock Availabe Or Not Check and Implements
    |------------------------------------------------------------------
    */




    /*
    |---------------------------------------------------------
    |   Set All Input Filed And Text Field After All Final Calculation
    |-------------------------------------------------
    */
        /**/
        function setAllInputAndTextAfterAllFinalCalculation()
        {
            $('.cr_totalAmount').text(getTotalAmount());
            $('.cr_subtotal_amount').text("("+getSubTotalByProductAmountAndQuantity()+")");
            $('.cr_discount_amount').text("("+getTotalDiscountAmount()+")");
            $('.cr_netTotalAmount').val(getTotalAmount());

            /* Selected Unit Name*/
            selectedUnitName();
        }
        /**/
    /*
    |---------------------------------------------------------
    |   Set All Input Filed And Text Field After All Final Calculation
    |-----------------------------------------------------------------------------
    */


        function setProductAmountFieldWhenFieldIsEmptyOrChangingUnitId()
        {
            setProductAmountDependsOnSelectedRadioButton();
        }



    /*
    |-----------------------------------------------------------------------------------
    | All  Calcuation Here
    |---------------------------------------------------
    */
        /*get total Amount without discount Amount*/
        function getTotalAmount()
        {
            return ((getSubTotalByProductAmountAndQuantity() - getTotalDiscountAmount()).toFixed(2));
        }
        /*get total Amount without discount Amount  End*/



        /*Get Product Amount/Price From (cr_priceClass)*/
        function getProductAmountFromInputField()
        {
            return nanCheck($('.cr_sallingPrice').val());
        }
        /*Get Product Amount/Price From (cr_priceClass) End*/


        /*get total Quantity from (cr_priceClass)*/
        function getQuantityFromInputField()
        {
            return nanCheck($('.cr_current_quantity_class').val());
        }
        /*get total Quantity from (cr_priceClass) End*/


        /*get Sub Total By Product Amount And Quantity*/
        function getSubTotalByProductAmountAndQuantity()
        {
           return  ((getQuantityFromInputField() * getProductAmountFromInputField()).toFixed(2));
        }
        /*get Sub Total By Product Amount And Quantity End*/

        /*get total Discount Amount*/
        function getTotalDiscountAmount()
        {
            return getDiscountAmount(getSubTotalByProductAmountAndQuantity());
        }
        /*get total Discount Amount  End*/



        /*Get Discount Amount Only*/
        function getDiscountAmount(subTotal)
        {
            var discountAmount = 0;
            if(getSelectedDiscountType() == 'percentage')
            {
                    discountAmount = ((subTotal * getDiscountValue()) / 100).toFixed(2);
            }
            else if(getSelectedDiscountType() == 'fixed')
            {
                    discountAmount = getDiscountValue();
            }
            return discountAmount;
        }
        /*Get Discount Type From (cr_discountTypeClass) End*/


        /*Get Discount Amount Only*/
        function getSelectedDiscountType()
        {
            return  $('input[name=discountType]:checked').val();//nanCheck(val)
        }
        /*Get Discount Type From (cr_discountTypeClass) End*/


        /*Get Discount Value From  (cr_discountValue)*/
        function getDiscountValue()
        {
            return  nanCheck($('.cr_discountValue').val());//nanCheck(val)
        }
        /*Get Discount Value From (cr_discountValue) End*/


        /*Get Selected Item Amount (cr_priceClass)
        * From 3/4 typies sale options radio button
        */
        function getProductAmountFromSelectedRadioButton()
        {
            return  $('input[name=price]:checked').val();//nanCheck(val)
        }
        /*Get Selected Item Amount (cr_priceClass)
        * From 3/4 typies sale options radio button End
        */

        /*Set Product Amount in Price Field (cr_sallingPrice)
        * by clicking 3/4 typies sale options radio button
        */
        function setProductAmountDependsOnSelectedRadioButton()
        {
            $('.cr_sallingPrice').val(getProductAmountFromSelectedRadioButton());
        }
        /*Set Product Amount in Price Field (cr_sallingPrice)
        * by clicking 3/4 typies sale options radio button End
        */
    /*
    |-------------------------------------------------
    | All  Calcuation Here
    |-------------------------------------------------------------------------------------
    */





    /*
    |------------------------------------------------------------
    | sale Unit
    |-------------------------------------------
    */
        //selectedUnitName();
        $(document).on('change','.cr_sale_unit_id_class',function(){
            selectedUnitName();
        });

        function selectedUnitName()
        {
            var saleUnitId =  $("option:selected", $(".cr_sale_unit_id_class")).text();
            $('.cr_finalSaleUnitId_class').text(saleUnitId);
            $('.cr_finalSaleUnitId_class_text').val(saleUnitId);
            var qty = $('.cr_current_quantity_class').val();
            $('.cr_totalQty_class').text(qty);
        }
    /*
    |------------------------------------
    | sale Unit
    |-------------------------------------------------------------------
    */




    /*
    |------------------------------------------------------------
    | Sale Type , Promo Offer
    |-------------------------------------------
    */
        $(document).on('change','.cr_sale_type_class',function(){
            $('.cr_promo_code_class').hide();
            var activate            = $('.cr_promo_offer_activate_status_id_class').val();
            saleTypeAndPromoOffer(activate ,sale_type);
            var sale_type = $(this).val();
            if(sale_type == 2)
            {
                $('.cr_promo_code_class').show();
            }
            else{
                $('.cr_promo_code_class').hide();
            }
        });

        $(document).on('blur','.cr_promo_code_running_class',function(){
            var activate            = $('.cr_promo_offer_activate_status_id_class').val();
            var sale_type           = $('.cr_sale_type_class').val();
            saleTypeAndPromoOffer(activate ,sale_type);
        });
        function saleTypeAndPromoOffer(activate ,sale_type)
        {
            var promo_code_current  = $('.cr_promo_code_running_class').val();
            var promo_cod_from_db    = $('.cr_promo_offer_code_class').val();
            $('.cr_offer_sale_div').hide();
            if((activate == 1 && sale_type == 2) && (promo_code_current == promo_cod_from_db))
            {
                $('.cr_offer_sale_div').show();
            }
            else{
                $('.cr_offerSaleClass').removeAttr('checked','checked').change();
                $(".cr_defalutSalePrice").prop("checked", true).trigger("click");
                $('.cr_offer_sale_div').hide();
                //$('input[name="subDiscountType"]:checked').val();
            }
        }
    /*
    |------------------------------------
    | Sale Type , Promo Offer
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





    /***************************************************************************************************** */

    $(document).on('change keyup','.cr_subDiscountTypeClass, .cr_mainDiscountValueClass ,.cr_otherCostShippingCost_Class',function(){
        setInputAndTextTypeOfThisMainOrder();
    });

    /*
    |------------------------------------------------------------
    | Set Input and Text type of This Main Order
    |-------------------------------------------
    */
        function setInputAndTextTypeOfThisMainOrder()
        {
            $('.cr_subTotal_class').text(subTotalAmountOfThisOrder());
            $('.cr_subTotalValue_class').val(subTotalAmountOfThisOrder());

            $('.cr_payableAmountClass').val(finalTotalAmountOfThisOrder());
            $('.cr_payableAmount_class').text(finalTotalAmountOfThisOrder());

            $('.cr_discountedAmountOfSubTotalClass').text(getTotalDiscountAmountOfThisMainOrder());
            $('.cr_discountedAmountOfSubTotal_Class').val(getTotalDiscountAmountOfThisMainOrder());

            // Total Order Item
            $('.cr_totalItemShow_class').text(totalOrderItem());
            paymentButtonDisabledEnabled();
        }

    /*
    |--------------------------------------------
    | Set Input and Text type of This Main Order
    |-----------------------------------------------------------
    */


    /*
    |------------------------------------------------------------
    | Final Total Of This main Order
    |-------------------------------------------
    */
        function finalTotalAmountOfThisOrder()
        {
            return (nanCheck(parseFloat(subTotalWithoutShippingCost())) + nanCheck(parseFloat(shippingCostOfThisMainOrder()))).toFixed(2);
        }
        function subTotalWithoutShippingCost()
        {
            return  nanCheck(parseFloat(subTotalAmountOfThisOrder())).toFixed(2)  - nanCheck(parseFloat(getTotalDiscountAmountOfThisMainOrder())).toFixed(2);
        }
    /*
    |------------------------------------
    | Final Total Of This main Order
    |-------------------------------------------------------------------
    */



    /*
    |------------------------------------------------------------
    | subtotal Of This main Order
    |-------------------------------------------
    */
        function subTotalAmountOfThisOrder()
        {
            var sum = 0;
            $('.cr_getSubtotalClass').each(function(){
                sum += parseFloat($(this).text());
            });
            return parseFloat(sum).toFixed(2);
        }
    /*
    |------------------------------------
    | subtotal Of This main Order
    |-------------------------------------------------------------------
    */



    /*
    |------------------------------------------------------------
    |  Shipping Amount Of This Main Order
    |-------------------------------------------
    */
        function shippingCostOfThisMainOrder()
        {
            return nanCheck($('.cr_otherCostShippingCost_Class').val());
        }
    /*
    |------------------------------------
    | Shipping Amount Of This Main Order
    |-------------------------------------------------------------------
    */


    /*
    |------------------------------------------------------------
    | subtotal Of This main Order
    |-------------------------------------------
    */

        /*get total Discount Amount Of This Main Order*/
        function getTotalDiscountAmountOfThisMainOrder()
        {
            return getDiscountAmountOfThisMainOrder(subTotalAmountOfThisOrder());
        }
        /*get total Discount Amount Of This Main Order End*/


        /*Get Discount Amount Only Of This Main Order*/
        function getDiscountAmountOfThisMainOrder(subTotal)
        {
            var mainDiscountAmount = 0;
            if(getSelectedDiscountTypeOfThisMainOrder() == 'percentageValue')
            {
                    mainDiscountAmount = ((subTotal * getDiscountValueOfThisMainOrder()) / 100).toFixed(2);
            }
            else if(getSelectedDiscountTypeOfThisMainOrder() == 'fixedValue')
            {
                    mainDiscountAmount = getDiscountValueOfThisMainOrder();
            }
            return mainDiscountAmount;
        }
        /*Get Discount Type From (cr_discountTypeClass) Of This Main Order End*/


        /*Get Discount Amount Only Of This Main Order*/
        function getSelectedDiscountTypeOfThisMainOrder()
        {
            return   $("option:selected", $(".cr_subDiscountTypeClass")).val();
            //return  $('input[name=cr_subDiscountType]:checked').val();//nanCheck(val)
        }
        /*Get Discount Type From (cr_subDiscountTypeClass) Of This Main Order End*/


        /*Get Discount Value From  (cr_mainDiscountValueClass)  Of This Main Order*/
        function getDiscountValueOfThisMainOrder()
        {
            return  nanCheck($('.cr_mainDiscountValueClass').val());//nanCheck(val)
        }
        /*Get Discount Value From (cr_mainDiscountValueClass) Of This Main Order End*/

    /*
    |------------------------------------
    | subtotal Of This main Order
    |-------------------------------------------------------------------
    */

    function paymentButtonDisabledEnabled()
    {
        $('.updateButton_class').attr('disabled','disabled');
        if(totalOrderItem() > 0)
        {
            $('.updateButton_class').removeAttr('disabled','disabled');
        }else{
            $('.updateButton_class').attr('disabled','disabled');
        }
    }

    function totalOrderItem()
    {
        return  $('.totalId').val();
    }

    /***************************************************************************************************** */
