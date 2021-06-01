
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
                <li class="active"> Purchase</li>
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
      
        <!-- Page Body -->
        <div class="page-body">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="widget">
                        <div class="widget-header bg-info">
                            <span class="widget-caption" style="font-size: 20px">Purchase</span>
                        </div>
                        <div class="widget-body">
                            <form action="{{route('admin.purchase.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!--------supplier, chalan,reference_no,invoice---->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label style="display: block;" for="">Supplier Name <a href="#" data-target="#supplierModal" data-toggle="modal" class="pull-right "><i style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;color:black;" class="fa fa-plus"></i></a> </label>
                                        <select id="supplier_id" name="supplier_id" class="supplier_id form-control select2">
                                            <option value="">Select Supplier/Vendor</option>
                                            @foreach ($suppliers as $item)
                                                <option {{old('supplier_id') == $item->id ?'selected':''}} value="{{$item->id}}">{{$item->name}} - ({{$item->phone}}) - ({{$item->email}})</option>
                                            @endforeach
                                        </select>
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('supplier_id'))?($errors->first('supplier_id')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Chalan No</label>
                                        <input name="chalan_no" type="text" value="{{old('chalan_no')}}" placeholder="Chalan No" class="form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('chalan_no'))?($errors->first('chalan_no')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Reference No</label>
                                        <input name="reference_no" type="text" value="{{old('refernce_no')}}" placeholder="Reference No" class="form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('reference_no'))?($errors->first('reference_no')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3" style="display:none;">
                                    <div class="form-group">
                                        <label for="">Invoice No</label>
                                        <input name="invoice_no" type="text" value="{{date('Y').date('d').date('m').date('his').mt_rand(10,99)}}" placeholder="Invoice No" class="form-control">
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('invoice_no'))?($errors->first('invoice_no')):''}}</div>
                                    </div>
                                </div>
                                 <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Quotation Date </label>
                                        <input name="purchaes_date" value="{{old('purchaes_date')}}" type="date" class="form-control" >
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('purchaes_date'))?($errors->first('purchaes_date')):''}}</div>
                                    </div>
                                </div>
                                <input type="hidden" value="3" name="purchase_status_id" class="form-control select2">


                                {{--  
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label style="display: block;" for="">Business location</label>
                                            <select id="business_location_id" name="business_location_id" class="form-control select2">
                                                <option value="">Business location</option>
                                                @foreach ($businessLocations as $item)
                                                    <option {{old('business_location_id') == $item->id ?'selected':''}} value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('business_location_id'))?($errors->first('business_location_id')):''}}</div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="getStockByStockId" value="{{route('admin.purchase.product.getStockByStockId')}}" />
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label style="display: block;" for="">Stock Type</label>
                                            <select id="stock_type_id" name="stock_type_id" class="stock_type_id_class form-control select2">
                                                <option value="">Stock Type</option>
                                                @foreach ($stockTypes as $item)
                                                    <option {{old('stock_type_id') == $item->id ?'selected':''}} value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('stock_type_id'))?($errors->first('stock_type_id')):''}}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label style="display: block;" for="">Stock <small>(Product Store in This Stock)</small></label>
                                            <select id="stock_id" name="stock_id" class="stock_id_class form-control select2">
                                                <option value="">Select Stock Type First</option>
                                            </select>
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('stock_id'))?($errors->first('stock_id')):''}}</div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Attachment File </label>
                                            <input name="file" value="" type="file" class="form-control">
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('file'))?($errors->first('file')):''}}</div>
                                        </div>
                                    </div>  
                                --}}

                                <div class="col-sm-12 col-md-12"><br/></div>


                                <div class="col-sm-1 col-md-1"></div>


                                <input type="hidden" id="searchingProductByAjax" value="{{route('admin.purchase.product.searchingProductByAjax')}}"/>
                                <input type="hidden" id="addToCartSingleProductByResultOfSearchingByAjax" value="{{route('admin.purchase.product.addToCartSingleProductByResultOfSearchingByAjax')}}"/>
                                <div class="col-sm-8 col-md-7">
                                    <div class="form-group dropdown">
                                    <label for="">Product Name/SKU/Bar Code </label>
                                        <input  type="text" id="p_name_sku_bar_code_id" value="" class="form-control p_name_sku_bar_code_id_class" placeholder="Product Name/SKU/Bar Code">
                                        <div id="product_list" class="" > </div>
                                            <style>
                                                .dropdown .dropdown-menu {
                                                    top: 55px;
                                                    width:100%;
                                                }
                                            </style>
                                        </div>
                                    </div>


                                <!-----add product------>
                                <div class="col-sm-2 col-md-2">
                                    <label for="">&nbsp; </label> <br/>
                                    <a class="btn btn-sm btn-primary" disabled>
                                        <i class="fa fa-plus"></i>
                                        Add Product
                                    </a>
                                </div>
                                    <!-----add product end------>
                                {{--  <div class="col-sm-2 col-md-2" style="margin-left:-2%;">
                                    <label for="">&nbsp; </label> <br/>
                                    <a id="pullLowStockProductId" data-target="#pullLowStockProduct" data-toggle="modal" class="btn btn-sm btn-primary">
                                        <i class="fa fa-plus"></i>
                                        Pull Low Stock Product
                                    </a>
                                </div>  --}}

                                <div class="col-sm-12 col-md-12"><br/></div>

                                <!--------Add to cart table---->
                                <div class="col-sm-12 col-md-12">
                                    <table  class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Product Name</th>
                                                <th>Product <br> Quantity</th>
                                                <th>Product <br/>Unit Price <br/> (Before Discount)</th>
                                                <th style="width:4%;">Discount<br/> Percent</th>
                                                <th><small>After Discount</small><br/>Purchase <br/>Unit Price<br/> (Before Tax)</th>
                                                <th style="display:none">Subtotal <br/>(Before Tax)</th>
                                                <th style="width:4%;display:none">Product<br/> Tax</th>
                                                <th style="display:none">Net Cost<br/><small>(Purchase<br/>Amount Inc Tax)</small></th>
                                                <th>Line Total<br/>(Total Purchase<br/>Amount)</th>
                                                <th style="width:6%; color:blue;">Profit <br/> Margin %</th>
                                                <th style="width:8%; color:blue;"> Sale Price</th>     <!---Unit Selling <br/>Price (Inc. tax)--->

                                                <th style="width:8%;">MRP<br/>Sale Price</th>
                                                <th style="width:8%;">Whole <br/>Sale Price</th>
                                                <th style="width:8%;">Online<br/>Sale Price</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="showResult">
                                            </tbody>
                                            <tr>
                                                <td colspan="2">
                                                    Total Quantity
                                                </td>
                                                <td>
                                                    <strong id="totalQty"> 0 </strong>
                                                </td>
                                                <td colspan="3" style="text-align:right">Total Purchase Amount</td>
                                                <td>
                                                    <strong id="totalAmount"> 0 </strong>
                                                </td>
                                                <td colspan="5"></td>
                                                <td style="width:5%;">
                                                    <a href="#" id="removeAllCart" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;color:red;">
                                                        Clear
                                                    </a>
                                                </td>
                                            </tr>
                                    </table>
                                </div>
                                <!--------Add to cart table End---->

                            </div>
                            <!--------supplier, chalan,reference_no,invoice End---->


                            <div class="col-sm-12 col-md-12"><br/><br/> <hr/><br/></div><hr/>


                            <!--------Discount,Tax, Shipping, Middle part---->
                            <div class="col-sm-12 col-md-12">
                                <!----------purchase Discount----------->
                                <div class="row">
                                    <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Discount Type : </label>
                                                <select id="discount_type_id" name="discount_type" class="discount_type_id_class form-control">
                                                    <option value="">None</option>
                                                    <option {{old('discount_type_id') == 1?'selected':''}} value="1">Parcent</option>
                                                    <option {{old('discount_type_id') == 2?'selected':''}} value="2">Fixed</option>
                                                </select>
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('discount_type_id'))?($errors->first('discount_type_id')):''}}</div>
                                            </div>
                                        </div>
                                    <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Discount Amount: </label>
                                                <input  name="discount_value" id="discount_value" type="text" class="discount_value_class form-control" value="{{old('discount_value') ?? 0}}">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('discount_value'))?($errors->first('discount_value')):''}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Discount:(-) ৳ </label>
                                                <input name="discount_amount" value="{{old('discount_amount') ?? 0}}" id="discount_amount_id" type="text" readonly class="discount_amount_id_class form-control">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('discount_amount'))?($errors->first('discount_amount')):''}}</div>
                                            </div>
                                        </div>
                                </div>
                                <!----------purchase Discount-End---------->

                                <!----------purchase tax----------->
                                <div class="row">
                                    <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Purchase Tax: </label>
                                                <select name="purchase_tax_applicable" id="purchase_tax_applicable_id" class="purchase_tax_applicable_id_class form-control">
                                                    <option value="">None</option>
                                                    <option {{old('purchase_tax_applicable') == 1?'selected':''}} value="1">Parcent</option>
                                                    <option {{old('purchase_tax_applicable') == 2?'selected':''}} value="2">Fixed</option>
                                                </select>
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_tax_applicable'))?($errors->first('purchase_tax_applicable')):''}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Purchase Tax Value: </label>
                                                <input name="purchase_tax_in_parcent_value" type="text" id="purchase_tax_in_parcent_value_id" class="purchase_tax_in_parcent_value_id_class form-control" value="{{old('purchase_tax_in_parcent_value')??0}}">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_tax_in_parcent_value'))?($errors->first('purchase_tax_in_parcent_value')):''}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Purchase Tax:(+) ৳ </label>
                                                <input name="purchase_tax_amount" id="purchase_tax_amount_id" type="text" readonly class="purchase_tax_amount_class form-control" value="{{old('purchase_tax_amount')??0}}">
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_tax_amount'))?($errors->first('purchase_tax_amount')):''}}</div>
                                            </div>
                                        </div>
                                </div>
                                <!----------purchase tax End----------->

                                <!----------purchase shipping----------->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Shipping Details </label>
                                            <input name="address" type="text" value="{{old('address')}}" class="form-control" placeholder="Shipping Details">
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('address'))?($errors->first('address')):''}}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">(+) Additional Shipping charges: </label>
                                            <input name="additional_shipping_cost" id="additional_shipping_cost_id" type="text" class="additional_shipping_cost_id_class form-control" value="{{old('additional_shipping_cost')??0}}">
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('additional_shipping_cost'))?($errors->first('additional_shipping_cost')):''}}</div>
                                        </div>
                                    </div>
                                </div>
                                <!----------purchase shipping End----------->
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Total Purchase Amount </label>
                                            <input  value="{{old('total_purchase_amount')??0}}" readonly name="total_purchase_amount" type="text" class="total_purchase_amount_class form-control" style="font-size: 15px;color:green;font-weight:bold;">
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('total_purchase_amount'))?($errors->first('total_purchase_amount')):''}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Additional Notes</label>
                                    <textarea name="additional_note" value="" type="text" class="form-control"></textarea>
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('additional_note'))?($errors->first('additional_note')):''}}</div>
                                </div>
                            </div>
                            <!--------Discount,Tax, Shipping, Middle part End---->

                            <div class="col-sm-12 col-md-12">
                                    <br/> <hr/> <br/>
                            </div>


                            <!--------Payment part---->
                            <div class="col-sm-12 col-md-12"  style="display:none;">
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
                                            <input name="payment_amount" type="text" class="payment_amount_now_class form-control" value="0" style="font-size: 15px;color:green;font-weight:bold;">
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
                            <div class="col-sm-12 col-md-12 "  style="display:none;">
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
                            <div class="col-sm-12 col-md-12"  style="display:none;">
                                <div class="form-group">
                                    <label for="">Payment note: </label>
                                    <textarea name="payment_note" value="" type="text" class="form-control"></textarea>
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('payment_note'))?($errors->first('payment_note')):''}}</div>
                                </div>
                            </div>
                            <!---payment Note End--->

                            <!--------Payment part End--------->

                            <!--------Due part---->
                            <div class="col-sm-12 col-md-12"  style="display:none;">
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




                            <div class="col-sm-12 col-md-12"  style="display:none;">
                                    <hr/> <br/><br/>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input id="sumbitButton" type="submit" value="Submit" class="sumbitButton btn btn-primary">
                                        <a href="#" class="btn btn-info">Back</a>
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
<!-- /Page Content -->




    <div class="modal" id="baseOnMrpPriceModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close closeCalculationModel" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                        <div style="text-align:center;">
                            <h4 style="margin-top:-5px;margin-bottom: -7px;">
                                Change Price (based on MRP Price)
                            </h4>
                            <hr/>
                        </div>
                        <div>
                            <table  class="table table-bordered table-striped table-hover">
                                <tr>
                                    <td colspan="3" style="background-color:green;">
                                        <div class="row" >
                                            <div class="col-md-3" style="text-align:center;">
                                                <label style="margin-top:6px;color:white;font-weight:600;">MRP Price</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input data-id="mrp" type="number" step="any" id="reset_mrp_price" data-name="reset_mrp_price"  class="keyup_change reset_mrp_price form-control makeEmptyField" style="color:black;font-weight:600">
                                            </div>
                                            <input type="hidden" data-id="id_1_" class="all_mrp" />
                                            <input type="hidden" data-id="id_2_" class="all_mrp" />
                                            <input type="hidden" data-id="id_3_" class="all_mrp" />
                                        </div>
                                    </td>
                                    <td style="width:20%;"> <strong style="color:red;">=</strong> <small>(After Calculation)</small></td>
                                </tr>
                                <tr>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label style="color:green;">Set Sales Price</label>
                                            <input  data-id="id_1_" id="id_1_set"  type="number" data-priceType="set"  data-name="set_regular_sale_price"  step="any" class="keyup_change set_regular_sale_price form-control makeEmptyField">
                                        </div>
                                    </td>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label>Change Type</label>
                                            <select  data-id="id_1_" id="id_1_cng"   data-name="change_type_set_regular_sale_price" class="keyup_change change_type_set_regular_sale_price form-control">
                                                <option value="1">Percentage</option>
                                                <option value="2">Fixed</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label>Calculation Type</label>
                                            <select  data-id="id_1_" id="id_1_cal"  data-name="calculation_type_set_regular_sale_price" class="keyup_change calculation_type_set_regular_sale_price form-control">
                                                <option value="1">(+) Plus</option>
                                                <option selected value="2">(-) Minus</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label style="color:red;">Regular Price</label>
                                            <input  data-id="id_1_" id="id_1_rst"  type="number" data-priceType="reset" readonly step="any"  data-name="reset_regular_sale_price" class="keyup_change reset_regular_sale_price form-control makeEmptyField">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label style="color:green;">Set Whole Sale Price</label>
                                            <input data-id="id_2_" id="id_2_set" type="number" data-priceType="set"  step="any" data-name="set_whole_sale_price" class="keyup_change set_whole_sale_price form-control makeEmptyField">
                                        </div>
                                    </td>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label>Change Type</label>
                                            <select  data-id="id_2_" id="id_2_cng" data-name="change_type_set_whole_sale_price" class="keyup_change change_type_set_whole_sale_price form-control">
                                                <option value="1">Percentage</option>
                                                <option value="2">Fixed</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label>Calculation Type</label>
                                            <select data-id="id_2_" id="id_2_cal"  data-name="calculation_type_set_whole_sale_price" class="keyup_change calculation_type_set_whole_sale_price form-control">
                                                <option value="1">(+) Plus</option>
                                                <option selected value="2">(-) Minus</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label style="color:red;">Whole Sale Price</label>
                                            <input  data-id="id_2_" id="id_2_rst"  type="number" data-priceType="reset" readonly  data-name="reset_whole_sale_price" step="any" class="keyup_change reset_whole_sale_price form-control makeEmptyField">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label style="color:green;">Set Online Sale Price</label>
                                            <input data-id="id_3_" id="id_3_set" type="number" data-priceType="set" step="any"  data-name="set_online_sale_price"  class="keyup_change set_online_sale_price form-control makeEmptyField">
                                        </div>
                                    </td>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label>Change Type</label>
                                            <select data-id="id_3_" id="id_3_cng" data-name="change_type_set_online_sale_price"  class="keyup_change change_type_set_online_sale_price form-control">
                                                <option value="1">Percentage</option>
                                                <option value="2">Fixed</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label>Calculation Type</label>
                                            <select data-id="id_3_" id="id_3_cal" data-name="calculation_type_set_online_sale_price"  class="keyup_change calculation_type_set_online_sale_price form-control">
                                                <option value="1">(+) Plus</option>
                                                <option selected value="2">(-) Minus</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width:25%;">
                                        <div class="form-group">
                                            <label style="color:red;">Online Sale Price</label>
                                            <input data-id="id_3_" id="id_3_rst" type="number" readonly data-priceType="reset" step="any"   data-name="reset_online_sale_price"  class="keyup_change reset_online_sale_price form-control makeEmptyField">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <input type="hidden" class="product_id" />
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger closeCalculationModel" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary updateResultCalculationModel">Update Result</button>
                </div>

            </div>
        </div>
    </div>





