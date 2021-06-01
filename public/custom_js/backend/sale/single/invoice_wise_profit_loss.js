    /*
    |------------------------------------------------------------------
    | Final Sale Profit loss invoice
    |------------------------------------------------------------------
    */
        $(document).on('click','.viewProfitLossRepotClass',function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var url = $('.invoiceWiseProfitLoss').val();
            $.ajax({
                url: url,
                type: "GET",
                data: {
                        id:id
                    },
                success: function(response)
                {
                    $('#viewProfitLossRepotClass').html(response).modal('show');
                },
            });
        });

    /*
    |------------------------------------------------------------------
    | Final Sale Profit loss invoice
    |------------------------------------------------------------------
    */


    /*
    |------------------------------------------------------------------
    | Quotation Profit loss invoice
    |------------------------------------------------------------------
    */
        $(document).on('click','.quotationViewProfitLossRepotClass',function(ee){
            ee.preventDefault();
            var id = $(this).data('id');
            var url = $('.quotationInvoiceWiseProfitLoss').val();
            $.ajax({
                url: url,
                type: "GET",
                data: {
                        id:id
                    },
                success: function(response)
                {
                    $('#viewProfitLossRepotClass').html(response).modal('show');
                },
            });
        });
    
    /*
    |------------------------------------------------------------------
    | Quotation Profit loss invoice
    |------------------------------------------------------------------
    */

    