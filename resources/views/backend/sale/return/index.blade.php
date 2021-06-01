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
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Sales Invoice</th>
                                        <th>Date(Time)</th>
                                        <th>Customer</th>
                                        <th>total Item</th>
                                        <th>Total Amount</th>
                                        <th>Received By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            <tbody>
                                @foreach ($salesreturns as $key=> $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$item->order_no}}</td>
                                        <td>{{$item->return_date}}</td>
                                        <td>{{ $item->customer?$item->customer->name:'' }}</td>
                                        <td>{{$item->salereturndetail->sum('return_quantity')}}</td>
                                        <td>{{$item->salereturndetail->sum('sub_total')}}</td>
                           
                                        <td>
                                            {{$item->createdBy?$item->createdBy->name:"No"}}
                                        </td>
                                        <td>
                                            <a href="{{ route('sale.return.show',$item->id) }}" title=""> <i class="fa fa-eye"></i> Show</a>
                                        </td>
                                     
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
