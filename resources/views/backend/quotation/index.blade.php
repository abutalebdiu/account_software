@extends('home')
@section('title','Quotation List')
@push('css')

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
            <li class="active">Quotation List</li>
        </ul>



    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">
            <h1>
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
    <!-- Page Body -->
    <div class="page-body">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="widget"  style="background-color:#57b5e3 !important;color:#fff;">
                    <div class="widget-header bg-info">
                        <span class="widget-caption" style="font-size: 20px">Quotation</span>
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




                    <div class="widget-body" style="background-color: #fff;">
                        <!-- Showing alert -->
                        <div class="alert_message" style="padding:10px 0px 10px 10px;"> </div>

                        <div class="row" style="margin: 30px 0;">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{route('sale.createPos')}}" class="btn btn-info"><i class="fa fa-plus"></i> Add Sale</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Quotation<br/> No</th>
                                        <th>Create <br/> Date(TIme)</th>
                                        <th>Customer<br/>Name</th>
                                        <th>Customer<br/>Phone</th>
                                        <th>Total Amount</th>
                                        <th>Created By</th>
                                        <th>In-valid Date</th>
                                        <th>Total <br/> Item</th>
                                        <th>Sale Now</th>
                                        <th>Action</th>
                                        <th>Quotation <br/> Note</th>
                                        <th>Reference <br/>By</th>
                                    </tr>
                                </thead>
                                    @php
                                    $totalAmount = 0;
                                    $paidTotalAmount = 0;
                                    $dueTotalAmount = 0;
                                    $totalItem  = 0;
                                    @endphp
                                <tbody>
                                    @foreach ($sales as $key=> $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <a class="quotation_single_view_class" data-id="{{$item->id}}" href="#" style="text-decoration: none;">
                                                 {{$item->quotationInvoices ? $item->quotationInvoices->quotation_no:NULL}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="quotation_single_view_class" data-id="{{$item->id}}" href="#" style="text-decoration: none;">
                                                {{ date('d-m-Y h:i:s a',strtotime($item->sale_date))}}
                                            </a>
                                        </td>
                                        <td>
                                            {{$item->quotationInvoices ? $item->quotationInvoices->customer_name:NULL}}
                                        </td>
                                        <td>
                                            {{$item->quotationInvoices ? $item->quotationInvoices->phone:NULL}}
                                        </td>
                                        <td>
                                            @php
                                            $totalAmount        += $item->quotationTotalSaleAmount();
                                            $totalItem          += $item->quotationTotalSaleItems();
                                            @endphp
                                              {{ $item->quotationTotalSaleAmount() }}
                                        </td>

                                        <td>
                                            {{$item->createdBy?$item->createdBy->name:"No"}}
                                        </td>
                                        <td>
                                            {{$item->quotationInvoices ? $item->quotationInvoices->validate_date:NULL}}
                                        </td>
                                        <td>{{$item->quotationTotalSaleItems()}}</td>
                                         <td>
                                            <div class="btn btn-sm btn-primary">
                                                <a  href="{{route('sale.quotationEdit',$item->id)}}" class="" style="color:#fff;text-decoration: none;">Sale Now</a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group dropdown">
                                                <button class="btn btn-sm btn-info btn-secondary dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li class="dropdown-item">
                                                        <a class="quotation_single_view_class" data-id="{{$item->id}}" href="#">View</a>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <a class="printInvoiceClass" data-id="{{$item->id}}" href="#">Print</a>
                                                    </li>
                                                    <li class="dropdown-item"><a  href="{{route('sale.quotationEdit',$item->id)}}">Sale Now</a></li>
                                                    
                                                    <li class="dropdown-item">
                                                        <a class="quotationViewProfitLossRepotClass" href="#" data-id="{{$item->id}}">
                                                            View Profit/Loss
                                                        </a>
                                                    </li>
                                                    {{--   <li class="dropdown-item"><a  href="{{route('sale.duplicateSale',$item->id)}}">Duplicate Sell</a></li>  --}}
                                                    <li class="dropdown-item"><a class="quotation_delete_class" data-id="{{$item->id}}" data-invoice_no="{{$item->order_no}}" href="#">Delete</a></li>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{$item->quotationInvoices ? $item->quotationInvoices->quotation_note:NULL}}
                                        </td>
                                         <td>
                                            {{$item->referenceBy ? $item->referenceBy->name:NULL}} 
                                            {{$item->referenceBy ? " (". $item->referenceBy->phone .")" :NULL}} 
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="background-color:#57b5e3 !important;color:#fff;">
                                        <td colspan="5" style="text-align:right"><strong>Total</strong></td>
                                        <td style="font-size:15px;">  <strong>{{number_format($totalAmount,2,'.','')}}</strong></td>
                                        <td  colspan="2"></td>
                                        <td style="font-size:15px;"><strong>{{number_format($totalItem,2,'.','') }}</strong></td>
                                        <td   colspan="4"></td>
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


    <!-- Button to Open the Modal -->

    <!---delete sale modal---->
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
                    <!-- delete sale -->
                    <input type="hidden" value="{{route('sale.quotationDeleteSale')}}" class="quotationSaleSingleDelete"/>
            </div>
            <input type="hidden" value="" class="delete_value_class" />
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <a href="#" class="btn btn-primary quotation_delete_single_data_now_class" >Yes</a>
            </div>
            </div>
        </div>
    </div>
    <!---delete sale modal---->

    <!---delete Payment modal---->
    <div class="modal" id="deletePaymentModal" style="  z-index: 1051 !important;">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Delete Invoice No : <strong class="show_payment_invoice_for_delete"></strong></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
                <!-- Modal body -->
                <div class="modal-body">
                        Are you Sure, Want to Delete This?
                        <!-- delete sale -->
                        <input type="hidden" value="{{route('sale.saleSinglePaymentDelete')}}" class="saleSinglePaymentDelete"/>
                </div>
                <input type="hidden" value="" class="delete_payment_value_class" />
                <input type="hidden" value="" class="sale_final_id_class" />
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-primary delete_single_payment_class" >Yes</a>
                </div>
            </div>
        </div>
    </div>
    <!---delete Payment modal---->



    <!-- show single view -->
    <div class="modal fade" id="popupSaleSingleShowModal" role="dialog" aria-hidden="true"></div>
    <input type="hidden" value="{{route('sale.quotationSaleSingleShow')}}" class="quotationSaleSingleShow"/>
    <!-- show single view -->

    <!-- show single invoice profit / loss  view -->
    <div class="modal fade" id="viewProfitLossRepotClass" role="dialog" aria-hidden="true"></div>
    <input type="hidden" value="{{route('sale.quotationInvoiceWiseProfitLoss')}}" class="quotationInvoiceWiseProfitLoss"/>
    <!-- show single invoice profit / loss view -->


    <!-- single Invoice print  -->
    <input type="hidden" value="{{route('sale.saleSingleInvoicePrint')}}" class="saleSingleInvoicePrint"/>



    <!-----add payment Modal----->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
    <input type="hidden" value="{{ route('sale.addSinglePayment') }}" class="addSinglePayment" />
    <input type="hidden" value="{{ route('sale.viewSinglePayment') }}" class="viewSinglePayment" />
    <!-----add payment Modal----->


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

        <script src="{{ asset('public') }}/custom_js/backend/sale/single/single.js?v=1"></script>

        <!----print----->
        <script src="{{ asset('public') }}/custom_js/backend/sale/print/invoice.js?v=1"></script>

        <!----no need used print js ----->
        <script src="{{ asset('public') }}/assets/print/printPage/printPage.js"></script>


        <!---- payment methods----->
        <script src="{{ asset('public') }}/custom_js/backend/payment/add_payment_methods.js?v=1"></script>
        <!---- payment methods----->

        <script src="{{ asset('public') }}/custom_js/backend/sale/single/payment_modal.js?v=1"></script>
        <script src="{{ asset('public') }}/custom_js/backend/sale/single/invoice_wise_profit_loss.js?v=1"></script>
    @endpush
@endsection
