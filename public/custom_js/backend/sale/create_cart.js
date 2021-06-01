

    /*
    |------------------------------------------------------------------------------------
    |  When cart is exist
    |--------------------------------------------------
    */
            $(document).ready(function(){
                whenCartIsExisting();
                setInputAndTextTypeOfThisMainOrder();
            });

            function whenCartIsExisting()
            {
                var url = $('#whenCartIsExist').val();
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response)
                    {
                        $('#showResult').html(response);
                        setInputAndTextTypeOfThisMainOrder();
                    },
                });
            }
    /*
    |-------------------------------------------------
    | When cart is exist
    |-------------------------------------------------------------------------------------
    */




    /*
    |------------------------------------------------------------------------------------
    |  Making Add To Cart
    |--------------------------------------------------
    */
        $(document).on("submit",'#addToCartWhenSubmitingFromModal',function(e)
        {
            e.preventDefault();
            var form = $(this);
            var url = form.attr("action");
            var type = form.attr("method");
            var data = form.serialize();
            $.ajax({
                url: url,
                data: data,
                type: type,
                datatype:"JSON",
                beforeSend:function(){
                    //$('.loading').fadeIn();
                },
                success: function(response){
                        $('#popupProductModalWhenCreatingAddToCart').modal("hide");
                        //swal("Great","Successfully Updated Information","success");
                        form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                        $('#showResult').html(response);
                        setInputAndTextTypeOfThisMainOrder();
                    },
                complete:function(){
                    //$('.loading').fadeOut();
                    console.log('complete');
                },
            });
            //end ajax
        });

    /*
    |-------------------------------------------------
    | End Making Add To Cart
    |-------------------------------------------------------------------------------------
    */



    /*
    |------------------------------------------------------------------------------------
    |  Change Quantity from cart
    |--------------------------------------------------
    */
       $(document).on('click','.quantityChange',function(e)
        {
            e.preventDefault();
            var url         = $('#changeQuantityFromCartList').val();
            var product_id  = $(this).data("product_id");
            var change_type = $(this).data("change_type");
            var quantity    = $(this).data("quantity");

            $.ajax({
                url: url,
                type: "GET",
                data: {product_id:product_id,change_type:change_type,quantity:quantity},
                success: function(response)
                {
                    $('#showResult').html(response.html);
                    setInputAndTextTypeOfThisMainOrder();
                    if(response.available_status =='not_available')
                    {
                        $('#not_available_message_'+product_id).text('Quantity not available!').change();
                    }else{
                        $('#not_available_message_'+product_id).text('');
                    }
                },
            });
        });
    /*
    |-------------------------------------------------
    | End Change Quantity from cart
    |-------------------------------------------------------------------------------------
    */



    /*
    |-------------------------------------------------
    | Remove Single Data From Cart
    |-------------------------------------------------------------------------------------
    */
        $(document).on('click','.getIdForDelete',function(e)
        {
            e.preventDefault();
            var remainingItem = $('.totalId').val();
            if(remainingItem == 1 || remainingItem == 0)
            {
                $('.discountValueClass').val('0');
                $('.otherCostClass').val('0');
            }
            var url = $('#removeSingleDataFromCart').val();
            var product_id = $(this).data('id');
            $.ajax({
                url: url,
                type: "GET",
                data: {product_id:product_id},
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
        $(document).on('click','.removeAllDataFromCart',function(e)
        {
            e.preventDefault();

            $('.discountValueClass').val('0');
            $('.otherCostClass').val('0');

            var url = $('#removeAllDataFromCreateCart').val();
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



    /*
    |-------------------------------------------------
    | Payment Modal popup before submiting from cart
    |-------------------------------------------------------------------------------------
    */
        $(document).on('click','.paymentModalBeforeSubmitingFromCart',function(e)
        {
            e.preventDefault();

            var url = $('#paymentModalBeforeSubmitingFromCart').val();
            var customerId      = $('.customer_id').val();
            var reference_id      = $('.reference_id').val();
            var totalItem       = $('#totalItemShow').text();
            var subTotalAmount  = $('#subTotalValue').val();
            var discountType    = $('input[name="cr_subDiscountType"]:checked').val();
            var discountValue   = $('.cr_mainDiscountValueClass').val();
            var discountAmount  = $('#discountedAmountOfSubTotal').text();
            var otherCost       = $('.cr_otherCostShippingCost_Class').val();
            var payableAmount   = $('#payableAmount').text();
           // alert('type_ '+ discountType + ", value_ " +discountValue);
            $.ajax({
                url: url,
                type: "GET",
                data: {customerId:customerId,reference_id:reference_id,
                        totalItem:totalItem,subTotalAmount:subTotalAmount,
                        discountType:discountType,discountValue:discountValue,
                        discountAmount:discountAmount,otherCost:otherCost,payableAmount:payableAmount
                    },
                success: function(response)
                {
                    $('#popupPaymentModalBeforeSubmitingFromCart').html(response).modal('show');
                    /* dueSetFinalPaybleAmount();
                    paymentSubmitButtonEnableDisabled(); */
                },
            });
        });
    /*
    |-------------------------------------------------
    | End Payment Modal popup before submiting from cart
    |-------------------------------------------------------------------------------------
    */



    /*
    |-------------------------------------------------
    | make Sale Quotation
    |-------------------------------------------------------------------------------------
    */
        $(document).on('click','.makeSaleQuotation',function(e)
        {
            e.preventDefault();

            var url = $('#makeSaleQuotation').val();
            var customerId      = $('.customer_id').val();
            var reference_id    = $('.reference_id').val();
            var totalItem       = $('#totalItemShow').text();
            var subTotalAmount  = $('#subTotalValue').val();
            var discountType    = $('input[name="cr_subDiscountType"]:checked').val();
            var discountValue   = $('.cr_mainDiscountValueClass').val();
            var discountAmount  = $('#discountedAmountOfSubTotal').text();
            var otherCost       = $('.cr_otherCostShippingCost_Class').val();
            var payableAmount   = $('#payableAmount').text();
            $.ajax({
                url: url,
                type: "GET",
                data: {customerId:customerId,reference_id:reference_id,
                        totalItem:totalItem,subTotalAmount:subTotalAmount,
                        discountType:discountType,discountValue:discountValue,
                        discountAmount:discountAmount,otherCost:otherCost,payableAmount:payableAmount
                    },
                success: function(response)
                {   
                    $('#createQuotationHoldModal').html(response).modal('show');
                    $('.customer_phone').focus();
                },
            });
        });
    /*
    |-------------------------------------------------
    | make Sale Quotation
    |-------------------------------------------------------------------------------------
    */























