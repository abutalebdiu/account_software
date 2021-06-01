




   


    /*
    |------------------------------------------------------------------------------------
    |  Change Quantity from cart
    |--------------------------------------------------
    */
       $(document).on('click','.quantityChange',function(e)
        {
            e.preventDefault();
            var url         = $('#changingQuantityFromSaleEditCartList').val();
            var product_var_id  = $(this).data("product_var_id");
            var change_type = $(this).data("change_type");
            var quantity    = $(this).data("quantity");
            $.ajax({
                url: url,
                type: "GET",
                data: {product_var_id:product_var_id,change_type:change_type,quantity:quantity},
                success: function(response)
                {
                    $('#showResult').html(response.html);
                    setInputAndTextTypeOfThisMainOrder();
                    if(response.available_status =='not_available')
                    {
                        $('#not_available_message_'+product_var_id).text('Quantity not available!').change();
                    }else{
                        $('#not_available_message_'+product_var_id).text('');
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
    |------------------------------------------------------------------------------------
    |  Updating Cartfrom Modal
    |--------------------------------------------------
    */
        $(document).on("submit",'#editSaleUpdateCartFromModal',function(e)
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
                        $('#popupProductModalWhenEditOfCreatingAddToCart').modal("hide");//edit modal hide
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




















