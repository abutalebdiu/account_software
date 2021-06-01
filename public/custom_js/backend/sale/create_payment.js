

    $(document).on('keyup change','.cr_final_payable_amount , .cr_given_amount_for_take_and_change',function(){
        setsInputAndTextTypeValue();
    });


    function setsInputAndTextTypeValue()
    {
        setDueAmount();
        setChangeableAmount();
    }

    function setDueAmount()
    {
        $('.cr_final_due_amount').val(totalDueAmount());
    }

    function totalDueAmount()
    {
        return (finalPayableAmount() - payNowAmount()).toFixed(2);
    }

    function payNowAmount()
    {
        return nanCheck($('.cr_final_payable_amount').val());
    }

    function finalPayableAmount()
    {
        return nanCheck($('.cr_fianl_payable_amount_get').val());
    }



    function setChangeableAmount()
    {
        $('.cr_change_amount_after_calculation').val(totalChangeableAmount());
    }
    function totalChangeableAmount()
    {
       return (givenAmountForTakeAndChange() - payNowAmount()).toFixed(2);
    }
    function givenAmountForTakeAndChange()
    {
        return nanCheck($('.cr_given_amount_for_take_and_change').val());
    }


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





    /*
    |-----------------------------------------------------------------
    | Final Order Submit by Ajax.. with payment [if pay]
    |-------------------------------------------------------------
    */
        $(document).on("submit",'.submitStoreFromAddToCartWithPayment',function(e){
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
                            $('#showResult').html('');
                            form[0].reset();
                            $('#popupPaymentModalBeforeSubmitingFromCart').html('').modal('hide');
                            $('#createQuotationHoldModal').html('').modal('hide');
                            setInputAndTextTypeOfThisMainOrder();

                            $('.alert_message').fadeIn();
                            $('.alert_message').text('Sale  Successfully'); 
                            $('.alert_message').attr('class','alert-success');
                            setTimeout(function () { 
                                $('.alert_message').fadeOut();
                                $('.alert_message').hide();
                                $('.alert_message').alert('close'); 
                                $('.alert_message').text(''); 
                                $('.alert_message').css({
                                    'display':'none'
                                }); 
                                $.print(response);
                            },500);
                        },
                    complete:function(){
                        //$('.loading').fadeOut();
                        console.log('complete');
                    },
            });
            //end ajax
        });
    /*
    |-----------------------------------------------------------------
    | Final Order Submit by Ajax.. with payment [if pay]
    |-------------------------------------------------------------
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
