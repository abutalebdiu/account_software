@extends('home')
@section('title','Sale Index')
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
            <li class="active">Sale Index</li>
        </ul>



    </div>
    <!-- /Page Breadcrumb -->
   
    <!-- Page Body -->
    <div class="page-body">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="widget">
                    <div class="widget-header bg-info">
                        <span class="widget-caption" style="font-size: 20px">Sales</span>
                        
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

                        <div class="row">
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
                                        <th>Action</th>
                                        <th>Invoice No</th>
                                        <th>Date(Time)</th>
                                        <th>Customer</th>
                                        <th>Total Amount</th>
                                        <th>Payment <br/> Status</th>
                                        <th>Paid Amount</th>
                                        <th>Due Amount</th>
                                        <th>Created By</th>
                                        <th>Total <br/> Item</th>
                                     
                                        <th>Reference By</th>
                                        {{--  <th>Sale<br/>Product<br/> Delivery <br/>Status</th>  --}}
                                    </tr>
                                </thead>
                                    @php 
                                    $totalAmount = 0;
                                    $paidTotalAmount = 0;
                                    $dueTotalAmount = 0;
                                    $totalItem  = 0;
                                    
                                    $machdate = '';
                                    @endphp
                                <tbody>
                                    @foreach ($sales as $key=> $item)
                                    <tr>
                                        <td>{{$key+1}}</td>

                                         <td>
                                            <div class="btn-group dropdown">
                                                <button class="btn btn-sm btn-primary btn-secondary dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li class="dropdown-item">
                                                        <a class="single_view_class" data-id="{{$item->id}}" href="#">View</a>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <a class="printInvoiceClass" data-id="{{$item->id}}" href="#">Print</a>
                                                    </li>
                                                    <li class="dropdown-item"><a  href="{{route('sale.editPos',$item->id)}}">Edit</a></li>
                                                    @if($item->totalSaleAmount() > $item->totalPaidAmount())
                                                    <li class="dropdown-item">
                                                        <a class="addPaymentClass" href="#" data-id="{{$item->id}}">
                                                            Add Payment
                                                        </a>
                                                    </li>
                                                    @endif
                                                    <li class="dropdown-item">
                                                        <a class="viewPaymentClass" href="#" data-id="{{$item->id}}">
                                                            View Payment
                                                        </a>
                                                    </li>
                                                    <li class="dropdown-item">
                                                        <a class="viewProfitLossRepotClass" href="#" data-id="{{$item->id}}">
                                                            View Profit/Loss
                                                        </a>
                                                    </li>
                                                    <li class="dropdown-item"><a  href="{{route('sale.returnSaleCreate',$item->id)}}">Products Return </a></li>
                                                    <li class="dropdown-item"><a  href="{{route('sale.duplicateSale',$item->id)}}">Duplicate Sell</a></li>
                                                    <li class="dropdown-item"><a class="delete_class" data-id="{{$item->id}}" data-invoice_no="{{$item->order_no}}" href="#">Delete</a></li>
                                                </div>
                                            </div>
                                        </td>
                                       
                                        <td>
                                            <a class="single_view_class" data-id="{{$item->id}}" href="#" style="text-decoration: none;">
                                                {{$item->order_no}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="single_view_class" data-id="{{$item->id}}" href="#" style="text-decoration: none;">
                                                {{date('d-m-Y h:i:s ',strtotime($item->sale_date))}}
                                            </a>
                                        </td>
                                        <td>
                                            {{$item->customers?$item->customers->name:NULL}}
                                        </td>
                                        <td>
                                            @php 
                                            $totalAmount        += $item->totalSaleAmount();
                                            $paidTotalAmount    += $item->totalPaidAmount();
                                            $dueTotalAmount     += $item->totalDueAmount();
                                            $totalItem          += $item->totalSaleItems();
                                            @endphp
                                              {{ $item->totalSaleAmount() }}
                                        </td>
                                        <td>
                                            @if($item->totalPaidAmount() > 0)
                                                <span>
                                                    @if($item->totalSaleAmount() == $item->totalPaidAmount())
                                                        <span class="badge badge-primary"> Paid </span>
                                                    
                                                    @elseif($item->totalSaleAmount() > 0 && $item->totalSaleAmount()  < $item->totalPaidAmount())
                                                         <small class="badge badge-warning"> Over</small><span class="badge badge-primary"> Paid </span>
                                                    
                                                    @elseif($item->totalSaleAmount() > 0 && $item->totalSaleAmount()  > $item->totalPaidAmount())
                                                        <span class="badge badge-danger">Due</span>
                                                    
                                                    @elseif($item->totalSaleAmount() < 0)
                                                        <span class="badge badge-defalut" style="backgrounc-color:#06061f;color:red;">Invalid </span>
                                                    @endif
                                                    </span>
                                                @else
                                                 <span class="badge badge-danger">Due</span>
                                            @endif
                                        </td>
                                        <td>  {{$item->totalPaidAmount()}}</td>
                                        <td>  {{$item->totalDueAmount()}}</td>
                                        <td>
                                            {{$item->createdBy?$item->createdBy->name:"No"}}
                                        </td>
                                        <td>{{$item->totalSaleItems()}}</td>
                                       
                                        <td>
                                            {{$item->referenceBy ? $item->referenceBy->name:NULL}} 
                                            {{$item->referenceBy ? " (". $item->referenceBy->phone .")" :NULL}} 
                                        </td>
                                    </tr>
                                    
                                    
                                    @php
                                    
                                    $datevalue = date('d-m-Y',strtotime($item->sale_date));
                                    
                                    if(empty($machdate))
                                    {
                                         $machdate = $datevalue;
                                    }
                                    
                                    else{
                                    
                                      if($machdate == $datevalue)
                                      {
                                        
                                      
                                      }
                                      else{
                                      
                                       $machdate = $datevalue;
                                      
                                            @endphp
                                            
                                              <tr>
                                                  <td colspan='12' style='color:white;background-color:red;height:10px'>
                                                      {{ $machdate }}
                                                  </td>
                                              </tr>
                                            @php  
                                      }
                                        
                                    
                                    }
                                
                                     
                                    
                                    
                                   
                                    
                                    @endphp  
                                        
                                     
                                    
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="background-color:#427fed;color:#fff;">
                                        <td colspan="4" style="text-align:right"><strong>Total</strong></td>
                                        <td style="font-size:15px;">  <strong>{{number_format($totalAmount,2,'.','')}}</strong></td>
                                        <td></td>
                                        <td style="font-size:15px;">  <strong>{{number_format($paidTotalAmount,2,'.','')}}</strong></td>
                                        <td style="font-size:15px;">  <strong>{{number_format($dueTotalAmount,2,'.','')}}</strong></td>
                                        <td></td>
                                        <td style="font-size:15px;"><strong>{{number_format($totalItem,2,'.','') }}</strong></td>
                                        <td colspan="2"></td> 
                                        {{--  <td></td>  --}}
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
                    <input type="hidden" value="{{route('sale.deleteSale')}}" class="saleSingleDelete"/>
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
    <input type="hidden" value="{{route('sale.saleSingleShow')}}" class="saleSingleShow"/>
    <input type="hidden" value="{{route('sale.quotationSaleSingleShow')}}" class="quotationSaleSingleShow"/>
    <!-- show single view -->


    <!-- show single invoice profit / loss  view -->
    <div class="modal fade" id="viewProfitLossRepotClass" role="dialog" aria-hidden="true"></div>
    <input type="hidden" value="{{route('sale.invoiceWiseProfitLoss')}}" class="invoiceWiseProfitLoss"/>
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
