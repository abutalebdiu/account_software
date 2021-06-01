



    $(document).on('click','.single_view_class',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var url = $('.saleSingleShow').val();
        $.ajax({
            url: url,
            type: "GET",
            data: {
                    id:id
                },
            success: function(response)
            {
                $('#popupSaleSingleShowModal').html(response).modal('show');
            },
        });
    });


    //delete
    $(document).on('click','.delete_class',function(e){
            e.preventDefault();
            $('.delete_value_class').val('');
            var id = $(this).data('id');
            $('#myDeleteModal').modal('show');
            $('.delete_value_class').val(id);
            var invoice = $(this).data('invoice_no');
            $('.show_invoice_for_delete').text(invoice);
        });
    $(document).on('click','.delete_single_data_now_class',function(e){
        e.preventDefault();
        var id = $('.delete_value_class').val();
        $('.delete_value_class').val(id);
        var url = $('.saleSingleDelete').val();
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
    | Quotation single view, delete and others 
    |------------------------------------------------------------------
    */
        $(document).on('click','.quotation_single_view_class',function(ee){
            ee.preventDefault();
            var id = $(this).data('id');
            var url = $('.quotationSaleSingleShow').val();
            $.ajax({
                url: url,
                type: "GET",
                data: {
                        id:id
                    },
                success: function(response)
                {
                    $('#popupSaleSingleShowModal').html(response).modal('show');
                },
            });
        });

         //delete
        $(document).on('click','.quotation_delete_class',function(e){
            e.preventDefault();
            $('.delete_value_class').val('');
            var id = $(this).data('id');
            $('#myDeleteModal').modal('show');
            $('.delete_value_class').val(id);
            var invoice = $(this).data('invoice_no');
            $('.show_invoice_for_delete').text(invoice);
        });
        $(document).on('click','.quotation_delete_single_data_now_class',function(e){
            e.preventDefault();
            var id = $('.delete_value_class').val();
            $('.delete_value_class').val(id);
            var url = $('.quotationSaleSingleDelete').val();
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
    | Quotation single view, delete and others 
    |------------------------------------------------------------------
    */






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






















