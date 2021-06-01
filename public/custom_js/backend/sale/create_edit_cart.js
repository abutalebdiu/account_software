

    /*
    |------------------------------------------------------------------------------------
    |  Making Add To Cart
    |--------------------------------------------------
    */
        $(document).on("submit",'#addToCartWhenSubmitingEditFromModal',function(e)
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























