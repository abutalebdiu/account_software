@extends('home')
@section('title','Receiving Purchase Product')
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
            <li class="active">Receiving Purchase Product</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">
            <h1>
                Receiving Purchase Product
            </h1>
        </div>
        <!--Header Buttons-->
        <div class="header-buttons">
            <a class="sidebar-toggler" href="#">
                <i class="fa fa-arrows-h"></i>
            </a>
            <a class="refresh" id="refresh-toggler" href="default.htm">
                <i class="glyphicon glyphicon-refresh"></i>
            </a>
            <a class="fullscreen" id="fullscreen-toggler" href="#">
                <i class="glyphicon glyphicon-fullscreen"></i>
            </a>
        </div>
        <!--Header Buttons End-->
    </div>
    <!-- /Page Header -->

    @if (session()->has('success'))
    <div class="alert alert-success">
        @if(is_array(session('success')))
            <ul>
                @foreach (session('success') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @else
            {{ session('success') }}
        @endif
    </div>
    @endif
    @if (session()->has('error'))
    <div class="alert alert-danger">
        @if(is_array(session('error')))
            <ul>
                @foreach (session('error') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @else
            {{ session('error') }}
        @endif
    </div>
    @endif


    <!-- Page Body -->
    <div class="page-body">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="widget">
                    <div class="widget-header bg-info">
                        <span class="widget-caption" style="font-size: 20px">Receiving Purchase Product</span>
                        <div class="widget-buttons">
                            <a href="#" data-toggle="maximize">
                                <i class="fa fa-expand"></i>
                            </a>
                            <a href="#" data-toggle="collapse">
                                <i class="fa fa-minus"></i>
                            </a>
                            <a href="#" data-toggle="dispose">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <form action="{{route('admin.purchase.product.receive.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Chalan No</label>
                                        <input name="chalan_no" value="{{old('chalan_no')}}" type="text" placeholder="Chalan No" class="chalan_no_class keyup_class form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('chalan_no'))?($errors->first('chalan_no')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Reference No</label>
                                        <input name="reference_no" value="{{old('reference_no')}}" type="text" placeholder="Reference No" class="reference_no_class keyup_class form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('reference_no'))?($errors->first('reference_no')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Invoice No <small style="color:red">*</small></label>
                                        <input value="{{old('invoice_no')}}" name="invoice_no" type="text" placeholder="Invoice No" class="invoice_no_class keyup_class form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('invoice_no'))?($errors->first('invoice_no')):''}}</div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="display: block;" for="">Supplier / Vendor</label>
                                        <select id="supplier_id" name="supplier_id" class="supplier_id_class form-control select2">
                                            <option value="">Select Supplier/Vendor</option>
                                            @foreach ($suppliers as $item)
                                                <option {{old('supplier_id') == $item->id ?'selected':''}} value="{{$item->id}}">{{$item->name}} - ({{$item->phone}}) - ({{$item->email}})</option>
                                            @endforeach
                                        </select>
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('supplier_id'))?($errors->first('supplier_id')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Received From </label>
                                        <input name="received_from" value="{{old('received_from')}}" type="text" class="form-control" placeholder="Received From">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('received_from'))?($errors->first('received_from')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Received Invoice/Chalan/Reference No </label>
                                        <input value="{{old('received_invo_cln_ref_no')}}" name="received_invo_cln_ref_no" type="text" class="form-control" placeholder="Received Invoice/Chalan/Reference No">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('received_from'))?($errors->first('received_invo_cln_ref_no')):''}}</div>
                                    </div>
                                </div>


                                <div class="col-sm-12 col-md-12">
                                    <br/>
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <table  class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Product Name</th>
                                                <th>Ordered Unit</th>
                                                <th>Ordered Qty</th>
                                                <th>Total <br>Received  Qty</th>
                                                <th>Receiving Qty</th>
                                                <th>Tota Due Qty</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                        <tbody id="showResult">

                                        </tbody>
                                            <tr>
                                                <td colspan="3" style="text-align:right">Total</td>
                                                <td><strong id="orderTotalQtyId">0</strong></td>
                                                <td><strong id="orderPreviousRecQtyId">0</strong></td>
                                                <td style="width:15%;">
                                                    <strong id="orderReceivingNowQtyId">0</strong>
                                                </td>
                                                <td><strong id="orderDueNowQtyId">0</strong></td>
                                                <td style="width:5%;">
                                                    <a href="#" id="clearAllPurchaseReceiveProductCart"  style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;color:red;">
                                                        Clear
                                                    </a>
                                                </td>
                                            </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                    <br/>
                            </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="submit" value="Submit" id="submitButton" disabled class="btn btn-primary">
                                            <a href="#" class="btn btn-info">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Body -->
    </div>
    <!-- /Page Content -->







    <!---all ajax route here--->
        <input type="hidden" id="purchaseProductReceiveCartIfExist" value="{{route('admin.purchase.product.receive.purchaseProductReceiveCartIfExist')}}" />
        <input type="hidden" id="searchAndAddToCart" value="{{route('admin.purchase.product.receive.searchAndAddToCart')}}" />
        <input type="hidden" id="updatePurchaseReceiveAddToCart" value="{{route('admin.purchase.product.receive.updatePurchaseReceiveAddToCart')}}" />
        <input type="hidden" id="removeAllpurchaseProductReceiveCart" value="{{route('admin.purchase.product.receive.removeAllpurchaseProductReceiveCart')}}" />
        <input type="hidden" id="removeReceivePurchaseProductSingleCart" value="{{route('admin.purchase.product.receive.removeSinglepurchaseProductReceiveCart')}}" />
    <!---all ajax route here--->


    @push('js')
        <!-----for Ajax handeling----->
        <script type="text/javascript">
            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
        </script>
        <!-----for Ajax handeling----->
  <script src="{{ asset('public') }}/custom_js/backend/receive_purchase_product/create.js?v=1"></script>



    {{--      <script>
            $(document).ready(function(){

                //=========================== Add Supplier==============================
                        $('#addSupplier').on("submit",function(e){
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
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#supplier_id").html(html);
                                                $('#supplierModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#supplier_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }else{
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                complete:function(){
                                    //$('.loading').fadeOut();
                                    console.log('complete');
                                },
                        });
                        //end ajax
                        });
                //=========================== Add Supplier==============================


                //=========================== Add Category==============================
                    $('#addCategory').on("submit",function(ee){
                        ee.preventDefault();

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
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#category_id").html(html);
                                                $('#categoryModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#category_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }else{
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                complete:function(){
                                    //$('.loading').fadeOut();
                                    console.log('complete');
                                },
                        });
                        //end ajax
                    });
                //=========================== Add Category==============================


                //=========================== Add Brand==============================
                    $('#addBrand').on("submit",function(ee){
                        ee.preventDefault();

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
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#brand_id").html(html);
                                                $('#addBrandModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#brand_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }else{
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                complete:function(){
                                    //$('.loading').fadeOut();
                                    console.log('complete');
                                },
                        });
                        //end ajax
                    });
                //=========================== Add Brand==============================


                //=========================== Add Unit==============================
                    $('#addPurchaseUnit').on("submit",function(ee){
                        ee.preventDefault();

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
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].short_name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#purchase_unit_id").html(html);
                                                $('#addPurchaseUnitModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#purchase_unit_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }
                                        else  if(response.status == 'errors')
                                        {
                                            console.log('ekhanne');
                                             console.log(response['data']);
                                            var leng = 0;
                                            if(response['data'] != null){
                                                leng = response['data'].length;
                                            }

                                            if(leng > 0){
                                                // Read data and create <option >
                                                for(var i=0; i<leng; i++){
                                                    //var id = response['data'][i].id;
                                                    //var name = response['data'][i].name;
                                                    console.log('leng');
                                                    $("#name_0").text('dkfj');
                                                    //$("#name_"+i).text(response['data'][i].name);
                                                }

                                            }
                                        }
                                        else{
                                            console.log('nai');
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                 error: function (reject) {
                                    if( reject.status === 422 ) {
                                        var errors = $.parseJSON(reject.responseText);
                                        $.each(errors, function (key, val) {
                                            $("#" + key + "_error").text(val[0]);
                                        });
                                    }
                                },
                                complete:function(reject){

                                    if( reject.status === 'errors' ) {
                                        console.log('eee');
                                        var errors = $.parseJSON(reject.responseText);
                                        $.each(errors, function (key, val) {
                                            $("#name_"+key).text(val[0]);
                                        });
                                    }


                                    //$('.loading').fadeOut();
                                    console.log('complete');
                                },
                        });
                        //end ajax
                    });
                //=========================== Add Unit==============================
            });
        </script>  --}}
    @endpush

 @endsection
