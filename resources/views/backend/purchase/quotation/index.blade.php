@extends('home')
@section('title','Purchase Quotation List')
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
            <li class="active"> Purchase Quotation List</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">
            <h1>
                Purchase Quotation List
            </h1>
        </div>
        <!--Header Buttons-->
        <div class="header-buttons">
            <a class="sidebar-toggler" href="#">
                <i class="fa fa-arrows-h"></i>
            </a>
            <a class="refresh" id="refresh-toggler" href="#">
                <i class="glyphicon glyphicon-refresh"></i>
            </a>
            <a class="fullscreen" id="fullscreen-toggler" href="#">
                <i class="glyphicon glyphicon-fullscreen"></i>
            </a>
        </div>
        <!--Header Buttons End-->
    </div>
    <!-- /Page Header -->


                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif


    <!-- Page Body -->
    <div class="page-body">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="widget">
                    <div class="widget-header bg-info">
                        <span class="widget-caption" style="font-size: 20px">Purchase Quotation List</span>
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
                    <!-- Showing alert -->
                        <div class="alert_message" style="padding:10px 0px 10px 10px;"> </div>

                        <div class="row" style="margin: 30px 0;">
                            <div class="col-md-6">
                                <form action="" method="get">
                                     <div class="row">
                                          <div class="col-xs-12 col-sm-8 col-md-8">
                                             <label for="supplier">Suppliers</label>
                                             <select name="supplier_id select2" id="" class="form-control">
                                                    <option value="">Select Supplier</option>
                                                @foreach($supplieres as $supplier)
                                                    <option  @if(isset($supplier_id)) {{ $supplier_id == $supplier->id ? 'selected' : '' }}  @endif value="{{ $supplier->id }}">{{ $supplier->id }} - {{ $supplier->name }}</option>
                                                @endforeach
                                             </select>
                                         </div>
         
                                         <div class="col-xs-12 col-sm-4 col-md-4">
                                             
                                             <br>
                                            <button type="submit" class="btn btn-primary"> <i class="fa fa-search"> </i> Search</button>
                                         </div>


                                     </div>
                                </form>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{route('admin.purchase.create')}}" class="btn btn-info"><i class="fa fa-plus"></i>
                                    Create Purchase
                                </a>
                                <a href="{{route('admin.purchase.quotation.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>
                                    Quotation Create
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">

                     




                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Action</th>
                                        <th>Final Purchase</th>
                                        <th>Reference No</th>
                                        <th>Invoice No</th>
                                        <th>Date (Time)</th>
                                        <th>Supplier</th>
                                        <th>G.Total</th>
                                        <th>Added By</th>
                                        <th>Total <br/>Item</th>
                                    </tr>
                                </thead>
                                    @php
                                    $totalAmount = 0;
                                    $paidTotalAmount = 0;
                                    $dueTotalAmount = 0;
                                    $totalItem  = 0;
                                    @endphp
                                <tbody>
                                    @foreach ($purchases as $key=> $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>
                                                <div class="btn-group dropdown">
                                                    <button class="btn btn-sm btn-primary btn-secondary dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li class="dropdown-item">
                                                            <a class="viewSingle" href="#" data-id="{{$item->id}}">
                                                                View
                                                            </a>
                                                        </li>
                                                        <li class="dropdown-item">
                                                            <a  href="{{ route('admin.purchase.quotation.edit', $item->id) }}">Purchase Final </a>
                                                        </li>
                                                        {{--   <li class="dropdown-item"><a  href="{{ route('admin.purchase.duplicate', $item->id) }}">Duplicate Purchase</a></li>  --}}
                                                        <li class="dropdown-item">
                                                            <a class="" href="{{route('admin.purchase.quotation.destroy',$item->id)}}" onclick="return confirm('Are you sure you want to delete this item?');">
                                                                Delete {{--data-id="{{$item->id}}" data-invoice_no="{{$item->invoice_no}}"--}}
                                                            </a>
                                                        </li>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-sm" href="{{ route('admin.purchase.quotation.edit', $item->id) }}" >
                                                    Purchase Final
                                                </a>
                                            </td>
                                            <td>
                                                <a class="viewSingle" href="#" data-id="{{$item->id}}">
                                                    {{$item->reference_no}}
                                                </a>
                                            </td>
                                            <td>
                                                <a class="viewSingle" href="#" data-id="{{$item->id}}">
                                                    {{$item->invoice_no}}
                                                </a>
                                            </td>
                                            <td>
                                                {{date('d-m-Y',strtotime($item->purchaes_date))}}
                                            </td>
                                            <td>{{$item->suppliers?$item->suppliers->name:NULL}}</td>

                                            <td>
                                                @php
                                                $totalAmount        += $item->totalPurchaseAmount();
                                                $paidTotalAmount    += $item->totalPaidAmount();
                                                $dueTotalAmount     += $item->totalDueAmount();
                                                $totalItem          += $item->totalPurchaseItem();
                                                @endphp
                                               ৳ {{ number_format($item->totalPurchaseAmount(),2,'.','') }}
                                            </td>
                                            <td>
                                                {{$item->createdBy?$item->createdBy->name:"No"}}
                                            </td>
                                            <td>
                                                {{number_format($item->totalPurchaseItem(),2,'.','')}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="background-color:#427fed;color:#fff;">
                                        <td colspan="7" style="text-align:right"><strong>Total</strong></td>
                                        <td style="font-size:14px">৳ <strong>{{number_format($totalAmount,2,'.','')}}</strong></td>
                                        <td></td>
                                        <td style="font-size:14px"><strong>{{number_format($totalItem,2,'.','') }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Body -->
</div>
<!-- /Page Content -->

{{-- Modal for Purchase Show --}}


    <!--Show Purchase Modal -->
    <div class="modal fade" id="purchaseModalShow" tabindex="-1" role="dialog" aria-hidden="true"></div>
    <input type="hidden" value="{{ route('admin.showSingle') }}" class="viewSingleRoute" />
    <input type="hidden" value="{{ route('admin.showSinglePrint') }}" class="showSinglePrint" />



    <!---delete modal---->
        <!-- delete sale -->
    <input type="hidden" value="{{route('admin.deleteSinglePurchase')}}" class="deleteSinglePurchase"/>
    <div class="modal" id="myDeleteModal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Delete Invoice No : <strong class="show_invoice_for_delete"></strong></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                    Are you Sure, Want to Delete This?
            </div>
            <input type="hidden" value="" class="delete_value_class" />
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <a href="#" class="btn btn-primary delete_single_data_now_class" >Yes</a>
            </div>

            </div>
        </div>

    </div>
    <!---delete modal---->



    <!---delete Payment modal---->
    <div class="modal" id="deletePaymentModal" style="  z-index: 1051 !important;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Delete Invoice No : <strong class="show_payment_invoice_for_delete"></strong></h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <div class="modal-body">
                        Are you Sure, Want to Delete This?
                        <!-- delete sale -->
                        <input type="hidden" value="{{route('admin.purchaseSinglePaymentDelete')}}" class="purchaseSinglePaymentDelete"/>
                </div>
                <input type="hidden" value="" class="delete_payment_value_class" />
                <input type="hidden" value="" class="purchase_final_id_class" />
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-primary delete_single_payment_class" >Yes</a>
                </div>
            </div>
        </div>
    </div>
    <!---delete Payment modal---->






  <!--Show Purchase Modal salim vai made-->
  <div class="modal fade" id="purchaseshow" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 90%">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            <strong>Sell Details (Invoice No: 0309)</strong>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </h5>
        </div>
        <div class="modal-body" id="purchase-container">
            Loading...
        </div>
        <div class="modal-footer">
          <button id="print" type="button" class="btn btn-primary"><i class="fa fa-print"></i>Print</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
  <!--Show Purchase Modal salim vai made-->


    <!-----add payment Modal----->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
    <input type="hidden" value="{{ route('admin.purchase.addSinglePayment') }}" class="addSinglePayment" />
    <input type="hidden" value="{{ route('admin.purchase.viewSinglePayment') }}" class="viewSinglePayment" />
    <!-----add payment Modal----->


    {{--
        <script>
            $(document).ready(function(){
                $(document).on('click', '#view', function(){
                    var url = $(this).data("url");
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(response){
                            // console.log(response);
                            $("#purchase-container").html(response);
                        },
                    });
                });

                $("#purchaseshow").on("hidden.bs.modal", function () {
                    // alert("Close");
                });

                $(document).on('click', '#print', function(){

                    $.print( $("#purchaseshow").html() );
                });
            });
            function submitform() {   document.deleteForm.submit(); }
        </script>
    --}}
    {{-- End of Modal --}}



@push('js')
   <script src="{{ asset('public') }}/custom_js/backend/purchase/index.js?v=1"></script>


    <!---- payment methods----->
    <script src="{{ asset('public') }}/custom_js/backend/payment/add_payment_methods.js?v=1"></script>
    <!---- payment methods----->

    <script src="{{ asset('public') }}/custom_js/backend/purchase/payment_modal.js?v=1"></script>
@endpush
@endsection


{{---
    @if ($quotation->signature)
        @if(Storage::disk('public')->exists('purchase/chalan/',"{$quotation->id}.".$quotation->signature))
        <img src="{{ asset('storage/purchase/chalan/'.$quotation->id.'.'.$quotation->signature) }}" width="140" height="130" alt="signature" >
        @endif
        @else
    @endif
---}}
