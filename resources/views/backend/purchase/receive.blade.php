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
                                <input type="hidden" name="purchase_final_id" class="purchase_final_id_class" value="{{$purchase_final_id}}" />
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Chalan No</label>
                                        <input name="chalan_no" readonly value="{{ $purchase->chalan_no }}" type="text" placeholder="Chalan No" class="chalan_no_class keyup_class form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('chalan_no'))?($errors->first('chalan_no')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Reference No</label>
                                        <input name="reference_no" readonly value="{{ $purchase->reference_no }}" type="text" placeholder="Reference No" class="reference_no_class keyup_class form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('reference_no'))?($errors->first('reference_no')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Invoice No <small style="color:red">*</small></label>
                                        <input readonly value="{{ $purchase->invoice_no }}" name="invoice_no" type="text" placeholder="Invoice No" class="invoice_no_class keyup_class form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('invoice_no'))?($errors->first('invoice_no')):''}}</div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label style="display: block;" for="">Supplier / Vendor</label>
                                        <input type="text" value="{{$purchase->suppliers?$purchase->suppliers->name:NULL}}" class="form-control" readonly/>
                                        <input type="hidden" name="supplier_id"  value="{{$purchase->supplier_id}}" />
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('supplier_id'))?($errors->first('supplier_id')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Received From </label>
                                        <input  name="received_from" value="{{old('received_from')}}" type="text" class="form-control" placeholder="Received From">
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
                                                <th style="width:3%;">Sl.No</th>
                                                <th>Product Name</th>
                                                <th style="width:10%;">Purchase Unit</th>
                                                <th>Purchase Qty</th>
                                                <th>Total <br>Received  Qty</th>
                                                <th style="width:8% !important;">Receiving Qty</th>
                                                <th>Total Due Qty</th>
                                                <th>Status</th>
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
                                                <td></td>
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
                                            <a href="{{route('admin.purchase.index')}}" class="btn btn-info">Back</a>
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
    @endpush

 @endsection
