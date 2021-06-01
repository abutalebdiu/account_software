
    /*
    |-------------------------------------------------------------------
    |   Delete Payment
    |-------------------------------------------------------------------
    */
        //delete
        $(document).on('click','.delete_payment',function(e){
                e.preventDefault();
                $('.delete_payment_value_class').val('');
                var payment_id          = $(this).data('id');
                var purchase_final_id   = $(this).data('purchase_final_id');
                $('#deletePaymentModal').modal('show');
                $('.delete_payment_value_class').val(payment_id);
                $('.purchase_final_id_class').val(purchase_final_id);
                var invoice = $(this).data('payment_invoice_no');
                $('.show_payment_invoice_for_delete').text(invoice);
            });

        $(document).on('click','.delete_single_payment_class',function(e){
            e.preventDefault();
                var id              = $('.delete_payment_value_class').val();
                var purchase_final_id   = $('.purchase_final_id_class').val();
                $('.delete_payment_value_class').val(id);
                var url = $('.purchaseSinglePaymentDelete').val();
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                            id:id,purchase_final_id:purchase_final_id
                        },
                    success: function(response)
                    {
                        $('#deletePaymentModal').modal('hide');
                        $('.delete_payment_value_class').val('');
                        $('.alert_message').text('Deleted Successfully'); 
                        $('.alert_message').attr('class','alert-danger');
                        setTimeout(function () { 
                            $('.alert_message').alert('close'); 
                             $('#paymentModal').html('').modal('hide');
                            //location.reload();
                        },500); 
                    },
                });
        });
    /*
    |-------------------------------------------------------------------
    |   Delete Payment
    |-------------------------------------------------------------------
    */
    // $("#paymentDiv").load(location.href+" #paymentDiv>*",""); 