    /*
    |----------------------------------------------------------------------------------
    | Default Product list show here
    |------------------------------------------------------
    */
        $(document).ready(function(){
            var url = $('.productListByAjax').val();
            var cat_id = "all";
            var pNameSkuBarCodeAsCodeCCode = "";
            $.ajax({
                    url: url,
                    type: "GET",
                data: {cat_id:cat_id,pNameSkuBarCodeAsCodeCCode:pNameSkuBarCodeAsCodeCCode},
                    success: function(response)
                    {
                        $('.product_list').html(response.data);
                        $('.p_name_sku_bar_code_class').focus();
                    },
                });
        });
    /*
    |-------------------------------------------------
    | Default Product list show here
    |-------------------------------------------------------------------------------------
    */



    /*  var page = 1;
	 $(window).scroll(function() {
         var hightFromTop = $(window).scrollTop();
       var h =  $(document).height();
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
             page++;
             //loadMoreData(page);
        }
	 }); */

    /*
    |----------------------------------------------------------------------------------
    | Make Pagination here
    |---------------------------------------------------------
    */
        $(document).on('click','.product_pagination .pagination li a',function(e){
            e.preventDefault();
            var page = $(this).attr('href');
            var pageNumber = 1;
            if(page)
            {
                pageNumber = page.split('?page=')[1];
            }
            var cat_id = $('.category_selected_value').val();
            var pNameSkuBarCodeAsCodeCCode = $('.p_name_sku_bar_code_ccode_ascode_class').val();
            loadMoreData(pageNumber ,cat_id,pNameSkuBarCodeAsCodeCCode)
        });

        
        function loadMoreData(pageNumber ,cat_id,pNameSkuBarCodeAsCodeCCode)
        {
            var url = $('.productListByAjax').val();
            
            var newUrl = url + '?page=' + pageNumber+"&cat_id="+cat_id+"&pNameSkuBarCodeAsCodeCCode="+pNameSkuBarCodeAsCodeCCode;
            $.ajax({
                // url: '?page=' + page,
                url: newUrl,
                type: "get",
                //data: {cat_id:cat_id},
                beforeSend: function()
                {
                    //$('.ajax-load').show();
                },
                success:function(response)
                {
                    //$('.ajax-load').hide();
                    $(".product_list").html(response.data);
                },
            });
        }
    /*
    |-------------------------------------------------
    | Make Pagination here
    |-------------------------------------------------------------------------------------
    */



    /*
    |----------------------------------------------------------------------------------
    | Product Get By Category id
    |----------------------------------------------------
    */
        $(document).on('click','.productByCategory',function(e){
            e.preventDefault();
            var cat_id = $(this).data('id');
            //var url = $('.productListByAjax').val();
            var page = $(this).attr('href');
            var pageNumber = 1;
            
            if(page)
            {
                pageNumber = page.split('?page=')[1];
            }
            var pNameSkuBarCodeAsCodeCCode = $('.p_name_sku_bar_code_ccode_ascode_class').val();
            loadMoreData(pageNumber ,cat_id,pNameSkuBarCodeAsCodeCCode)
            
            /* 
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {cat_id:cat_id},
                    success: function(response)
                    {
                        $('.product_list').html(response.data);
                        $('.p_name_sku_bar_code_class').focus();
                    },
                }); 
            */
        });
    /*
    |-------------------------------------------------
    | Product Get By Category id
    |-------------------------------------------------------------------------------------
    */



    /*
    |---------------------------------------------------------------------------------
    | Product Search by p name, sku bar code as code, 
    |-----------------------------------------------------
    */
    $(document).on('keyup','.p_name_sku_bar_code_ccode_ascode_class',function(){
        var pNameSkuBarCodeAsCodeCCode = $(this).val();
        var page = $('.product_pagination .pagination li a').attr('href');
        var pageNumber = 1 ;
        if(page)
        {
            pageNumber = page.split('?page=')[1];
        } 
        var cat_id = $('.category_selected_value').val();
        loadMoreData(pageNumber ,cat_id,pNameSkuBarCodeAsCodeCCode)

       // var url = $('.productListByAjax').val();
        /* 
            $.ajax({
                url: url,
                type: "GET",
                data: {cat_id:cat_id},
                success: function(response)
                {
                    $('.product_list').html(response.data);
                    $('.p_name_sku_bar_code_class').focus();
                },
            }); 
        */
    });
    /*
    |-------------------------------------------------
    | Product Search by p name, sku bar code as code, 
    |-------------------------------------------------------------------------------------
    */