@extends('home')
@section('title','Account Create')
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
            <li class="active"> Add Account</li>
        </ul>
    </div>
    @if (session()->has('success'))
    <div class="alert alert-success">
        @if(is_array(session('success')))
        <ul>
            @foreach (session('success') as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
        @else
        {{ session('success') }}
        @endif
    </div>
    @endif
    @if (session()->has('error'))
    <div class="alert alert-danger">
        @if(is_array(session('error')))
        <ul>
            @foreach (session('error') as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
        @else
        {{ session('error') }}
        @endif
    </div>
    @endif

        <!-- /Page Breadcrumb -->
        <!-- Page Header -->
        <div class="page-header position-relative">
            <div class="header-title">
                <h1>
                    Add Account
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
                       
                            <form action="{{route('admin.account.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                
                                <!--------Payment part---->
                                <div class="col-sm-12 col-md-12">
                                  
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Payment Method:* </label>
                                                <select name="payment_method_id" id="payment_method_id_id"
                                                    class="form-control">
                                                    <option value="">Select Payment Method</option>
                                                    @foreach ($paymentMethods as $item)
                                                    <option value="{{$item->id}}">{{$item->method}}</option>
                                                    @endforeach
                                                </select>
                                                <div style='color:red; padding: 0 5px;'>
                                                    {{($errors->has('payment_method_id'))?($errors->first('payment_method_id')):''}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" >
                                            <div class="form-group">
                                                <label for="">Bank:* </label>
                                                <select name="bank_id" id="bank_id" class="form-control">
                                                    <option value="">Select Bank</option>
                                                    @foreach ($banks as $item)
                                                    <option  value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div style='color:red; padding: 0 5px;'>
                                                    {{($errors->has('bank_id'))?($errors->first('bank_id')):''}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Account Name </label>
                                                <input name="account_name" placeholder="Account Name" id="account_name"
                                                    type="text" class="form-control" value="">
                                                <div style='color:red; padding: 0 5px;'>
                                                    {{ ($errors->has('account_name')) ? ($errors->first('account_name')) : ''}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Account No </label>
                                                <input name="account_no" placeholder="Account No" id="account_no"
                                                    type="text" class="form-control" value="">
                                                <div style='color:red; padding: 0 5px;'>
                                                    {{ ($errors->has('account_no')) ? ($errors->first('account_no')) : ''}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" >
                                            <div class="form-group">
                                                <label for="">Amount:* <small>(opening amount)</small></label>
                                                <input name="opening_amount" type="number" class="form-control" min="0"
                                                    value="">
                                                <div style='color:red; padding: 0 5px;'>
                                                    {{($errors->has('opening_amount'))?($errors->first('opening_amount')):''}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3" >
                                            <div class="form-group">
                                                <label for="">Contract Person </label>
                                                <input name="contract_person" placeholder="Full Name" id="contract_person"
                                                    type="text" class="form-control" value="">
                                                <div style='color:red; padding: 0 5px;'>
                                                    {{ ($errors->has('contract_person')) ? ($errors->first('contract_person')) : ''}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Contract Phone </label>
                                                <input name="contract_phone" placeholder="XXX-XXXXXXX" id="contract_phone"
                                                    type="text" class="form-control" value="">
                                                <div style='color:red; padding: 0 5px;'>
                                                    {{ ($errors->has('contract_phone')) ? ($errors->first('contract_phone')) : ''}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Address </label>
                                                <input name="address" placeholder="Address" id="address" type="text"
                                                    class="form-control" value="">
                                                <div style='color:red; padding: 0 5px;'>
                                                    {{ ($errors->has('address')) ? ($errors->first('address')) : ''}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for=""> </label>
                                                <input type="submit" value="Submit" class="btn btn-primary" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--------Payment part---->
                            </form>
                      
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Body -->
    
    
</div>

@push('js')


@endpush

@endsection