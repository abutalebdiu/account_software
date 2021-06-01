 @extends('home')
 @section('title','Products')
 @push('css')
     <style>
        input[type=checkbox], input[type=radio]
        {
            opacity: inherit;
            position: inherit;
            left: -9999px;
            z-index: 12;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled {
            cursor: pointer;
            position: unset;
        }
     </style>
 @endpush
 @section('content')
 <!-- Page Content -->
 <div class="page-content">
     <!-- Page Breadcrumb -->
     <div class="page-breadcrumbs">
         <ul class="breadcrumb">
             <li>
                 <i class="fa fa-home"></i>
                 <a href="#">Home</a>
             </li>
             <li class="active">Products</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
     
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Products</span>
                     </div>
                     <div class="widget-body" style="background-color: #fff;">
                         <form action="" method="get">
                             <div class="row">
                                 
                                 <div class="col-xs-12 col-sm-4 col-md-3">
                                     <label for="supplier">Suppliers</label>
                                     <select name="supplier_id" class="form-control">
                                            <option value="">Select Supplier</option>
                                        @foreach($supplieres as $supplier)
                                            <option  @if(isset($supplier_id)) {{ $supplier_id == $supplier->id ? 'selected' : '' }}  @endif value="{{ $supplier->id }}">{{ $supplier->id }} - {{ $supplier->name }}</option>
                                        @endforeach
                                     </select>
                                 </div>

                                 <div class="col-xs-12 col-sm-3 col-md-2">
                                      <label for="supplier">Group</label>
                                     <select name="group_id" class="form-control">
                                            <option value="">Select Group</option>
                                            @foreach($groupes as $group)
                                                <option @if(isset($group_id)) {{ $group_id == $group->id ? 'selected' : '' }}  @endif value="{{ $group->id }}"> {{ $group->name }}</option>
                                            @endforeach
                                     </select>
                                 </div>
                                 
                                 <div class="col-xs-12 col-sm-3 col-md-2">
                                      <label for="supplier">Brands</label>
                                     <select name="brand_id" class="form-control">
                                            <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option @if(isset($brand_id)) {{ $brand_id == $brand->id ? 'selected' : '' }}  @endif value="{{ $brand->id }}"> {{ $brand->name }}</option>
                                        @endforeach
                                     </select>
                                 </div>
                                 <div class="col-xs-12 col-sm-3 col-md-2">
                                      <label for="supplier">Categories</label>
                                     <select name="category_id" class="form-control">
                                            <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option  @if(isset($category_id)) {{ $category_id == $category->id ? 'selected' : '' }} @endif value="{{ $category->id }}"> {{ $category->name }}</option>
                                        @endforeach
                                     </select>
                                 </div> 

                                 <div class="col-xs-12 col-sm-3 col-md-2">
                                     
                                     <br>
                                    <button type="submit" class="btn btn-primary"> <i class="fa fa-search"> </i> Search</button>
                                 </div>


                             </div>
                        </form>
                        
                        <form action="{{ route('product_list_export') }}" method="POST">
                        @csrf
                         <div class="row" style="margin: 10px 0;">
                             <div class="col-md-6">
                                <div class="table-toolbar text-right">
                                    <button class="btn btn-primary pull-left" name="pdf"> <i class="fa fa-download"></i> PDF</button>
                                </div>
                             </div>
                             <div class="col-md-6 text-right">
                                <div class="row">
                                <div class="col-md-3 text-right"> </div>
                                    <div class="col-md-3 text-right">
                                        <a href="{{route('product.create')}}" class="btn btn-info text-right"><i class="fa fa-plus"></i> Add Product</a>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <a class="btn btn-primary productExcelFileModal">Upload Products</a> {{---- data-toggle="modal" data-target="#productExcelFileModal"---}}

                                    </div>
                                    <div class="col-md-3 text-right">
                                    <a href="#" class="btn btn-info">Item Barcode</a>
                                    </div>
                                </div>
                                {{--   <a href="{{route('product.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Add Item</a>
                                 <a href="#" class="btn btn-info">Upload Item</a>
                                 <a href="#" class="btn btn-info">Item Barcode</a>  --}}
                             </div>
                         </div>


                         <div class="table-responsive">
                             <table id="example1" class="table table-bordered table-striped table-hover">
                                 <thead>
                                     <tr>
                                        <th>
                                            <input type="checkbox" value="all" name="check_all" class="check_all_class"/>
                                        </th>
                                        <th>Action</th>
                                        <th>Sl.N</th>
                                        <th>AS Code</th>
                                        <th>Company Code</th>
                                       
                                        <th>Purchase</th>
                                        <th title="Supplier">Sup. ID</th>
                                        <th>Supplier Name</th>
                                        <th>Group Name</th>
                                        <th>Brand Name</th>
                                        
                                       
                                        
                                        <th style="color:green;">Product Name</th>
                                        <th>Product Grade</th>
                                      
                                        <th>Whole Sale</th>
                                        <th>Sale</th>
                                        <th>MRP</th>
                                        <th>Stock</th>
                                        <th>Pur. Unit</th>
                                       
                                        <th>Added By</th>
                                      
                                     </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($products as $product)
                                     <tr>
                                        <td>
                                            <input type="checkbox" name="product_id[]" value="{{ $product->id }}" class="check_single_class" id="{{$product->id}}"/>
                                        </td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <button class="btn btn-sm btn-info btn-secondary dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-cogs"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li class="dropdown-item">
                                                        <a href="{{route('product.show',$product->id)}}">View</a>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <a href="{{route('product.edit',$product->id)}}"> Edit</a>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <a href="{{route('updatePrice',$product->id)}}" >  Update Price</a>
                                                    </li>
                                                   {{--  <li class="dropdown-item">
                                                        <a id="delete" href="{{route('product.destroy',$product->id)}}" > Delete</a>
                                                    </li> --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $product->custom_code }}</td>
                                        <td>{{ $product->company_code }}</td>
                                     
                                        <td style="font-size:14px;color:#ccc">{{ number_format($product->purchase_price,2,'.','')}}</td>
                                        <td>{{$product->suppliers?$product->suppliers->id:NULL}}</td>
                                        <td>{{$product->suppliers?$product->suppliers->name:NULL}}</td>
                                        <td>{{$product->group?$product->group->name:NULL}}</td>
                                        <td>{{$product->brand?$product->brand->name:NULL}}</td>
                                        
                                        <td style="color:green;">{{$product->name}}</td>
                                        <td>{{$product->grades?$product->grades->name:NULL}}</td>
                                      
                                        <td>{{ number_format($product->whole_sale_price,2,'.','')}}</td>
                                        <td>{{ number_format($product->sale_price,2,'.','')}}</td>
                                         
                                        <td>{{ number_format($product->mrp_price,2,'.','')}}</td>
                                        <td>
                                            @if ($product->purchase_unit_id)

                                                @if ($product->mainStocks)
                                                    @php
                                                        $avl_stock  = availableStock_HH($product->purchase_unit_id,$product->mainStocks->available_stock);
                                                        //$used_stock = availableStock_HH($product->purchase_unit_id,$product->mainStocks->used_stock);
                                                    @endphp
                                                    {{ number_format($avl_stock,3) }}
                                                    @else
                                                        <span style="color:red;font-size:10px;">Not Purchase yet Now</span>
                                                    @endif
                                            @else
                                            <span style="color:white;background-color:red;font-size: 10px;">
                                                Purchase Unit Not Set
                                            </span>
                                            @endif
                                        </td>                                   
                                         <td>
                                            {{$product->purchaseUnit?$product->purchaseUnit->short_name:NULL}}
                                        </td>
                                        
                                        <td>{{$product->author->name}}</td>
                                        
                                       
                                     </tr>
                                     @endforeach
                                 </tbody>
                             </table>
                         </div>
                         </from>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- /Page Body -->
 </div>
 <!-- /Page Content -->



        <!-- Product Excel File Modal -->
        <div class="modal fade" id="productExcelFileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"></div>
        <input type="hidden" class="excel_file_uploadable_modal" value="{{route('excel_file_uploadable_modal')}}">

    @push('js')

        <script>
            $(document).on('click','.productExcelFileModal',function(e){
                 e.preventDefault();
                    var url = $('.excel_file_uploadable_modal').val();
                    $.ajax({
                    url:url,
                    //data: data,
                    datatype:"JSON",
                    beforeSend:function(){
                        //$('.loading').fadeIn();
                    },
                    success: function(response){
                        $('#productExcelFileModal').html(response).modal('show');
                    },
                    complete:function(){
                        //$('.loading').fadeOut();
                    },
                });
                //end ajax
            });
        </script>

        <script>

            //check_all_class
            //check_single_class
            $(document).on('click','.check_all_class',function(){
                if (this.checked == false)
                {
                    //28.03.2021
                    $('.bulk_assigning_partner').hide();
                    //28.03.2021

                    $('.check_single_class').prop('checked', false).change();
                    $(".check_single_class").each(function ()
                    {
                        var id = $(this).attr('id');
                        $(this).val('').change();

                    });
                }else{
                    //28.03.2021
                    $('.bulk_assigning_partner').show();
                    //28.03.2021

                    $('.check_single_class').prop("checked", true).change();

                    $(".check_single_class").each(function ()
                    {
                        var id = $(this).attr('id');
                        $(this).val(id).change();
                    });
                }
            });
                //=======================
            $(document).on('click','.check_single_class',function(){
                //28.03.2021
                var $b = $('input[type=checkbox]');
                if($b.filter(':checked').length <= 0)
                {
                    $('.bulk_assigning_partner').hide();
                }
                //28.03.2021

                var id = $(this).attr('id');
                if (this.checked == false)
                {
                    $(this).prop('checked', false).change();
                    $(this).val('').change();
                }else{
                    //28.03.2021
                    $('.bulk_assigning_partner').show();
                    //28.03.2021
                    $(this).prop("checked", true).change();
                    $(this).val(id).change();
                }
                //=======================
            });


        </script>

    @endpush

 @endsection
