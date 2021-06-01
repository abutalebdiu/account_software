    /*
    |-----------------------------------------------------
    | All document bind by on Method is predefined here
    |----------------------------------------------
    */
        $(document).ready(function(){
            searchingAndMakingAddToCart();
        });
        /*search and add to cart*/
            var ctrlDown = false,
            ctrlKey = 17,
            cmdKey = 91,
            vKey = 86,
            cKey = 67;
            $(document).on('keyup change','.keyup_class,.supplier_id_class',function(e){
                e.preventDefault();
                if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
                if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey)) return false;
                searchingAndMakingAddToCart();
            });
        /*search and add to cart End*/


        /*Remove Single Cart*/
            $(document).on('click','.removeReceivePurchaseProductSingleCart',function(e){
                e.preventDefault();
                removeReceivePurchaseProductSingleCart($(this).data('id'));
            });
        /*Remove Single Cart End*/


        /*Remove All Add to Cart*/
            $(document).on('click','#clearAllPurchaseReceiveProductCart',function(e){
                e.preventDefault();
                removeReceiveAllPurchaseProductCart();
            });
        /*Remove All Add to Cart End*/


        /*Final Calcuation get and set*/
            $(document).on('keyup','.receiving_qty_id_class',function(e){
                e.preventDefault();
                calculatingFinal($(this).data('product_variation_id'));
                totalFinalSumResultSet();
            });
        /*Final Calcuation get and set End*/


        /*Update Cart for single */
        $(document).on('blur','.receiving_qty_id_class',function(){
            updateAddToCart($(this).data('product_variation_id'));
        });
        /*Update Cart for single */
    /*
    |-----------------------------------------------------
    | All document bind by on Method is predefined here
    |-----------------------------------------------------------
    */



    /*
    |-----------------------------------------------------
    | Searching and Making Add to cart
    |---------------------------------------
    */
        function updateAddToCart(product_variation_id)
        {
            var receivingQty                =   nanCheck(parseFloat($('#receiving_qty_id_'+product_variation_id).val()));
            var totalOrderQuantity          =   nanCheck(parseFloat(totalOrderQty(product_variation_id)));
            var totalOrderReceivedQuantity  =   nanCheck(parseFloat(totalReceivedQtyOfThisOrder(product_variation_id)));
            var totalDueQty                  =   nanCheck(parseFloat($('#set_due_qty_id_'+product_variation_id).val()));
            //console.log(totalOrderQuantity +" -- "+ totalOrderReceivedQuantity+" - "+ receivingQty + " - "+ toalDueQty);
            var url = $('#updatePurchaseReceiveAddToCart').val();
            setTimeout(function (){
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {product_variation_id:product_variation_id,receivingQty:receivingQty,totalOrderQuantity:totalOrderQuantity,totalOrderReceivedQuantity:totalOrderReceivedQuantity,totalDueQty:totalDueQty},
                    success: function(response)
                    {
                        $('#showResult').html(response);
                        totalFinalSumResultSet();
                    },
                });
            }, 400)
        }
    /*
    |------------------------------------
    | Searching and Making Add to cart End
    |--------------------------------------------------------
    */


    /*
    |-----------------------------------------------------
    | Searching and Making Add to cart
    |---------------------------------------
    */
        function searchingAndMakingAddToCart()
        {
            var purchase_final_id =  $('.purchase_final_id_class').val();
            var chalan_no       =  $('.chalan_no_class').val();
            var reference_no    =  $('.reference_no_class').val();
            var invoice_no      =  $('.invoice_no_class').val();
            var supplier_id     =  $('.supplier_id_class').val();
            var url = $('#searchAndAddToCart').val();
            if(chalan_no.length > 2 || reference_no.length > 2 || invoice_no.length > 2 || supplier_id)
            {
                setTimeout(function (){
                    $.ajax({
                        url: url,
                        type: "GET",
                        data: {chalan_no:chalan_no,reference_no:reference_no,
                            invoice_no:invoice_no,supplier_id:supplier_id,
                            purchase_final_id:purchase_final_id
                        },
                        success: function(response)
                        {
                            //console.log(response);
                            $('#showResult').html(response);
                            totalFinalSumResultSet();
                        },
                    });
                }, 700)
            }
        }
    /*
    |------------------------------------
    | Searching and Making Add to cart End
    |--------------------------------------------------------
    */




    /*
    |------------------------------------------------------
    | Receive Purchaes Product single cart remove
    |------------------------------------------
    */
        function removeReceivePurchaseProductSingleCart(product_variation_id)
        {
            var url   = $('#removeReceivePurchaseProductSingleCart').val();
            $.ajax({
                url: url,
                type: "GET",
                data:{product_variation_id:product_variation_id},
                //datatype:"JSON",
                beforeSend:function(){
                    //$('.loading').fadeIn();
                },
                success: function(response){
                    $('#showResult').html(response);
                    totalFinalSumResultSet();
                },
                complete:function(){
                    //$('.loading').fadeOut();
                },
            });
        }
    /*
    |----------------------------------------------
    | Receive Purchaes Product single cart remove
    |---------------------------------------------------------
    */



    /*
    |------------------------------------------------------
    | Receive Purchaes Product All cart remove
    |------------------------------------------
    */
        function removeReceiveAllPurchaseProductCart()
        {
            var url   = $('#removeAllpurchaseProductReceiveCart').val();
            $.ajax({
                url: url,
                type: "GET",
                //datatype:"JSON",
                beforeSend:function(){
                    //$('.loading').fadeIn();
                },
                success: function(response){
                    $('#showResult').html(response);
                    totalFinalSumResultSet();
                },
                complete:function(){
                    //$('.loading').fadeOut();
                },
            });
        }
    /*
    |----------------------------------------------
    | Receive Purchaes Product All cart remove
    |---------------------------------------------------------
    */




    /*
    |----------------------------------------------------------------------
    | If Cart is Exist
    |--------------------------------------------------------
    */
        $(document).ready(function(){
            var url = $('#purchaseProductReceiveCartIfExist').val();
            $.ajax({
                    url: url,
                    type: "GET",
                    //data:{stock_type_id:stock_type_id},
                    datatype:"JSON",
                    beforeSend:function(){
                        //$('.loading').fadeIn();
                    },
                    success: function(response){
                        $('#showResult').html(response);
                        totalFinalSumResultSet();
                    },
                    complete:function(){
                        //$('.loading').fadeOut();
                    },
                });
        });
    /*
    |-------------------------------------------------------
    | If Cart is Exist
    |-----------------------------------------------------------------------
    */

    /*
    |-------------------------------------------------------------------------
    | Final calculation and total sum result set here
    |----------------------------------------------------------
    */
        function  calculatingFinal(product_variation_id)
        {
            var receivingQty                =   nanCheck(parseFloat($('#receiving_qty_id_'+product_variation_id).val()));
            var totalOrderQuantity          =   nanCheck(parseFloat(totalOrderQty(product_variation_id)));
            var totalOrderReceivedQuantity  =   nanCheck(parseFloat(totalReceivedQtyOfThisOrder(product_variation_id)));

            /* previous due if smallest from current receiving qty */
            var previousDue = totalOrderQuantity - totalOrderReceivedQuantity;
            if(receivingQty > previousDue)
            {
                receivingQty = previousDue;
                $('#receiving_qty_id_'+product_variation_id).val(receivingQty);
            }
            /* previous due if smallest from current receiving qty */

            var totalRecevedNow = totalOrderReceivedQuantity + receivingQty ;
            var totalDueQty = totalOrderQuantity - totalRecevedNow ;
            //console.log(totalOrderQuantity +" - "+totalOrderReceivedQuantity+" -due- "+ totalDueQty);

            $('#set_due_qty_id_'+product_variation_id).val(totalDueQty.toFixed(2));//
        }
        function totalOrderQty(product_variation_id)
        {
            return $('#get_total_order_qty_id_'+product_variation_id).val();
        }
        function totalReceivedQtyOfThisOrder(product_variation_id)
        {
            return $('#get_total_received_qty_id_'+product_variation_id).val();
        }

        /*This Functon is called many place */
        function totalFinalSumResultSet()
        {
            $('#orderTotalQtyId').text(totalOrderQtySum().toFixed(2));
            $('#orderPreviousRecQtyId').text(totalReceivedPreviousQtySum().toFixed(2));
            $('#orderReceivingNowQtyId').text(totalNowReceivingQtySum().toFixed(2));
            $('#orderDueNowQtyId').text(totalNowDueQtySum().toFixed(2));

            $('#submitButton').attr('disabled','disabled');
            if(totalNowReceivingQtySum().toFixed(2) >0)
            {
                $('#submitButton').removeAttr('disabled','disabled');
            }
        }
         /*This Functon is called many place */
        function totalOrderQtySum()
        {
            var sum = 0;
            $('.total_order_qty_class').each(function() {
                sum += nanCheck(parseFloat($(this).val()));
            });
            return sum;
        }
        function totalReceivedPreviousQtySum()
        {
            var sum = 0;
            $('.total_order_received_before_qty_class').each(function() {
                sum += nanCheck(parseFloat($(this).val()));
            });
            return sum;
        }
        function totalNowReceivingQtySum()
        {
            var sum = 0;
            $('.total_receiving_qty_class').each(function() {
                sum += nanCheck(parseFloat($(this).val()));
            });
            return sum;
        }

        function totalNowDueQtySum()
        {
            var sum = 0;
            $('.total_current_due_qty_class').each(function() {
                sum += nanCheck(parseFloat($(this).val()));
            });
            return sum;
        }
    /*
    |-------------------------------------------------------
    | Final calculation and total sum result set here end
    |-----------------------------------------------------------------------
    */




    /*
    |-----------------------------------------------------
    |  Number and Decimal check and Protection
    |----------------------------------------------
    */
        $(document).on('keypress','.receiving_qty_id_class',function(e){
            return isNumber(e, this);
        });

        //function of Number and Decimal check
        function isNumber(evt, element)
        {
            //return isNumber(event, this);//call
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (
                (charCode != 45 || $(element).val().indexOf('-') != -1) &&      // Check minus and only once.
                (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // Check dot and only once.
                (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    /*
    |----------------------------------------------
    | Number and Decimal check and Protection END ]
    |---------------------------------------------------------
    */




    /*
    |-----------------------------------------------------------------
    | get Value From Select Option and Radio Button by calss
    |---------------------------------------------------------------
    */
        function getValueFromSelectOption(className)
        {
            return $('.'+className).val();
        }
        function getValueFromInputField(className)
        {
            return $('.'+className).val();
        }
        function getValueFromInputFieldByID(IdName)
        {
            return $('#'+IdName).val();
        }

        function getValueFromRadioButton(className)
        {
            return $('.'+className+':checked').val();
            //return  $('.gold_color:checked').val();
            //console.log($('.parcel_type_id_class:checked').val());
        }
    /*
    |-------------------------------------------------------------
    | get Value From Select Option and Radio Button by calss  End
    |-------------------------------------------------------------------
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












