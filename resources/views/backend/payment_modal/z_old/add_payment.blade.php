@extends('home')
@section('title','Purchase')
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
            <li class="active"> Add Payment</li>
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
                Purchase
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
                        <span class="widget-caption" style="font-size: 20px">Purchase</span>
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
                    <div class="widget-body">
                        <form action="{{route('admin.account.store')}}" method="post" enctype="multipart/form-data">
                            @csrf


                            <!--------Payment part---->
                            <div class="col-sm-12 col-md-12">
                                <h5> <strong style="border-bottom:1px solid gray;">Add Account</strong></h5>
                                <br /><br />
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
                                    <div class="col-sm-3" id="bank_id_div" style="display: none">
                                        <div class="form-group">
                                            <label for="">Bank:* </label>
                                            <select name="bank_id" id="bank_id" class="form-control">
                                                <option value="">Select Bank</option>
                                                @foreach ($banks as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                            <div style='color:red; padding: 0 5px;'>
                                                {{($errors->has('bank_id'))?($errors->first('bank_id')):''}}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" id="account_name_div" style="display: none">
                                        <div class="form-group">
                                            <label for="">Account Name </label>
                                            <input name="account_name" placeholder="Account Name" id="account_name"
                                                type="text" class="form-control">
                                            <div style='color:red; padding: 0 5px;'>
                                                {{ ($errors->has('account_name')) ? ($errors->first('account_name')) : ''}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3" id="account_no_div" style="display: none">
                                        <div class="form-group">
                                            <label for="">Account No </label>
                                            <input name="account_no" placeholder="Account No" id="account_no"
                                                type="text" class="form-control">
                                            <div style='color:red; padding: 0 5px;'>
                                                {{ ($errors->has('account_no')) ? ($errors->first('account_no')) : ''}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" id="opening_amount_div">
                                        <div class="form-group">
                                            <label for="">Amount:* <small>(opening amount)</small></label>
                                            <input name="opening_amount" type="number" class="form-control" value="0"
                                                min="0">
                                            <div style='color:red; padding: 0 5px;'>
                                                {{($errors->has('opening_amount'))?($errors->first('opening_amount')):''}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" id="contract_person_div">
                                        <div class="form-group">
                                            <label for="">Contact Person </label>
                                            <input name="contract_person" placeholder="Full Name" id="contract_person"
                                                type="text" class="form-control">
                                            <div style='color:red; padding: 0 5px;'>
                                                {{ ($errors->has('contract_person')) ? ($errors->first('contract_person')) : ''}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" id="contract_phone_div">
                                        <div class="form-group">
                                            <label for="">Contact Phone </label>
                                            <input name="contract_phone" placeholder="XXX-XXXXXXX" id="contract_phone"
                                                type="text" class="form-control">
                                            <div style='color:red; padding: 0 5px;'>
                                                {{ ($errors->has('contract_phone')) ? ($errors->first('contract_phone')) : ''}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3" id="address_div">
                                        <div class="form-group">
                                            <label for="">Address </label>
                                            <input name="address" placeholder="Address" id="address" type="text"
                                                class="form-control">
                                            <div style='color:red; padding: 0 5px;'>
                                                {{ ($errors->has('address')) ? ($errors->first('address')) : ''}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!---Bank Account options---->
                            {{-- <div class="col-sm-12 col-md-12" id="payment_account_div" style="display:none;">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> Payment Account </label>
                                            <select name="bank_id" id="bank_id" class="form-control">
                                                <option value="">Select </option>
                                            </select>
                                            <div style='color:red; padding: 0 5px;'>
                                                {{($errors->has('total_purchase_amount'))?($errors->first('total_purchase_amount')):''}}
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"></div>
        </div>
    </div> --}}
    <!---Bank Account options---->


    <!---card payment options---->
    <div class="col-sm-12 col-md-12" id="card_div" style="display:none;">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="">Card Number </label>
                    <input name="card_number" value="0" id="card_number_id" type="text" class="form-control">
                    <div style='color:red; padding: 0 5px;'>
                        {{($errors->has('card_number'))?($errors->first('card_number')):''}}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="">Card holder name* <small></small></label>
                    <input name="card_holder_name" id="card_holder_name_id" type="text" class="form-control" value="">
                    <div style='color:red; padding: 0 5px;'>
                        {{($errors->has('card_holder_name'))?($errors->first('card_holder_name')):''}}
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="">Card Transaction No</label>
                    <input name="card_transaction_no" id="card_transaction_no_id" type="text" class="form-control"
                        value="">
                    <div style='color:red; padding: 0 5px;'>
                        {{($errors->has('card_transaction_no'))?($errors->first('card_transaction_no')):''}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="">Card Type </label>
                    <select name="card_type" id="card_type_id" class="form-control">
                        <option value="">Select Card Type</option>
                        <option value="1">Credit Card</option>
                        <option value="2">Debit Card</option>
                        <option value="3">Visa Card</option>
                        <option value="4">Master Card</option>
                    </select>
                    <div style='color:red; padding: 0 5px;'>
                        {{($errors->has('advance_balance'))?($errors->first('advance_balance')):''}}
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="">Card Expire Month</label>
                    <select name="expire_month" class="form-control" id="">
                        @foreach (months_HH() as $item)
                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                        @endforeach
                    </select>
                    <div style='color:red; padding: 0 5px;'>
                        {{($errors->has('expire_month'))?($errors->first('expire_month')):''}}
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="">Card Expire Year</label>
                    <select name="expire_year" class="form-control">
                        @foreach (years_HH() as $item)
                        <option value="{{$item}}">{{$item}}</option>
                        @endforeach
                    </select>
                    <div style='color:red; padding: 0 5px;'>
                        {{($errors->has('expire_year'))?($errors->first('expire_year')):''}}
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="">Security Code</label>
                    <input name="card_security_code" type="text" class="form-control" value="">
                    <div style='color:red; padding: 0 5px;'>
                        {{($errors->has('card_security_code'))?($errors->first('card_security_code')):''}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---card payment options end---->

    <!---Cheque No---->
    <div class="col-sm-12 col-md-12" id="cheque_div" style="display:none;">
        <div class="form-group">
            <label for="">Cheque No. </label>
            <input name="cheque_no" value="" type="text" class="form-control">
            <div style='color:red; padding: 0 5px;'>
                {{($errors->has('cheque_no'))?($errors->first('cheque_no')):''}}</div>
        </div>
    </div>
    <!---Cheque No end---->

    <!---Bank Transfer No---->
    {{-- <div class="col-sm-12 col-md-12" id="bank_transfer_div" style="display:none;">
        <div class="form-group">
            <label for="">Bank Account No </label>
            <input name="transfer_bank_account_no" value="" type="text" class="form-control">
            <div style='color:red; padding: 0 5px;'>
                {{($errors->has('transfer_bank_account_no'))?($errors->first('transfer_bank_account_no')):''}}
</div>
</div>
</div> --}}
<!---Bank Transfer No---->

<!---Others Transaction---->
<div class="col-sm-12 col-md-12" id="custom_payment_div" style="display:none;">
    <div class="form-group">
        <label for="">Transaction No. </label>
        <input name="transaction_no" value="" type="text" class="form-control">
        <div style='color:red; padding: 0 5px;'>
            {{($errors->has('transaction_no'))?($errors->first('transaction_no')):''}}</div>
    </div>
</div>
<!---Others Transaction---->

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <input id="sumbitButton" type="submit" value="Submit" class="btn btn-primary">
            <a href="{{route('admin.account.index')}}" class="btn btn-info">Back</a>
        </div>
    </div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<!-- /Page Body -->
</div>

@push('js')


<!-----for Ajax handeling----->
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        $(document).on('change','#payment_method_id_id',function() {
            var method_id = ($(this).val());
            if(method_id == 1)
            {
                // $('#payment_account_div').hide();
                $('#card_div').hide();
                $('#cheque_div').hide();
                $('#bank_transfer_div').hide();
                $('#custom_payment_div').hide();
                $('#bank_id_div').show();
                $('#account_name_div').show();
                $('#account_no_div').show();
            }
            else if(method_id == 2)
            {
                // $('#payment_account_div').show();
                $('#card_div').hide();
                $('#cheque_div').hide();
                $('#bank_transfer_div').hide();
                $('#custom_payment_div').hide();
                $('#bank_id_div').hide();
                $('#account_name_div').hide();
                $('#account_no_div').hide();
            }
            else if(method_id == 3)
            {
                // $('#payment_account_div').show();
                $('#card_div').show();
                $('#cheque_div').hide();
                $('#bank_transfer_div').hide();
                $('#custom_payment_div').hide();
                $('#bank_id_div').show();
                $('#account_name_div').show();
                $('#account_no_div').show();
            }
            else if(method_id == 4)
            {
                // $('#payment_account_div').show();
                $('#card_div').hide();
                $('#cheque_div').show();
                $('#bank_transfer_div').hide();
                $('#custom_payment_div').hide();
                $('#bank_id_div').show();
                $('#account_name_div').show();
                $('#account_no_div').show();
            }
            else if(method_id == 5)
            {
                // $('#payment_account_div').show();
                $('#card_div').hide();
                $('#cheque_div').hide();
                $('#bank_transfer_div').show();
                $('#custom_payment_div').hide();
                $('#bank_id_div').show();
                $('#account_name_div').show();
                $('#account_no_div').show();
            }
            else if(method_id == 5)
            {
                // $('#payment_account_div').show();
                $('#card_div').hide();
                $('#cheque_div').hide();
                $('#bank_transfer_div').hide();
                $('#custom_payment_div').hide();
                $('#bank_id_div').show();
                $('#account_name_div').show();
                $('#account_no_div').show();
            }
            else if(method_id == 6)
            {
                // $('#payment_account_div').show();
                $('#custom_payment_div').hide();
                $('#card_div').hide();
                $('#cheque_div').hide();
                $('#bank_transfer_div').hide();
                $('#bank_id_div').show();
                $('#account_name_div').show();
                $('#account_no_div').show();
            }
            else if(method_id == 7)
            {
                $('#payment_account_div').hide();
                $('#card_div').hide();
                $('#cheque_div').hide();
                $('#bank_transfer_div').hide();
                $('#custom_payment_div').hide();
                $('#bank_id_div').hide();
                $('#account_name_div').hide();
                $('#account_no_div').hide();
            }
        });
    });
</script>
@endpush

@endsection