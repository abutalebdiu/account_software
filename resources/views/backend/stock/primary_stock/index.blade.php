@extends('home')
@section('title','Showroom Stock')
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
            <li class="active">Showroom Stock</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">

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
    <!-- Page Body -->
    <div class="page-body">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="widget">
                    <div class="widget-header bg-info">
                        <span class="widget-caption" style="font-size: 20px">Showroom Stock</span>
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
                    <div class="widget-body" style="background-color: #fff;">
                        <div class="table-toolbar">
                            <div class="row">
                                <form>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select name="stock_id" class="form-control">
                                                    @foreach ($stockTypies as $item)
                                                    <option {{$stock_id==$item->id ?'selected':''}}
                                                        value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-md btn-primary" value="Search" />
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <a href="{{route('admin.primary-stock.index')}}" class="btn btn-info">Back</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        <form action="{{ route('admin.primary_stock_pdf_list') }}" method="get">                   
                            <div class="row" style="margin: 30px 0;margin-top:0px;">
                                <div class="col-md-6">
                                    <div class="table-toolbar text-right">
                                        <button class="btn btn-primary pull-left" name="pdf"> <i class="fa fa-download"></i> PDF</button>
                                    </div>
                                </div>
                            </div>
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" value="all" name="check_all" class="check_all_class"/>
                                    </th>
                                    <th>SN</th>
                                    <th>Product Name</th>
                                    <th>Purchase Unit</th>
                                    <th>Abailable Stock</th>
                                    <th>Used Stock</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stocks as $stock)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="stock_id[]" value="{{ $stock->id }}" class="check_single_class" id="{{$stock->id}}"/>
                                    </td>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        {{$stock->productVariations?$stock->productVariations->products?$stock->productVariations->products->name:NULL:NULL}}
                                        {{$stock->productVariations?$stock->productVariations->sizes?" (".$stock->productVariations->sizes->name .") ":NULL:NULL}}
                                        {{$stock->productVariations?$stock->productVariations->colors?" (".$stock->productVariations->colors->name .") ":NULL:NULL}}
                                        {{$stock->productVariations?$stock->productVariations->weights?" (".$stock->productVariations->weights->name .") ":NULL:NULL}}
                                    </td>
                                    <td> 
                                        {{$stock->productVariations?$stock->productVariations->defaultPurchaseUnits?$stock->productVariations->defaultPurchaseUnits->short_name:NULL:NULL}}
                                    </td>

                                    <td>
                                        {{--
                                            {{$stock->productVariations?$stock->productVariations->defaultPurchaseUnits?$stock->productVariations->defaultPurchaseUnits->calculation_result:NULL:NULL}}
                                        {{$stock->available_stock}}
                                        --}}
                                        @if ($stock->productVariations?$stock->productVariations->defaultPurchaseUnits?$stock->productVariations->default_purchase_unit_id:NULL:NULL)
                                            @php
                                            $avl_stock =
                                            availableStock_HH($stock->productVariations?$stock->productVariations->defaultPurchaseUnits?$stock->productVariations->default_purchase_unit_id:NULL:NULL,$stock->available_stock);
                                            $used_stock =
                                            availableStock_HH($stock->productVariations?$stock->productVariations->defaultPurchaseUnits?$stock->productVariations->default_purchase_unit_id:NULL:NULL,$stock->used_stock);
                                            @endphp
                                            {{ number_format($avl_stock,3) }}

                                            @else
                                            <span style="color:white;background-color:red;font-size: 10px;">
                                                Purchase Unit Not Set
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{--  {{$stock->used_stock?$stock->used_stock:0.0}} --}}
                                        @if ($stock->productVariations?$stock->productVariations->defaultPurchaseUnits?$stock->productVariations->default_purchase_unit_id:NULL:NULL)
                                            {{ number_format($used_stock,3) }}
                                        @endif
                                    </td>
                                    <td>
                                        {{$stock->stocks?$stock->stocks->name:NULL}}
                                    </td>
                                    <td>
                                        <a data-id="{{$stock->id}}" data-stock_type_id="{{$stock->stock_type_id}}"
                                          data-stock_id="{{$stock->stock_id}}"  class="transferForm btn btn-info btn-xs edit"><i class="fa fa-edit"></i>
                                            Transfer
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfooter>
                                <tr>
                                    <th></th>
                                    <th>SN</th>
                                    <th>Product Name</th>
                                    <th>Purchase Unit</th>
                                    <th>Abailable Stock</th>
                                    <th>Used Stock</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </tfooter>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Body -->
</div>
<!-- /Page Content -->


    <!--- Transfer modal show--->
    <div class="modal fade" id="transfer_modal_show" role="dialog" aria-hidden="true"></div>
    <!--- Transfer modal show--->

    <input type="hidden" value="{{route('admin.stockTransferModal')}}" class="transform_from_primary_stock" />
    <input type="hidden" value="{{route('admin.stock.transfer.getStockByStockId')}}" class="getStockByStockId" />


    @push('js')
        
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
@push('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
</script>
<script src="{{ asset('public') }}/custom_js/backend/stock/stock_transfer.js?v=1"></script>
@endpush
@endsection
