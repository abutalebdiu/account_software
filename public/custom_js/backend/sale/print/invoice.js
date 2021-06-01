

    /*        
         $(document).ready(function(){
            $('.btnPrint').printPage();
        });

        $(document).on('click','.btnPrint',function(e){
            $('.btnPrint').printPage();
        });
    */


    /**print */
    $(document).on('click', '.printInvoiceClass', function(e){
        e.preventDefault();
        var url = $('.saleSingleInvoicePrint').val();
        var id  = $(this).data("id");
        $.ajax({
            url: url,
            type: "GET",
            data:{id:id},
            success: function(response){
                $.print(response);
            },
        });
    });


   /*  $(document).on('click','.printInvoiceClass',function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var url = $('.saleSingleInvoicePrint').val();
            $.ajax({
                url: url,
                type: "GET",
                data: {
                        id:id
                    },
                success: function(response)
                {
                    $.print(response);
                    //$('#popupSaleSingleShowModal').html(response).modal('show');
                     //$('#purchaseModalShow').html(response).modal('show');
                },
            });
    }); */
