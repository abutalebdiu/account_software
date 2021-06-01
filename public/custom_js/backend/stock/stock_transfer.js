       
    /*
    |-----------------------------------------------------------------
    | 
    |-------------------------------------------------------------
    */ 
        /**for primary stock transfer */
        $(document).on('click','.transferForm',function(){
            var id              = $(this).data('id');
            var stock_type_id   = $(this).data('stock_type_id');
            
            var url = $('.transform_from_primary_stock').val();
            $.ajax({
                url: url,
                type: 'GET',
                data:{id:id,stock_type_id:stock_type_id},
                success: function(response){
                    $('#transfer_modal_show').html(response).modal('show');
                },
            });
        });
    /*
    |-----------------------------------------------------------------
    | 
    |-------------------------------------------------------------
    */


    
    /*
    |-----------------------------------------------------------------
    | Transfer qty check and set
    |-------------------------------------------------------------
    */
        $(document).on('change keyup','.transfer_quantity,.to_stock_id',function(){
            var avlQty          = $('.available_stock_quantity').val();
            var transferQty     = nanCheck(parseFloat($(this).val()));
            if(transferQty > avlQty)
            {
                transferQty     = $('.transfer_quantity').val(avlQty);
            }

            var stockId = $("option:selected",$('.to_stock_id')).val();
            if(transferQty && stockId)
            {
            $('.submitButton').removeAttr('disabled','disabled'); 
            }else{
                $('.submitButton').attr('disabled','disabled');
            }
        });
    /*
    |-----------------------------------------------------------------
    | Transfer qty check and set
    |-------------------------------------------------------------
    */




    
    /*
    |-----------------------------------------------------------------
    | Get Stock By Stock Id by ajax for primary and secondary
    |-------------------------------------------------------------
    */
        $(document).on('click','.to_stock_type_id',function(){
            var stock_id        = $('.from_stock_id').val();
            var stock_type_id   = $(this).val();
            var url = $('.getStockByStockId').val();
            $.ajax({
                url: url,
                type: 'GET',
                data:{stock_id:stock_id,stock_type_id:stock_type_id},
                success: function(response){
                    $('.to_stock_id').html(response);
                },
            });
        });
    /*
    |-----------------------------------------------------------------
    | Get Stock By Stock Id by ajax for primary and secondary
    |-------------------------------------------------------------
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













