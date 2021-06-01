@extends('home')
@section('title','Show Transaction Detail')
@push('css')
<style>
    .float-right {
        float: right;
    }
</style>
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
            <li class="active">Show Transaction Detail</li>
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
                        <span class="widget-caption" style="font-size: 20px">Show Transaction Detail</span>
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
                    <div class="widget-body">
                        
                            <label class="text-align-center"> <strong>Transaction Final</strong> </label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="transaction_type">Type</label>
                                        <input type="text" value="{{$transaction->transactionType?$transaction->transactionType->name:NULL}}" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="transaction_category_id">Category</label>
                                        <input type="text" value="{{$transaction->transactionCategory?$transaction->transactionCategory->name:NULL}}" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="transaction_final_reference">Reference</label>
                                        <input type="text" value="{{$transaction->reference_no}}" class="form-control" disabled />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="transaction_date">Transaction Date</label>
                                       <input type="text" value="{{date('d-m-Y',strtotime($transaction->transaction_date))}}" class="form-control" disabled />
                                    </div>
                                </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="transaction_note">Transaction Note</label>
                                    <input type="text" value="{{$transaction->transaction_note}}" class="form-control" disabled />
                                </div>
                            </div>
                        <div style="padding: 1.5rem">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Sub Total</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-transaction">
                                    @foreach ($transaction->transactionDetails?$transaction->transactionDetails:NULL as $item)
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" value="{{$item->transaction_title}}" class="form-control" disabled />
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" value="{{$item->description}}" class="form-control" disabled />
                                        </td>
                                        <td style="width:12%;">
                                           <input type="text" value="{{$item->sub_total}}" class="form-control" disabled />
                                        </td>
                                        <td style="width:15%;">
                                            <input type="text" value="{{date('d-m-Y',strtotime($item->transaction_created_date))}}" class="form-control" disabled />
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Sub Total</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    <div class="col-sm-6 float-right">
                        <div class="form-group float-right">
                            <a href="{{route('admin.transaction-detail.index')}}" class="btn btn-info">Back</a>
                        </div>
                    </div>
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

@push('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endpush