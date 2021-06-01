@extends('home')
@section('title',' Purchase  List')
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
            <li class="active"> Purchase List</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">
            <h1>
                 Purchase List
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
                <div class="widget">
                    <div class="widget-header bg-info">
                        <span class="widget-caption" style="font-size: 20px">Purchase List</span>
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
                        <div class="row" style="margin: 30px 0;">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{route('admin.purchase.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Create Purchase </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Reference No</th>
                                        <th>Invoice No</th>
                                        <th>Date (Time)</th>
                                        <th>Supplier</th>
                                        <th>G.Total</th>
                                        <th>Due</th>
                                        <th>Account</th>
                                        <th>Added By</th>
                                        <th>Purchase<br/>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchases as $key=> $item)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item->reference_no}}</td>
                                            <td>{{$item->invoice_no}}</td>
                                            <td>
                                                {{date('d-m-Y',strtotime($item->purchaes_date))}}
                                            </td>
                                            <td>{{$item->suppliers?$item->suppliers->name:NULL}}</td>
                                            <td>{{ number_format($item->totalPurchaseAmount(),2) }}</td>
                                            <td>{{number_format($item->totalDueAmount(),2)}}</td>
                                            <td>Amount</td>
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


{{---
    @if ($quotation->signature)
        @if(Storage::disk('public')->exists('purchase/chalan/',"{$quotation->id}.".$quotation->signature))
        <img src="{{ asset('storage/purchase/chalan/'.$quotation->id.'.'.$quotation->signature) }}" width="140" height="130" alt="signature" >
        @endif
        @else
    @endif
---}}