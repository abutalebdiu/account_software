@extends('home')
@section('title','Transaction ')
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
            <li class="active">Transaction </li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">
            <h1>
                Dashboard
            </h1>
        </div>
        <!--Header Buttons-->
        <div class="header-buttons">
            <a class="sidebar-toggler" href="javascript:void(0)">
                <i class="fa fa-arrows-h"></i>
            </a>
            <a class="refresh" id="refresh-toggler" href="javascript:void(0)" onclick="location.reload()">
                <i class="glyphicon glyphicon-refresh"></i>
            </a>
            <a class="fullscreen" id="fullscreen-toggler" href="javascript:void(0)">
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
                        <span class="widget-caption" style="font-size: 20px">Transaction </span>
                        <div class="widget-buttons">
                            <a href="javascript:void(0)" data-toggle="maximize">
                                <i class="fa fa-expand"></i>
                            </a>
                            <a href="javascript:void(0)" data-toggle="collapse">
                                <i class="fa fa-minus"></i>
                            </a>
                            <a href="javascript:void(0)" data-toggle="dispose">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body" style="background-color: #fff;">
                        <div class="table-toolbar text-right">
                            <a href="{{route('admin.transaction-detail.create')}}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add Transaction
                            </a>
                        </div>
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Reference</th>
                                    <th>Transaction Date</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactionFinals as $transactionFinal)
                               
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$transactionFinal->transactionType->name}}</td>
                                    <td>{{$transactionFinal->transactionCategory->name}}</td>
                                    <td>{{$transactionFinal->reference_no}}</td>
                                    <td>{{date("d-m-Y", strtotime($transactionFinal->transaction_date))}}</td>
                                    <td>{{$transactionFinal->transactionAmount()}}</td>
                                    <td>
                                         <a href="{{route('admin.transaction-detail.show',$transactionFinal->id)}}"
                                            class="btn btn-info btn-xs edit">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        {{--  <a href="{{route('admin.transaction-detail.edit',$transactionFinal->id)}}"
                                            class="btn btn-info btn-xs edit">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>  --}}
                                        <form id="delete-form"
                                            action="{{route('admin.transaction-detail.destroy',$transactionFinal->id)}}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Are you sure you want to delete this item?');">
                                                <i class="fa fa-trash-o"></i>Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SN</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Reference</th>
                                    <th>Transaction Date</th>
                                    <th>Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                        {{--  <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Reference</th>
                                    <th>Transaction Date</th>
                                    <th>Title</th>
                                    <th>Sub Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactionFinals as $transactionFinal)
                                @foreach ($transactionFinal->transactionDetails as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$transactionFinal->transactionType->name}}</td>
                                    <td>{{$transactionFinal->transactionCategory->name}}</td>
                                    <td>{{$transactionFinal->reference_no}}</td>
                                    <td>{{date("F j, Y", strtotime($item->transaction_created_date))}}</td>
                                    <td>{{$item->transaction_title}}</td>
                                    <td>{{$item->sub_total}}</td>
                                    <td>
                                        <a href="{{route('admin.transaction-detail.edit',$item->id)}}"
                                            class="btn btn-info btn-xs edit">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <form id="delete-form"
                                            action="{{route('admin.transaction-detail.destroy',$item->id)}}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-xs" type="submit">
                                                <i class="fa fa-trash-o"></i>Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SN</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Reference</th>
                                    <th>Transaction Date</th>
                                    <th>Title</th>
                                    <th>Sub Total</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Body -->
</div>
<!-- /Page Content -->
@endsection