
@extends('home')
@section('title',' Return Purchase Invoice')
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
            <li class="active">Purchase Return </li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">
            <h1>
                Inovice No : {{$purchase->invoice_no}}
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


        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif


    <!-- Page Body -->
    <div class="page-body">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="widget">
                    <div class="widget-header bg-info">
                        <span class="widget-caption" style="font-size: 20px">
                        Inovice No : {{$purchase->invoice_no}} (Purchase Return)
                        </span>
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
                    <form action="{{route('admin.returnPurchaseStore')}}" method="POST">
                        @csrf
                        <input type="hidden" name="purchase_final_id" value="{{ $purchase->id }}" />
                        <input type="hidden" name="supplier_id" value="{{ $purchase->supplier_id }}" />
                        <input type="hidden" name="business_location_id" value="{{ $purchase->business_location_id }}" />
                        <div class="widget-body" style="background-color: #fff;">
                            <div class="row" style="margin: 30px 0;">
                                <div class="col-md-4">
                                    <label>Invoice No:</label>
                                    <input type="text" name="invoice_no" readonly value="{{$purchase->invoice_no}}" class="form-control"/> <br/>
                                    <label>Purchase Date:</label>
                                    <input type="text" readonly value="{{ date('d-m-Y',strtotime($purchase->purchaes_date)) }}" class="form-control"/>
                                </div>
                                <div class="col-md-4">
                                <label>Supplier Name:</label>
                                    <input type="text" readonly value="{{$purchase->suppliers?$purchase->suppliers->name:NULL}}" class="form-control"/> <br/>
                                    <label>Business Location:</label>
                                    <input type="text" readonly value="Head Office" class="form-control"/>
                                </div>
                                <div class="col-md-4">
                                    <label>Date:</label>
                                    <input type="date" name="return_date"  value="" class="form-control"/> <br/>
                                    <label>Return Note:</label>
                                    <input type="text" name="return_note"  value="" class="form-control"/>
                                </div>
                            </div>
                            <br/><hr/>
                            <br/>
                            <!----- --- ----- Cart Part part-------------->
                            <div style="">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Product Name</th>
                                            <th>Purchase <br/> Unit</th>
                                            <th>
                                                Unit Price <br/>
                                                (Inc.Tax)
                                            </th>
                                            <th>Purchase <br/> Quantity</th>
                                            <th>Return Quantity</th>
                                            <th>Return Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase->purchaseDetails ?? NULL as $key => $item)
                                            <tr>
                                                <td>
                                                    {{$key+1}}
                                                    <input type="hidden" name="product_id[]" value="{{ $item->product_id }}" />
                                                    <input type="hidden" name="product_variation_id[]" value="{{ $item->product_variation_id }}" />
                                                    <input type="hidden" name="return_unit_price_inc_tax[]" value="{{ $item->purchase_unit_price_inc_tax }}" />
                                                    <input type="hidden" name="return_unit_id[]" value="{{ $item->default_purchase_unit_id }}" />
                                                    <input type="hidden" name="purchase_quantity[]" value="{{ $item->quantity }}" />
                                                    <input type="hidden" name="return_stock_id[]" value="{{$item->stock_id}}" />
                                                    <input type="hidden" name="return_stock_type_id[]" value="{{$item->stock_type_id}}" />

                                                    <input type="hidden" name="totalReceivedQuantity[]" value="{{$item->totalReceivedQtys()}}" />
                                                </td>
                                                <td style="width:40%">
                                                    {{$item->productVariations?$item->productVariations->products?$item->productVariations->products->name:NULL:NULL}}
                                                    {{$item->productVariations?$item->productVariations->colors? "(".$item->productVariations->colors->name .")":NULL:NULL}}
                                                    {{$item->productVariations?$item->productVariations->sizes? "(". $item->productVariations->sizes->name .")":NULL:NULL}}
                                                    {{$item->productVariations?$item->productVariations->weights? "(". $item->productVariations->weights->name .")" :NULL:NULL}}
                                                </td>
                                                <td>
                                                    {{$item->defaultPurchaseUnits?$item->defaultPurchaseUnits->short_name:NULL}}
                                                </td>
                                                <td>
                                                    {{$item->purchase_unit_price_inc_tax}}
                                                    <input type="hidden" value="{{$item->purchase_unit_price_inc_tax}}" id="purchase_unit_id_{{ $item->product_variation_id }}"
                                                </td>
                                                <td>
                                                    {{$item->quantity}}
                                                    <input type="hidden" value="{{$item->quantity}}" id="purchase_quantity_id_{{ $item->product_variation_id }}"
                                                </td>
                                                <td style="width:15%">
                                                    <input type="text" value="0" name="return_quantity[]" class="return_quantity_class form-control" id="return_quantity_id_{{ $item->product_variation_id }}" data-product_variation_id="{{ $item->product_variation_id }}"/>
                                                </td>
                                                <td>
                                                    <strong id="return_amount_id_{{ $item->product_variation_id }}" class="get_subtotal_class">0.0</strong>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!----- --- ----- Cart Part part-------------->


                                <div class="row">
                                <div class="col-md-9"></div>
                                    <div class="col-md-3">
                                        <label for="">Return Subtotal: ৳ </label>
                                        <input name="discount_amount" value="{{old('discount_amount') ?? 0}}" id="" type="text" readonly class="return_subtotal_amount_class form-control">
                                    </div>
                                </div>
                            <br/>

                            <!----- --- ----- discount part-------------->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Discount Type : </label>
                                        <select id="" name="discount_type" class="discount_type_id_class form-control">
                                            <option value="">None</option>
                                            <option {{old('discount_type_id') == 1?'selected':''}} value="1">Parcent</option>
                                            <option {{old('discount_type_id') == 2?'selected':''}} value="2">Fixed</option>
                                        </select>
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('discount_type_id'))?($errors->first('discount_type_id')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Discount Value: </label>
                                        <input  name="discount_value" id="" type="text" class="discount_value_class form-control" value="{{old('discount_value') ?? 0}}">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('discount_value'))?($errors->first('discount_value')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Discount Amount:(-) ৳ </label>
                                        <input name="discount_amount" value="{{old('discount_amount') ?? 0}}" id="" type="text" readonly class="discount_amount_id_class form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('discount_amount'))?($errors->first('discount_amount')):''}}</div>
                                    </div>
                                </div>
                            </div>
                            <!----- --- ----- discount part-------------->
                            <br/><br/>

                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4" style="text-align:right">
                                {{--   <div>
                                        <h6>
                                            <strong>Total Return Discount:  (-) ৳
                                                <span class="return_discount_amount_class"></span>
                                            </strong>
                                        </h6>
                                    </div>  --}}
                                    <div>
                                        <h6>
                                            <strong>Total Return Tax - :  (+) ৳
                                                <span class="return_tax_amount_class"></span>
                                            </strong>
                                        </h6>
                                    </div>
                                    <div>
                                        <h6>
                                            <strong>Return Total:   ৳
                                                <span class="return_total_amount_class"></span>
                                            </strong>
                                        </h6>
                                        <input type="hidden" name="return_total_amount" class="paid_amount  return_total_amount_val_class" />
                                    </div>
                                </div>
                            </div>


                              <div class="row">    
                                <!--------Payment part---->
                                <div class="col-sm-12 col-md-12">
                                    <h5> <strong style="border-bottom:1px solid gray;">Add Payment</strong></h5> <br/><br/>
                                    <div class="row">
                                        {{--  <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Advance Balance </label>
                                                <input name="advance_balance" value="0" readonly id="advance_balance_id" type="text" class="form-control">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('advance_balance'))?($errors->first('advance_balance')):''}}</div>
                                            </div>
                                        </div>  --}}
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Amount:* <small>(payment amount)</small></label>
                                                <input name="payment_amount" type="text" class="payment_amount payment_amount_now_class form-control" value="0" style="font-size: 15px;color:green;font-weight:bold;">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('paymet_amount'))?($errors->first('paymet_amount')):''}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Paid on:* <small>(Paid Date)</small></label>
                                                <input name="payment_date" type="date" class="form-control" value="">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('payment_date'))?($errors->first('payment_date')):''}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!---Bank Account options---->
                                <div class="col-sm-12 col-md-12 " >
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Payment Method:* </label>
                                                <select name="payment_method_id" id="" class="payment_method_id_class form-control">
                                                    <option value="">Select Payment Method</option>
                                                    @foreach($payment_methods as $method)
                                                    <option value="{{$method->id}}">{{$method->method}}</option>
                                                    @endforeach
                                                </select>
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('payment_method_id'))?($errors->first('payment_method_id')):''}}</div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{route('admin.getAccountByPaymentMethod')}}" class="getAccountByPaymentMethod" />

                                        
                                        <div class="col-sm-8 payment_account_div"  style="display:none;">
                                            <div class="form-group">
                                                <label for=""> Payment From Account </label>
                                                <select name="account_id" id="bank_id" class="bank_id_class form-control" >
                                                    <option value="">Select </option>
                                                </select>
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('total_purchase_amount'))?($errors->first('total_purchase_amount')):''}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---Bank Account options---->


                                <!---card payment options---->
                                <div class="col-sm-12 col-md-12 card_div"   style="display:none;">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Card Number </label>
                                                <input name="card_number" value="0"  id="card_number_id" type="text" class="form-control">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('card_number'))?($errors->first('card_number')):''}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Card holder name* <small></small></label>
                                                <input name="card_holder_name" id="card_holder_name_id" type="text" class="form-control" value="">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('card_holder_name'))?($errors->first('card_holder_name')):''}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Card Transaction No</label>
                                                <input name="card_transaction_no" id="card_transaction_no_id" type="text" class="form-control" value="">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('card_transaction_no'))?($errors->first('card_transaction_no')):''}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Card Type </label>
                                                <select name="card_type" id="card_type_id"  class="form-control">
                                                    <option value="">Select Card Type</option>
                                                    @foreach (cardType_HH() as $item) 
                                                        <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                    @endforeach
                                                </select>
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('advance_balance'))?($errors->first('advance_balance')):''}}</div>
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
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('expire_month'))?($errors->first('expire_month')):''}}</div>
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
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('expire_year'))?($errors->first('expire_year')):''}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Security Code</label>
                                                <input name="card_security_code" type="text" class="form-control" value="">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('card_security_code'))?($errors->first('card_security_code')):''}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!---card payment options end---->

                                <!---From Mobile Banking Account---->
                                <div class="col-sm-12 col-md-12 from_mobile_banking_account_div" id="" style="display:none;">
                                    <div class="form-group">
                                        <label for="">To Mobile Banking Account</label>
                                        <input  name="from_mobile_banking_account" value="" type="text" class="form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('from_mobile_banking_account'))?($errors->first('from_mobile_banking_account')):''}}</div>
                                    </div>
                                </div>
                                <!---From Mobile Banking Account end---->

                                <!---Cheque No---->
                                <div class="col-sm-12 col-md-12 cheque_div" id="" style="display:none;">
                                    <div class="form-group">
                                        <label for="">Cheque No. </label>
                                        <input  name="cheque_no" value="" type="text" class="form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('cheque_no'))?($errors->first('cheque_no')):''}}</div>
                                    </div>
                                </div>
                                <!---Cheque No end---->

                                <!---Bank Transfer No---->
                                <div class="col-sm-12 col-md-12 bank_transfer_div"   style="display:none;">
                                    <div class="form-group">
                                        <label for="">Bank Account No </label>
                                        <input  name="transfer_bank_account_no" value="" type="text" class="form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('transfer_bank_account_no'))?($errors->first('transfer_bank_account_no')):''}}</div>
                                    </div>
                                </div>
                                <!---Bank Transfer No---->

                                <!---Others Transaction---->
                                <div class="col-sm-12 col-md-12 custom_payment_div" id=""  style="display:none;">
                                    <div class="form-group">
                                        <label for="">Transaction No. </label>
                                        <input  name="transaction_no" value="" type="text" class="form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('transaction_no'))?($errors->first('transaction_no')):''}}</div>
                                    </div>
                                </div>
                                <!---Others Transaction---->

                                <!-----payment Note--------->
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Payment note: </label>
                                        <textarea name="payment_note" value="" type="text" class="form-control"></textarea>
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('payment_note'))?($errors->first('payment_note')):''}}</div>
                                    </div>
                                </div>
                                <!---payment Note End--->

                                <!--------Payment part End--------->

                                <!--------Due part---->
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-sm-6"></div>
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Due Amount: </label>
                                                <input name="due_amount" type="text" class="total_due_amount_after_payment_class  form-control" readonly value="" placeholder="Due Amount" style="font-size: 15px;color:red;font-weight:bold;">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('due_amount'))?($errors->first('due_amount')):''}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--------Due part End---->

                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-sm-6"></div>
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                               <input type="submit" class="btn btn-primary pull-right submit_class" value="Submit" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!---payment part is end--->
                            <br/>
                        </div>
                    </from>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Body -->
</div>
<!-- /Page Content -->
    @push('js')
        <!-----for Ajax handeling----->
        <script type="text/javascript">
            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
        </script>
        <!-----for Ajax handeling----->
        <script src="{{ asset('public') }}/custom_js/backend/purchase/return.js?v=1"></script>

        <!---- payment methods----->
        <script src="{{ asset('public') }}/custom_js/backend/payment/add_payment_methods.js?v=1"></script>
        <!---- payment methods----->
    @endpush
@endsection


{{---
    @if ($quotation->signature)
        @if(Storage::disk('public')->exists('purchase/chalan/',"{$quotation->id}.".$quotation->signature))
        <img src="{{ asset('storage/purchase/chalan/'.$quotation->id.'.'.$quotation->signature) }}" width="140" height="130" alt="signature" >
        @endif
        @else
    @endif
---}}
