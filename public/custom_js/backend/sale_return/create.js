
    $(document).on('change keyup','.return_quantity_class',function(){
            setInputAndTextFieldAfterCalculation($(this).data('sale_details_id'));
    });

    $(document).on('change keyup','.discount_type_id_class ,.discount_value_class',function(){
        inputAndTextFieldSetAfterAllCalculation();
    });

        function setInputAndTextFieldAfterCalculation(id)
        {
            $('#return_amount_id_'+id).text(singleSubTotalReturnAmount(id));
            inputAndTextFieldSetAfterAllCalculation();
        }

        function inputAndTextFieldSetAfterAllCalculation()
        {
            $('.return_subtotal_amount_class').val(getSubTotalAmount());
            submitEnableDisable();
            $('.discount_amount_id_class').val(getTotalDiscountAmount());
            $('.return_total_amount_class').text(getTotalAmount())
            $('.return_total_amount_val_class').val(getTotalAmount())
        }

        function getTotalAmount()
        {
            return (getSubTotalAmount() + tax() - getTotalDiscountAmount()).toFixed(2);
        }
        function tax()
        {
            return 0;
            //return_tax_amount_class
        }
        function singleSubTotalReturnAmount(id)
        {
            return  (unitSalePrice(id) * returnQuantity(id)).toFixed(2);
        }

        function getSubTotalAmount()
        {
            var sum = 0;
            $('.get_subtotal_class').each(function(){
                sum += parseFloat($(this).text());
            });
            return parseFloat(sum).toFixed(2);
        }
        
        function unitSalePrice(id)
        {
            return  $('#sale_unit_id_'+id).val();
        }
        function saleQuantity(id)
        {
            return  parseFloat($('#sale_quantity_id_'+id).val());
        }

        function returnQuantity(id)
        {
            var returningQty =   nanCheck($("#return_quantity_id_"+id).val());
            if(saleQuantity(id) < returningQty)
            {
                $("#return_quantity_id_"+id).val(saleQuantity(id));
            }
            else{
                $("#return_quantity_id_"+id).val(returningQty);
            }
            return nanCheck(parseFloat($("#return_quantity_id_"+id).val()));
        }



            /*get total Discount Amount Of This Main Order*/
            function getTotalDiscountAmount()
            {
                return getDiscountAmountOfThisMainOrder(getSubTotalAmount());
            }
            /*get total Discount Amount Of This Main Order End*/
    
    
            /*Get Discount Amount Only Of This Main Order*/
            function getDiscountAmountOfThisMainOrder(subTotal)
            {
                var discountAmount = 0;
                if(getSelectedOptionDiscountType() == 1)
                {
                        discountAmount = ((subTotal * getDiscountValue()) / 100).toFixed(2);
                }
                else if(getSelectedOptionDiscountType() == 2)
                {
                        discountAmount = getDiscountValue();
                }
                return discountAmount;
            }
            /*Get Discount Type From (cr_discountTypeClass) Of This Main Order End*/
    
    
            /*Get Discount Amount Only Of This Main Order*/
            function getSelectedOptionDiscountType()
            {
               return  $("option:selected", $(".discount_type_id_class")).val();
            }
            /*Get Discount Type From (v) Of This Main Order End*/
            function getDiscountValue()
            {
                return nanCheck(parseFloat($(".discount_value_class").val())); 
            }


        function submitEnableDisable()
        {
            $('.submit_class').attr('disabled','disabled');
            if(getSubTotalAmount() > 0)
            {
                $('.submit_class').removeAttr('disabled','disabled');
            }else{
                $('.submit_class').attr('disabled','disabled');
            }
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


    $(document).ready(function(){
        submitEnableDisable();
        inputAndTextFieldSetAfterAllCalculation();
    });



