@extends('home')
@section('title','Payment Report')
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
            <li class="active">Payment Report</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">
            <h1>
                Payment Report
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
                        <span class="widget-caption" style="font-size: 20px">Payment Report</span>
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
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" style="width: 163px;" >Date</th>
                                    <th class="sorting" style="width: 158px;">Payment Ref No.</th>
                                    <th class="sorting"style="width: 187px;" >Invoice No./Ref. No.</th>
                                    <th class="sorting" style="width: 133px;">Payment Module</th>
                                    <th class="sorting" style="width: 133px;">Amount</th>
                                    <th class="sorting" style="width: 10%;"><small>Credit/Debit</small></th>
                                    <th class="sorting" style="width: 133px;">Payment Method</th>
                                    <th class="sorting"  style="width: 84px;" >Account</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $key => $payment)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">
                                        {{date('d-m-Y',strtotime($payment->payment_date))}}
                                    </td>
                                    <td>
                                        {{$payment->payment_reference_no}}
                                    </td>
                                    <td>
                                        {{$payment->module_invoice_no}}
                                    </td>
                                    <td>
                                        {{ getModuleName_HH($payment->module_id) }}
                                    </td>
                                    <td>
                                        {{ number_format($payment->payment_amount,2,'.','')}}
                                    </td>
                                     <td>
                                       <small> {{getCDFName_HH($payment->cdf_type_id)}} </small>
                                    </td>
                                    <td>
                                        <small style="font-size:11px;">
                                        {{$payment->paymentMethods?$payment->paymentMethods->method:NULL}}<br/>
                                        {{$payment->accounts?$payment->accounts->bank?"(".$payment->accounts->bank->short_name.")":NULL:NULL}}
                                        </small>
                                    </td>
                                    <td>
                                        <small style="font-size:13px;">
                                        {{$payment->accounts?$payment->accounts->account_name:NULL}}<br/>
                                        {{$payment->accounts?"(".$payment->accounts->account_no.")":NULL}}
                                        </small>
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
    <!-- /Page Body -->
</div>


<!-- /Page Content -->
@endsection