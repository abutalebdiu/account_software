@extends('home')
@section('title','Products')
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
                        <span class="widget-caption" style="font-size: 20px">Sales</span>
                     </div>
                    <div class="widget-body" style="background-color: #fff;">
                        <div class="row" style="">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{route('sale.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Add Sale</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Reference No</th>
                                        <th>Date(Time)</th>
                                        <th>Customer</th>
                                        <th>Total Payable</th>
                                        <th>Account</th>
                                        <th>Added By</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                            <tbody>
                                @foreach ($sales as $key=> $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->order_no}}</td>
                                        <td>{{$item->sale_date}}</td>
                                        <td>
                                            {{$item->customer_id}}
                                        </td>
                                        <td>{{$item->final_total}}</td>
                                        <td>
                                            @if ($item->payment_method_id == 1)
                                                Cash
                                            @endif
                                            @if ($item->payment_method_id == 2)
                                                Card
                                            @endif
                                            @if ($item->payment_method_id == 3)
                                                Roket
                                            @endif
                                        </td>
                                        <td>
                                            {{$item->createdBy?$item->createdBy->name:"No"}}
                                        </td>
                                        <td>Status</td>
                                        <td>Action</td>
                                    </tr>
                                @endforeach
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
