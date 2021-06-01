@extends('home')
@section('title','Account')
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
            <li class="active">Account</li>
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
                        <span class="widget-caption" style="font-size: 20px">Account</span>
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
                        <div class="table-toolbar text-right">
                            <a href="{{route('admin.account.create')}}" class="btn btn-primary"><i
                                    class="fa fa-plus"></i> Add Account</a>
                        </div>
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Payment Method</th>
                                    <th>Bank Name</th>
                                    <th>Account Name</th>
                                    <th>Account No</th>
                                   {{--   <th>Opening Amount</th>
                                    <th>Total Amount</th>  --}}
                                    <th>Address</th>
                                    <th style="width:4%;">Action</th>
                                </tr>
                            </thead>
                            @php
                                $totalOpeningAmount = 0;
                                $totalBalanceAmount = 0;
                            @endphp
                            <tbody>
                                @foreach($accounts as $account)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$account->paymentMethod?$account->paymentMethod->method:NULL}}</td>
                                    <td>{{$account->bank ? $account->bank->name : ""}}</td>
                                    <td>{{$account->account_name}}</td>
                                    <td>{{$account->account_no}}</td>
                                   {{--   <td>
                                        {{$account->opening_amount}}
                                        @php
                                            $totalOpeningAmount += $account->opening_amount;
                                            $totalBalanceAmount += $account->totalAmount();
                                        @endphp

                                    </td>  --}}
                                   {{--   <td>
                                        {{$account->totalAmount()}}
                                    </td>  --}}
                                    <td>{{$account->address}}</td>
                                    <td style="width:4%;">
                                        <a href="{{route('admin.account.edit',$account->id)}}"
                                            class="btn btn-info btn-xs edit"><i class="fa fa-edit"></i>
                                             Edit
                                        </a>
                                        <a id="delete" href="javascript:void(0)" class="btn btn-danger btn-xs delete"
                                            onclick="event.preventDefault(); document.getElementById('accounts{{ $loop->iteration }}').submit();">
                                            <i class="fa fa-trash-o"></i>Delete
                                        </a>
                                        <form class="delete" id="accounts{{ $loop->iteration }}"
                                            action="{{route('admin.account.destroy',$account->id)}}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            {{--  <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align:right;">
                                        <strong>Total</strong>
                                    </th>
                                    <th>
                                            <strong>{{$totalOpeningAmount}}</strong>
                                    </th>
                                    <th>
                                            <strong>{{$totalBalanceAmount}}</strong>
                                    </th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>  --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Body -->
</div>


<!-- /Page Content -->
@endsection