
    /*
    |----------------------------------------------
    | All document bind by on Method is predefined here END
    |---------------------------------------------------------
    */

        /** Search and Add to Cart By Product Name/SKU/Bar Code **/
        //$(document).ready(function(){
            var ctrlDown = false,
            ctrlKey = 17,
            cmdKey = 91,
            vKey = 86,
            cKey = 67;
            $(document).on('keyup','.p_name_sku_bar_code_class',function(e){
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


    
    /*  Not Needed,so using
    |-----------------------------------------------------------------
    | Product Name/SKU/Bar Code auto focus againest of bussiness id
    |----------------------------------------------------
    */
        $(document).ready(function(){
            //$('.p_name_sku_bar_code_class').attr('disabled','disabled');
            //var businesslocation = $('#business_location_id').val();
            //searchBarCodeSkyDisableEnable(businesslocation);
        });
        function searchBarCodeSkyDisableEnable(businesslocation)
        {
            if(businesslocation)
            {
                $('.p_name_sku_bar_code_class').removeAttr('disabled','disabled');
                $('.p_name_sku_bar_code_class').focus();
            }
            else{
                $('.p_name_sku_bar_code_class').attr('disabled','disabled');
            }
        }
    /*
    |----------------------------------------------------
    | Product Name/SKU/Bar Code End auto focus againest of bussiness id
    |-----------------------------------------------------------------------
    */ //Not Needed,so using


    /*
    |--------------------------------------------------------------------------------------
    | Search and Add to Cart By Product Name/SKU/Bar Code
    |----------------------------------------------------------------
    */
        function searchAndAddToCartByPNameSkuBarcode()
        {
            var pNameSkuBarCode = $('.p_name_sku_bar_code_class').val();
            var url = $('.searchProductByNameSkuBarCodeForAddToCartWhenSaleCreate').val();
            if(pNameSkuBarCode.length > 1)
            {
                setTimeout(function (){
                    $.ajax({
                        url: url,
                        type: "GET",
                        data: {pNameSkuBarCode:pNameSkuBarCode},
                        success: function(response)
                        {
                            if(response.match == "single")
                            {
                                //$('#product_list').fadeOut();
                                $('#showResult').html(response.data);
                                setInputAndTextTypeOfThisMainOrder();//sub total from create.js
                                $('.p_name_sku_bar_code_class').val('');
                                $('.p_name_sku_bar_code_class').focus();
                            }
                            else if(response.match == "multiple")
                            {
                                $('#product_list').fadeIn();
                                $('#product_list').html(response.data);
                               setInputAndTextTypeOfThisMainOrder();//sub total from create.js
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
                //$('.p_name_sku_bar_code_class').val($(this).data('id'));
                $('#product_list').fadeOut();

                    var pNameSkuBarCode = $(this).data('id');
                    var url = $('.addToCartSingleProductByResultOfSearchingByAjaxWhenSaleCreate').val();
                    $.ajax({
                    url: url,
                    type: "GET",
                    data: {pNameSkuBarCode:pNameSkuBarCode},
                    success: function(response)
                    {
                        if(response.match == "single")
                        {
                            $('#showResult').html(response.data);
                            setInputAndTextTypeOfThisMainOrder();//sub total from create.js
                            $('.p_name_sku_bar_code_class').val('');
                            $('.p_name_sku_bar_code_class').focus();
                        }
                    },
                });
            });
            $(document).click(function(){
                $('#product_list').fadeOut();
                $('.p_name_sku_bar_code_class').val('');
                setInputAndTextTypeOfThisMainOrder();//sub total from create.js
                //$('.p_name_sku_bar_code_class').focus();
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

    function totalOrderItem()
    {
        return  $('.totalId').val();
    }
