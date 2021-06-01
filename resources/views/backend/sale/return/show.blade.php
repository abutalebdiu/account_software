@extends('home')
@section('title','Sales Return list')
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
            <li class="active">Sales Return list</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Body -->
    <div class="page-body">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="widget">
                    <div class="widget-header bg-info">
                        <span class="widget-caption" style="font-size: 20px">Sales Return list</span>
                     </div>
                    <div class="widget-body" style="background-color: #fff;">
                         
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                               <tbody>
                                    <tr>
                                        <th>Customer Name</th>
                                        <td> {{ $salesreturn->customer?$salesreturn->customer->name:'' }} </td>
                                        <th>Sale Invoice No</th>
                                        <td> {{ $salesreturn->order_no }} </td>
                                        <th>Sale Return Date</th>
                                        <td> {{ $salesreturn->return_date }} </td>
                                    </tr>
                               </tbody>
                            </table>


                        </div>

                        
                        <br>
                        <br>
                        <br>
                        <div class="table-responsive ">
                       

                         <table class="table">
                              <thead>
                                   <tr>
                                        <th>SL</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Date</th>
                                    </tr>
                              </thead>
                                <tbody >
                                   

                                    @foreach($salesreturn->salereturndetail as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->product?$item->product->name:'' }}</td>
                                        <td>{{ $item->return_unit_price }}</td>
                                        <td>{{ $item->return_quantity }}</td>
                                        <td>{{ $item->sub_total }}</td>
                                        <td>{{ $item->return_date }}</td>
                                       
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3"> </td>
                                        <td> Total</td>
                                        <td> {{ $salesreturn->salereturndetail->sum('sub_total') }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
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
@endsection
