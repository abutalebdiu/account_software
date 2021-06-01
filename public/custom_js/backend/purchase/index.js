


    $(document).on('click', '.viewSingle', function(e)
    {
        e.preventDefault();
        var url = $('.viewSingleRoute').val();
        var id = $(this).data("id");
        $.ajax({
            url: url,
            type: "GET",
            data:{id:id},
            success: function(response){
                $('#purchaseModalShow').html(response).modal('show');
            },
        });
    });


    /**print */
    $(document).on('click', '.viewSinglePrint', function(e){
        e.preventDefault();
        var url = $('.showSinglePrint').val();
        var id  = $(this).data("id");
        $.ajax({
            url: url,
            type: "GET",
            data:{id:id},
            success: function(response){
                $.print(response);
                //$('#purchaseModalShow').html(response).modal('show');
            },
        });
    });







       //delete
    $(document).on('click','.delete_class',function(e){
            e.preventDefault();
            $('.delete_value_class').val('');
            var id = $(this).data('id');
            var invoice_no = $(this).data('invoice_no');
            $('#myDeleteModal').modal('show');
            $('.delete_value_class').val(id);
            var invoice = $(this).data('invoice_no');
            $('.show_invoice_for_delete').text(invoice);
        });
    $(document).on('click','.delete_single_data_now_class',function(e){
        e.preventDefault();
            var id = $('.delete_value_class').val();
            var url = $('.deleteSinglePurchase').val();
            $.ajax({
                url: url,
                type: "GET",
                data: {
                        id:id
                    },
                success: function(response)
                {
                    $('#myDeleteModal').modal('hide');
                    $('.delete_value_class').val('');
                    $('.alert_message').text('Deleted Successfully'); 
                    $('.alert_message').attr('class','alert-danger');
                     setTimeout(function () { 
                         $('.alert_message').alert('close'); 
                        location.reload();
                    },500); 
                },
            });
    });





    /*
    |------------------------------------------------------------------
    | payment single 
    |------------------------------------------------------------------
    */
        $(document).on('click', '.addPaymentClass', function(e)
        {
            e.preventDefault();
            var url = $('.addSinglePayment').val();
            var id = $(this).data("id");
            $.ajax({
                url: url,
                type: "GET",
                data:{id:id},
                success: function(response){
                    $('#paymentModal').html(response).modal('show');
                },
            });
        });

        $(document).on('click', '.viewPaymentClass', function(e)
        {
            e.preventDefault();
            var url = $('.viewSinglePayment').val();
            var id = $(this).data("id");
            $.ajax({
                url: url,
                type: "GET",
                data:{id:id},
                success: function(response){
                    $('#paymentModal').html(response).modal('show');
                },
            });
        });
    /*
    |------------------------------------------------------------------
    | payment single 
    |------------------------------------------------------------------
    */