

    /*
    |------------------------------------------------------------------
    | payment single
    |------------------------------------------------------------------
    */
        $(document).on('change', '.supplier_id', function(e)
        {
            e.preventDefault();
            var url = $('.purchasePreviousDueAmount').val();
            var id  = $("option:selected",$('.supplier_id')).val();
            $.ajax({
                url: url,
                type: "GET",
                data:{id:id},
                success: function(response){
                    if(response)
                    {
                        $('.previous_amount').val(response);
                        calculation();
                    }else{
                        $('.previous_amount').val(0);
                    }
                },
            });
        });
    /*
    |------------------------------------------------------------------
    | payment single
    |------------------------------------------------------------------
    */



        $(document).on('keyup','.payment_amount_now_class',function(){
            calculation();
        });


        function calculation()
        {
            var previous_amount = nanCheck(parseFloat($('.previous_amount').val()));
            console.log(previous_amount);
            if(previous_amount <= 0 )
            {
                $('.payment_amount_now_class').val(0);
            }
            var pay_now         = nanCheck(parseFloat($('.payment_amount_now_class').val()));
            var due_amount      = (previous_amount  - pay_now).toFixed(2) ;
            $('.total_due_amount_after_payment_class').val(due_amount);
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
