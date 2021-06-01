


    /*
    |------------------------------------------------------------------------------------
    |  show product list or add to cart
    |--------------------------------------------------
    */
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
    |-------------------------------------------------
    | show product list or add to cart
    |-------------------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------------------
    | Search and Add to Cart By Product Name/SKU/Bar Code
    |----------------------------------------------------------------
    */
        function searchAndAddToCartByPNameSkuBarcode()
        {
            $('.qty_mess').text('');
            var pNameSkuBarCode = $('.p_name_sku_bar_code_id_class').val();
            var url = $('#searchingProductByAjax').val();
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
                                $('#product_list').fadeOut();
                                $('#showResult').html(response.data);
                                setInputAndTextTypeOfThisMainOrder();
                                $('#p_name_sku_bar_code_id').val('');
                                $('#p_name_sku_bar_code_id').focus();
                            }
                            else if(response.match == "multiple")
                            {
                                $('#product_list').fadeIn();
                                $('#product_list').html(response.data);
                            }
                            else if(response.checkQty == 0)
                            {
                                $('.qty_mess').text('Quantity is not available');
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
                $('.qty_mess').text('');
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
                            setInputAndTextTypeOfThisMainOrder();
                            $('#p_name_sku_bar_code_id').val('');
                            //$('#p_name_sku_bar_code_id').focus();
                        }
                        else if(response.checkQty == 0)
                        {
                            $('.qty_mess').text('Quantity is not available');
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