<!-- Pull Low Stock Product modal -->
<div class="modal fade" id="pullLowStockProduct" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Pull Low Stock Product
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h4>

            </div>
            {{--  <form action="">  --}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Low Quantity <small>(Equal or below Of This Qty)</small> </label>
                                <input id="low_quantity_id" type="text" class="low_quantity_id_class form-control" placeholder="Equal or below Of This Qty">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Unit </label>
                                <select name="" id="unit_id" class="unit_id_class form-control">
                                    <option value="">Select Unit</option>
                                    @foreach ($units as $item)
                                        @if ($item->short_name)
                                            <option value="{{$item->id}}">{{$item->short_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Category </label>
                                <select name="" id="category_id" class="category_id_class form-control">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Brand </label>
                                <select name="" id="brand_id" class="brand_id_classs form-control">
                                    <option value="">Select Brand</option>
                                   @foreach ($brands as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a data-url="{{route('admin.purchase.product.pullingProductByAjax')}}" id="pullingLowProductListByAjax"  class="btn btn-info">Pull Now</a>
                </div>
            {{--  </form>  --}}
        </div>
    </div>
</div>

<!-----------Card Exist------------>
    <input type="hidden" id="purchaseCartIfExist" value="{{route('admin.purchase.product.purchaseCartIfExist')}}"/>
<!-----------Card Exist------------>

<!-----------Update single Card------------>
    <input type="hidden" id="updateSinglePurchaseCartByAjax" value="{{route('admin.purchase.product.updateSinglePurchaseCartByAjax')}}"/>
<!-----------Update single Card------------>
<!-----------Purchase Remove Single ANd All Cart------------>
    <input type="hidden" id="removeSinglePurchaseCart" value="{{route('admin.purchase.product.removeSinglePurchaseCart')}}"/>
    <input type="hidden" id="removeAllPurchaseCart" value="{{route('admin.purchase.product.removeAllPurchaseCart')}}"/>
<!-----------Purchase Remove Single ANd All Cart------------>


<!-- Purchase unit modal -->
<div class="modal fade" id="addPurchaseUnitModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Unit
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h4>

            </div>
            <form id="addPurchaseUnit" action="{{route('unitCreateByAjax')}}" method="POST">
            @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Unit Name </label>
                        <input name="name" type="text" class="form-control" placeholder="Unit Name">
                        <span id="name_0"></span>
                    </div>
                    <div class="form-group">
                        <label>Description </label>
                        <input name="description" type="text" class="form-control" placeholder="Description">
                    <span id="description_1"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Supplier modal -->
<div class="modal fade" id="supplierModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Supplier
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h4>

            </div>
            <form action="{{route('supplierCreateByAjax')}}" method="POST" id="addSupplier">
            @csrf
            <div class="modal-body">
                    <div class="form-group">
                        <label>Supplier Name* </label>
                        <input type="text" required name="name" class="form-control" placeholder="Supplier Name">
                    </div>
                    <div class="form-group">
                        <label>Contact Person*</label>
                        <input type="text" name="contract_person" class="form-control" placeholder="Contact Person">
                    </div>
                    <div class="form-group">
                        <label>Phone*</label>
                        <input type="text" name="phone" class="form-control" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <label>Email </label>
                        <input type="text" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label>Previour Due </label>
                        <input type="number" name="previous_due" step="any" class="form-control" placeholder="Previour Due">
                    </div>
                    <div class="form-group">
                        <label>Address </label>
                        <textarea name="address" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Description </label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="supplierSubmit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


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

        <script>
            $(document).ready(function(){



                //=========================== Add Supplier==============================
                        $('#addSupplier').on("submit",function(e){
                        e.preventDefault();

                        var form = $(this);
                        var url = form.attr("action");
                        var type = form.attr("method");
                        var data = form.serialize();
                                $.ajax({
                                url: url,
                                data: data,
                                type: type,
                                datatype:"JSON",
                                beforeSend:function(){
                                    //$('.loading').fadeIn();
                                },
                                success: function(response){
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#supplier_id").html(html);
                                                $('#supplierModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#supplier_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }else{
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                complete:function(){
                                    //$('.loading').fadeOut();
                                    console.log('complete');
                                },
                        });
                        //end ajax
                        });
                //=========================== Add Supplier==============================


                //=========================== Add Category==============================
                    $('#addCategory').on("submit",function(ee){
                        ee.preventDefault();

                        var form = $(this);
                        var url = form.attr("action");
                        var type = form.attr("method");
                        var data = form.serialize();
                                $.ajax({
                                url: url,
                                data: data,
                                type: type,
                                datatype:"JSON",
                                beforeSend:function(){
                                    //$('.loading').fadeIn();
                                },
                                success: function(response){
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#category_id").html(html);
                                                $('#categoryModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#category_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }else{
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                complete:function(){
                                    //$('.loading').fadeOut();
                                    console.log('complete');
                                },
                        });
                        //end ajax
                    });
                //=========================== Add Category==============================


                //=========================== Add Brand==============================
                    $('#addBrand').on("submit",function(ee){
                        ee.preventDefault();

                        var form = $(this);
                        var url = form.attr("action");
                        var type = form.attr("method");
                        var data = form.serialize();
                                $.ajax({
                                url: url,
                                data: data,
                                type: type,
                                datatype:"JSON",
                                beforeSend:function(){
                                    //$('.loading').fadeIn();
                                },
                                success: function(response){
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#brand_id").html(html);
                                                $('#addBrandModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#brand_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }else{
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                complete:function(){
                                    //$('.loading').fadeOut();
                                    console.log('complete');
                                },
                        });
                        //end ajax
                    });
                //=========================== Add Brand==============================


                //=========================== Add Unit==============================
                    $('#addPurchaseUnit').on("submit",function(ee){
                        ee.preventDefault();

                        var form = $(this);
                        var url = form.attr("action");
                        var type = form.attr("method");
                        var data = form.serialize();
                                $.ajax({
                                url: url,
                                data: data,
                                type: type,
                                datatype:"JSON",
                                beforeSend:function(){
                                    //$('.loading').fadeIn();
                                },
                                success: function(response){
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].short_name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#purchase_unit_id").html(html);
                                                $('#addPurchaseUnitModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#purchase_unit_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }
                                        else  if(response.status == 'errors')
                                        {
                                            console.log('ekhanne');
                                             console.log(response['data']);
                                            var leng = 0;
                                            if(response['data'] != null){
                                                leng = response['data'].length;
                                            }

                                            if(leng > 0){
                                                // Read data and create <option >
                                                for(var i=0; i<leng; i++){
                                                    //var id = response['data'][i].id;
                                                    //var name = response['data'][i].name;
                                                    console.log('leng');
                                                    $("#name_0").text('dkfj');
                                                    //$("#name_"+i).text(response['data'][i].name);
                                                }

                                            }
                                        }
                                        else{
                                            console.log('nai');
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                 error: function (reject) {
                                    if( reject.status === 422 ) {
                                        var errors = $.parseJSON(reject.responseText);
                                        $.each(errors, function (key, val) {
                                            $("#" + key + "_error").text(val[0]);
                                        });
                                    }
                                },
                                complete:function(reject){

                                    if( reject.status === 'errors' ) {
                                        console.log('eee');
                                        var errors = $.parseJSON(reject.responseText);
                                        $.each(errors, function (key, val) {
                                            $("#name_"+key).text(val[0]);
                                        });
                                    }


                                    //$('.loading').fadeOut();
                                    console.log('complete');
                                },
                        });
                        //end ajax
                    });
                //=========================== Add Unit==============================



            });
        </script>

        <script src="{{ asset('public') }}/custom_js/backend/purchase/create.js?v=1"></script>

        <!---- payment methods----->
        <script src="{{ asset('public') }}/custom_js/backend/payment/add_payment_methods.js?v=1"></script>
        <!---- payment methods----->
    @endpush

 @endsection





{{-----
@extends('home')
@section('title','Purchase Quotation')
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
            <li class="active"> Purchase</li>
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
              Purchase Quotation
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
                        <span class="widget-caption" style="font-size: 20px">Purchase Quotation</span>
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
                        <form action="{{route('admin.purchase.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!--------supplier, chalan,reference_no,invoice---->
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label style="display: block;" for="">Supplier / Vendor <a href="#" data-target="#supplierModal" data-toggle="modal" class="pull-right "><i style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;color:black;" class="fa fa-plus"></i></a> </label>
                                    <select id="supplier_id" name="supplier_id" class="form-control select2">
                                        <option value="">Select Supplier/Vendor</option>
                                        @foreach ($suppliers as $item)
                                            <option value="{{$item->id}}">{{$item->name}} - ({{$item->phone}}) - ({{$item->email}})</option>
                                        @endforeach
                                    </select>
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('supplier_id'))?($errors->first('supplier_id')):''}}</div>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Reference No</label>
                                    <input name="reference_no" type="text" value="" placeholder="Reference No" class="form-control">
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('reference_no'))?($errors->first('reference_no')):''}}</div>
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3" style="display:none;">
                                <div class="form-group">
                                    <label for="">Quotation No</label>
                                    <input name="invoice_no" type="text" value="{{date('Y').date('d').date('m').date('his').mt_rand(10,99)}}" placeholder="Invoice No" class="form-control">
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('invoice_no'))?($errors->first('invoice_no')):''}}</div>
                                </div>
                            </div>
 
  

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Quotation Date </label>
                                    <input name="purchaes_date" value="" type="date" class="form-control" >
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('purchaes_date'))?($errors->first('purchaes_date')):''}}</div>
                                </div>
                            </div>

                            
 
 

                            <div class="col-sm-12 col-md-12"><br/></div>


                            <div class="col-sm-1 col-md-1"></div>


                            <input type="hidden" id="searchingProductByAjax" value=""/>
                            <input type="hidden" id="addToCartSingleProductByResultOfSearchingByAjax" value=""/>
                            <div class="col-sm-8 col-md-7">
                                <div class="form-group dropdown">
                                <label for="">Product Name/SKU/Bar Code </label>
                                    <input  type="text" id="p_name_sku_bar_code_id" value="" class="form-control p_name_sku_bar_code_id_class" placeholder="Product Name/SKU/Bar Code">
                                    <div id="product_list" class="" > </div>
                                        <style>
                                            .dropdown .dropdown-menu {
                                                top: 55px;
                                                width:100%;
                                            }
                                        </style>
                                    </div>
                                </div>


                            <!-----add product------>
                            <div class="col-sm-2 col-md-2">
                                <label for="">&nbsp; </label> <br/>
                                <a class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus"></i>
                                    Add Product
                                </a>
                            </div>
                              

                          
                            <!--------Add to cart table---->
                            <div class="col-sm-12 col-md-12">
                                <table  class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl.No</th>
                                            <th>Product Name</th>
                                            <th>Purchase <br> Quantity</th>
                                            <th>Purchase <br/>Unit Price </th>
                                            
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        	<tr>
                                        		<td>01 </td>
                                        		<td> Pipe </td>
                                        		<td> 10</td>
                                        		<td> 100</td>
                                        		<td> <a href="" title="">delete</a> </td>
                                        	</tr><tr>
                                        		<td>01 </td>
                                        		<td> Pipe </td>
                                        		<td> 10</td>
                                        		<td> 100</td>
                                        		<td> <a href="" title="">delete</a> </td>
                                        	</tr><tr>
                                        		<td>01 </td>
                                        		<td> Pipe </td>
                                        		<td> 10</td>
                                        		<td> 100</td>
                                        		<td> <a href="" title="">delete</a> </td>
                                        	</tr><tr>
                                        		<td>01 </td>
                                        		<td> Pipe </td>
                                        		<td> 10</td>
                                        		<td> 100</td>
                                        		<td> <a href="" title="">delete</a> </td>
                                        	</tr>

                                        </tbody>
                                        <tr>
                                            <td colspan="2">
                                                Total Quantity
                                            </td>
                                            <td>
                                                <strong id="totalQty"> 0 </strong>
                                            </td>
                                            
                                            <td>
                                                <strong id="totalAmount"> 0 </strong>
                                            </td>
                                    
                                            <td style="width:5%;">
                                                <a href="#" id="removeAllCart" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;color:red;">
                                                    Clear
                                                </a>
                                            </td>
                                        </tr>
                                </table>
                            </div>
                            <!--------Add to cart table End---->

                        </div>
                        <!--------supplier, chalan,reference_no,invoice End---->


                     
                       


                        <div class="col-sm-12 col-md-12">
                                 <hr/> <br/><br/>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input id="sumbitButton" type="submit" value="Submit" class="btn btn-primary">
                                    <a href="#" class="btn btn-info">Back</a>
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
<!-- /Page Content -->





<!-- Pull Low Stock Product modal -->
<div class="modal fade" id="pullLowStockProduct" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Pull Low Stock Product
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </h4>

        </div>
        
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Low Quantity <small>(Equal or below Of This Qty)</small> </label>
                            <input id="low_quantity_id" type="text" class="low_quantity_id_class form-control" placeholder="Equal or below Of This Qty">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Unit </label>
                            <select name="" id="unit_id" class="unit_id_class form-control">
                                <option value="">Select Unit</option>
                                @foreach ($units as $item)
                                    @if ($item->short_name)
                                        <option value="{{$item->id}}">{{$item->short_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Category </label>
                            <select name="" id="category_id" class="category_id_class form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Brand </label>
                            <select name="" id="brand_id" class="brand_id_classs form-control">
                                <option value="">Select Brand</option>
                               @foreach ($brands as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a data-url="{{route('admin.purchase.product.pullingProductByAjax')}}" id="pullingLowProductListByAjax"  class="btn btn-info">Pull Now</a>
            </div>
        
    </div>
</div>
</div>

<!-----------Card Exist------------>
<input type="hidden" id="purchaseCartIfExist" value="{{route('admin.purchase.product.purchaseCartIfExist')}}"/>
<!-----------Card Exist------------>

<!-----------Update single Card------------>
<input type="hidden" id="updateSinglePurchaseCartByAjax" value="{{route('admin.purchase.product.updateSinglePurchaseCartByAjax')}}"/>
<!-----------Update single Card------------>
<!-----------Purchase Remove Single ANd All Cart------------>
<input type="hidden" id="removeSinglePurchaseCart" value="{{route('admin.purchase.product.removeSinglePurchaseCart')}}"/>
<input type="hidden" id="removeAllPurchaseCart" value="{{route('admin.purchase.product.removeAllPurchaseCart')}}"/>
<!-----------Purchase Remove Single ANd All Cart------------>


<!-- Purchase unit modal -->
<div class="modal fade" id="addPurchaseUnitModal" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Unit
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </h4>

        </div>
        <form id="addPurchaseUnit" action="{{route('unitCreateByAjax')}}" method="POST">
        @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Unit Name </label>
                    <input name="name" type="text" class="form-control" placeholder="Unit Name">
                    <span id="name_0"></span>
                </div>
                <div class="form-group">
                    <label>Description </label>
                    <input name="description" type="text" class="form-control" placeholder="Description">
                <span id="description_1"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-info">Submit</button>
            </div>
        </form>
    </div>
</div>
</div>




<!-- Supplier modal -->
<div class="modal fade" id="supplierModal" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Supplier
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </h4>

        </div>
        <form action="{{route('supplierCreateByAjax')}}" method="POST" id="addSupplier">
        @csrf
        <div class="modal-body">
                <div class="form-group">
                    <label>Supplier Name* </label>
                    <input type="text" required name="name" class="form-control" placeholder="Supplier Name">
                </div>
                <div class="form-group">
                    <label>Contact Person*</label>
                    <input type="text" name="contract_person" class="form-control" placeholder="Contact Person">
                </div>
                <div class="form-group">
                    <label>Phone*</label>
                    <input type="text" name="phone" class="form-control" placeholder="Phone">
                </div>
                <div class="form-group">
                    <label>Email </label>
                    <input type="text" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label>Previour Due </label>
                    <input type="number" name="previous_due" step="any" class="form-control" placeholder="Previour Due">
                </div>
                <div class="form-group">
                    <label>Address </label>
                    <textarea name="address" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Description </label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" id="supplierSubmit" class="btn btn-info">Submit</button>
            </div>
        </form>
    </div>
</div>
</div>


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

    <script>
        $(document).ready(function(){



            //=========================== Add Supplier==============================
                    $('#addSupplier').on("submit",function(e){
                    e.preventDefault();

                    var form = $(this);
                    var url = form.attr("action");
                    var type = form.attr("method");
                    var data = form.serialize();
                            $.ajax({
                            url: url,
                            data: data,
                            type: type,
                            datatype:"JSON",
                            beforeSend:function(){
                                //$('.loading').fadeIn();
                            },
                            success: function(response){
                                    //===================Perfect Working===================
                                    if(response.status == 'success')
                                    {
                                        var len = 0;
                                        if(response['data'] != null){
                                            len = response['data'].length;
                                        }

                                        if(len > 0){
                                            // Read data and create <option >
                                            var html = '';
                                            for(var i=0; i<len; i++){
                                                var id = response['data'][i].id;
                                                var name = response['data'][i].name;
                                                html += "<option value='"+id+"'>"+name+"</option>";
                                            }
                                            $("#supplier_id").html(html);
                                            $('#supplierModal').modal("hide");
                                            form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }

                                        //=========this is also perfect working
                                        //$("#supplier_id").html(response.data);
                                        //$('#supplierModal').modal("hide");
                                        //swal("Great","Successfully Updated Information","success");
                                        //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                    }else{
                                        //console.log('nai');
                                        //swal("Wrong","Information is not Updated","error");
                                    }
                                    //====================Perfect Working====================


                                },
                            complete:function(){
                                //$('.loading').fadeOut();
                                console.log('complete');
                            },
                    });
                    //end ajax
                    });
            //=========================== Add Supplier==============================


            //=========================== Add Category==============================
                $('#addCategory').on("submit",function(ee){
                    ee.preventDefault();

                    var form = $(this);
                    var url = form.attr("action");
                    var type = form.attr("method");
                    var data = form.serialize();
                            $.ajax({
                            url: url,
                            data: data,
                            type: type,
                            datatype:"JSON",
                            beforeSend:function(){
                                //$('.loading').fadeIn();
                            },
                            success: function(response){
                                    //===================Perfect Working===================
                                    if(response.status == 'success')
                                    {
                                        var len = 0;
                                        if(response['data'] != null){
                                            len = response['data'].length;
                                        }

                                        if(len > 0){
                                            // Read data and create <option >
                                            var html = '';
                                            for(var i=0; i<len; i++){
                                                var id = response['data'][i].id;
                                                var name = response['data'][i].name;
                                                html += "<option value='"+id+"'>"+name+"</option>";
                                            }
                                            $("#category_id").html(html);
                                            $('#categoryModal').modal("hide");
                                            form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }

                                        //=========this is also perfect working
                                        //$("#category_id").html(response.data);
                                        //$('#supplierModal').modal("hide");
                                        //swal("Great","Successfully Updated Information","success");
                                        //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                    }else{
                                        //console.log('nai');
                                        //swal("Wrong","Information is not Updated","error");
                                    }
                                    //====================Perfect Working====================


                                },
                            complete:function(){
                                //$('.loading').fadeOut();
                                console.log('complete');
                            },
                    });
                    //end ajax
                });
            //=========================== Add Category==============================


            //=========================== Add Brand==============================
                $('#addBrand').on("submit",function(ee){
                    ee.preventDefault();

                    var form = $(this);
                    var url = form.attr("action");
                    var type = form.attr("method");
                    var data = form.serialize();
                            $.ajax({
                            url: url,
                            data: data,
                            type: type,
                            datatype:"JSON",
                            beforeSend:function(){
                                //$('.loading').fadeIn();
                            },
                            success: function(response){
                                    //===================Perfect Working===================
                                    if(response.status == 'success')
                                    {
                                        var len = 0;
                                        if(response['data'] != null){
                                            len = response['data'].length;
                                        }

                                        if(len > 0){
                                            // Read data and create <option >
                                            var html = '';
                                            for(var i=0; i<len; i++){
                                                var id = response['data'][i].id;
                                                var name = response['data'][i].name;
                                                html += "<option value='"+id+"'>"+name+"</option>";
                                            }
                                            $("#brand_id").html(html);
                                            $('#addBrandModal').modal("hide");
                                            form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }

                                        //=========this is also perfect working
                                        //$("#brand_id").html(response.data);
                                        //$('#supplierModal').modal("hide");
                                        //swal("Great","Successfully Updated Information","success");
                                        //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                    }else{
                                        //console.log('nai');
                                        //swal("Wrong","Information is not Updated","error");
                                    }
                                    //====================Perfect Working====================


                                },
                            complete:function(){
                                //$('.loading').fadeOut();
                                console.log('complete');
                            },
                    });
                    //end ajax
                });
            //=========================== Add Brand==============================


            //=========================== Add Unit==============================
                $('#addPurchaseUnit').on("submit",function(ee){
                    ee.preventDefault();

                    var form = $(this);
                    var url = form.attr("action");
                    var type = form.attr("method");
                    var data = form.serialize();
                            $.ajax({
                            url: url,
                            data: data,
                            type: type,
                            datatype:"JSON",
                            beforeSend:function(){
                                //$('.loading').fadeIn();
                            },
                            success: function(response){
                                    //===================Perfect Working===================
                                    if(response.status == 'success')
                                    {
                                        var len = 0;
                                        if(response['data'] != null){
                                            len = response['data'].length;
                                        }

                                        if(len > 0){
                                            // Read data and create <option >
                                            var html = '';
                                            for(var i=0; i<len; i++){
                                                var id = response['data'][i].id;
                                                var name = response['data'][i].short_name;
                                                html += "<option value='"+id+"'>"+name+"</option>";
                                            }
                                            $("#purchase_unit_id").html(html);
                                            $('#addPurchaseUnitModal').modal("hide");
                                            form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }

                                        //=========this is also perfect working
                                        //$("#purchase_unit_id").html(response.data);
                                        //$('#supplierModal').modal("hide");
                                        //swal("Great","Successfully Updated Information","success");
                                        //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                    }
                                    else  if(response.status == 'errors')
                                    {
                                        console.log('ekhanne');
                                         console.log(response['data']);
                                        var leng = 0;
                                        if(response['data'] != null){
                                            leng = response['data'].length;
                                        }

                                        if(leng > 0){
                                            // Read data and create <option >
                                            for(var i=0; i<leng; i++){
                                                //var id = response['data'][i].id;
                                                //var name = response['data'][i].name;
                                                console.log('leng');
                                                $("#name_0").text('dkfj');
                                                //$("#name_"+i).text(response['data'][i].name);
                                            }

                                        }
                                    }
                                    else{
                                        console.log('nai');
                                        //console.log('nai');
                                        //swal("Wrong","Information is not Updated","error");
                                    }
                                    //====================Perfect Working====================


                                },
                             error: function (reject) {
                                if( reject.status === 422 ) {
                                    var errors = $.parseJSON(reject.responseText);
                                    $.each(errors, function (key, val) {
                                        $("#" + key + "_error").text(val[0]);
                                    });
                                }
                            },
                            complete:function(reject){

                                if( reject.status === 'errors' ) {
                                    console.log('eee');
                                    var errors = $.parseJSON(reject.responseText);
                                    $.each(errors, function (key, val) {
                                        $("#name_"+key).text(val[0]);
                                    });
                                }


                                //$('.loading').fadeOut();
                                console.log('complete');
                            },
                    });
                    //end ajax
                });
            //=========================== Add Unit==============================



        });
    </script>

    <script src="{{ asset('public') }}/custom_js/backend/purchase/create.js?v=1"></script>
@endpush

@endsection
--}}