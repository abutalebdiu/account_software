@extends('home')
@section('title',' Edit Sale Invoice')
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
            <li class="active">Sale Edit </li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">
            <h1>
                Inovice No : {{$sale_final->order_no}}
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
                        <span class="widget-caption" style="font-size: 20px">
                        Quotation No :  {{ $sale_final->quotationInvoices ? $sale_final->quotationInvoices->quotation_no:NULL}} (Complete Sale)
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




                    <form action="{{route('sale.quotationUpdate',$sale_final->id)}}" method="POST">
                        @csrf

                        <input type="hidden" value="{{$sale_final->id}}" name="sale_final_id" />
                        <div class="widget-body" style="background-color: #fff;">

                            <!----------------Top Section---------------->
                            <div class="row" style="margin: 30px 0;">
                                <div class="col-md-6">
                                     <label style="display: block;" for="">Customer* <a href="#" data-toggle="modal" data-target="#add-customer"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                    <select name="customer_id" class="customer_id form-control">
                                        @foreach ($customers as $item)
                                            <option {{$sale_final->customer_id == $item->id?'selected':''}} value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label style="display: block;" for="">Reference* <a href="#" data-toggle="modal" data-target="#add-reference"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                    <select name="reference_id" class="reference_id form-control  select2" style="width: 100%">
                                        <option value="">Select Reference</option>
                                        @foreach ($references as $item)
                                        <option {{$sale_final->reference_id == $item->id?'selected':''}}  value="{{$item->id}}">{{$item->name}} ({{$item->phone}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Status:*</label>
                                    <select name="invoice_status" class="form-control">
                                        <option value="1">Final</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Sale Date:*</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <!----------------Top Section---------------->
                            <br/> <hr/><br/>


                            <!----------------Product Section---------------->
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="form-group dropdown">
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-default bg-white btn-flat" data-toggle="modal" data-target="#configure_search_modal" title="Configure product search"><i class="fa fa-barcode"></i></button>
                                                    </div>
                                                    <input class="form-control mousetrap ui-autocomplete-input p_name_sku_bar_code_id_class" id="p_name_sku_bar_code_id" placeholder="Enter Product name / SKU / Scan bar code" autofocus="" name="" type="text" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-default bg-white btn-flat pos_add_quick_product" data-href="http://400.dsbpos.com/products/quick_add" data-container=".quick_add_product_modal">
                                                            <i class="fa fa-plus-circle text-primary fa-lg"></i>
                                                        </button>
                                                    </span>
                                                        <div id="product_list" class="" > </div>
                                                            <style>
                                                                .dropdown .dropdown-menu {
                                                                    top: 30px;
                                                                    width:100%;
                                                                }
                                                            </style>
                                                </div>

                                                    <!---serach product by sku barcode,pname--->
                                                    <input type="hidden" id="searchingProductByAjax" value="{{route('sale.searchProductBySkyBarCodeForAddToCartWhenSaleEdit')}}" >
                                                    <input type="hidden" id="addToCartSingleProductByResultOfSearchingByAjax" value="{{route('sale.addToCartSingleProductByResultOfSearchingByAjax')}}"/>
                                            </div>
                                        </div>

                                        <div class="row col-sm-12  pos_product_div" style="min-height: 219.87px;">
                                            <input type="hidden" name="sell_price_tax" id="sell_price_tax" value="includes" />

                                            <div class="table-responsive" style="margin-left:2%;">
                                                <table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:4%;">Sl.No</th>
                                                            <th class="text-center">
                                                                Product
                                                            </th>
                                                            <th class="text-center">
                                                                Unit
                                                            </th>
                                                            <th class="text-center" style="width:20%;">
                                                                Quantity
                                                            </th>
                                                            <th class="text-center" style="width:10%;">
                                                                Price inc. tax
                                                            </th>
                                                            <th class="text-center">
                                                                Subtotal
                                                            </th>
                                                            <th class="text-center"><i class="fa fa-close" aria-hidden="true"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="showResult">

                                                    </tbody>
                                                </table>
                                            </div>


                                            <div class="table-responsive" style="margin-left:2%;">
                                                <table class="table table-condensed table-bordered table-striped table-responsive">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:75%;border-right-style: hidden;" colspan="5"></td>
                                                            <td >
                                                                <div class="">
                                                                    <b>Items:</b>
                                                                    <span class="total_quantity cr_totalItemShow_class"></span>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <b>Total: </b>
                                                                    <span class="price_total cr_subTotal_class"></span>
                                                                </div>
                                                            </td>
                                                            <td  style="width:4%;border-left-style: hidden;" >
                                                                <a class="remove_all_row">
                                                                    <i class="fa fa-times text-danger " aria-hidden="true" style="cursor: pointer"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----------------Product Section---------------->




                            <hr/>
                            <br/><br/><br/>


                            <!----------------Discount Section---------------->
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="discount_type">Less Amount Type:*</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </span>
                                                    <select class="form-control cr_subDiscountTypeClass" required="" data-default="fixedValue"  name="discount_type" aria-required="true">
                                                        <option {{$sale_final->discount_type == 'fixedValue' ?'selected':''}} value="fixedValue">Fixed</option>
                                                        <option {{$sale_final->discount_type == 'percentageValue' ?'selected':''}} value="percentageValue" >Percentage</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="discount_amount">Less Amount:*</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </span>
                                                    <input class="form-control cr_mainDiscountValueClass " data-default="0.00" data-max-discount="" data-max-discount-error_msg="You can give max % discount per sale" name="discount_value" type="text" value="{{$sale_final->discount_value}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <br />
                                            <b>Toal Less Amount:</b>(-)
                                            <span class="cr_discountedAmountOfSubTotalClass ">{{$sale_final->discount_amount}}</span>
                                            <input type="hidden" value="" name="discount_amount" class="cr_discountedAmountOfSubTotal_Class " />
                                        </div>
                                        <div class="clearfix"></div>

                                        {{--
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tax_rate_id">Order Tax:*</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-info"></i>
                                                        </span>
                                                        <select class="form-control" id="tax_rate_id" name="tax_rate_id">
                                                            <option selected="selected" value="">Please Select</option>
                                                            <option value="" selected="selected">None</option>
                                                        </select>
                                                        <input type="hidden" name="tax_calculation_amount" id="tax_calculation_amount" value="0.00" data-default="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-md-offset-4">
                                                <b>Order Tax:</b>(+)
                                                <span class="display_currency" id="order_tax">0.00</span>
                                            </div>
                                        --}}
                                        <div class="clearfix"></div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="shipping_details">Shipping Details</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </span>
                                                    <textarea class="form-control" placeholder="Shipping Details" rows="1" cols="30" name="shipping_details" id="shipping_details"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="shipping_address">Shipping Address</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-map-marker"></i>
                                                    </span>
                                                    <textarea class="form-control" placeholder="Shipping Address" rows="1" cols="30" name="shipping_address" id="shipping_address"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="shipping_charges">Shipping Charges</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-info"></i>
                                                    </span>
                                                    <input class="form-control cr_otherCostShippingCost_Class" placeholder="Shipping Charges" name="shipping_cost" type="text" value="{{$sale_final->shipping_cost}}" />
                                                </div>
                                            </div>
                                        </div>
                                        {{--  <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="shipping_status">Shipping Status</label>
                                                <select class="form-control" id="shipping_status" name="shipping_status">
                                                    <option selected="selected" value="">Please Select</option>
                                                    <option value="ordered">Ordered</option>
                                                    <option value="packed">Packed</option>
                                                    <option value="shipped">Shipped</option>
                                                    <option value="delivered">Delivered</option>
                                                    <option value="cancelled">Cancelled</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="delivered_to">Delivered To:</label>
                                                <input class="form-control" placeholder="Delivered To" name="delivered_to" type="text" id="delivered_to" />
                                            </div>
                                        </div>  --}}
                                        <div class="col-md-4 col-md-offset-8">
                                            <div>
                                                <b>Total Payable: </b>
                                                <span class="cr_payableAmount_class"></span>
                                                <input type="hidden" name="final_total" class="cr_payableAmountClass" value="" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="sell_note">Sell note:</label>
                                                <textarea class="form-control" rows="3" name="sale_note" cols="50"></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="is_direct_sale" value="1" />
                                        <div class="col-md-12 text-right">
                                            <input id="is_save_and_print" name="is_save_and_print" type="hidden" value="0" />
                                            <a href="{{route('sale.saleView')}}" class="btn btn-info">Sale Back </a>
                                            <a href="{{route('sale.saleQuotationList')}}" class="btn btn-info">Quotation Back </a>
                                            <input type="submit" class="btn btn-primary updateButton_class " id="submit-sell" value="Update">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----------------Discount Section---------------->

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Body -->
</div>
<!-- /Page Content -->



    

    <!-- Add customer modal -->
    <div class="modal fade" id="add-customer" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Customer
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>

                </div>
                <form action="{{route('createCustomerByAjax')}}" method="POST" class="customerCreate">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Name </label>
                                    <input type="text" name="name" class="form-control" placeholder="Customer Name">
                                    <strong class="name_err color-red"></strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone </label>
                                    <input type="text" name="phone" class="form-control" placeholder="Phone">
                                    <strong class="phone_err color-red"></strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email </label>
                                    <input type="text" name="email" class="form-control" placeholder="Email">
                                    <strong class="email_err color-red"></strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>NID No</label>
                                    <input type="text" name="nid_no" class="form-control" placeholder="NID No">
                                    <strong class="nid_no_err color-red"></strong>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date of Birth </label>
                                    <input type="date" name="birth_date" class="form-control">
                                    <strong class="birth_date_err color-red"></strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date of Anniversary </label>
                                    <input type="date" name="anniversary_date" class="form-control">
                                    <strong class="anniversary_date_err color-red"></strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Address </label>
                                    <input name="address" placeholder="Address" class="form-control">
                                    <strong class="address_err color-red"></strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Company Name </label>
                                    <input name="company_name" placeholder="Address" class="form-control">
                                    <strong class="company_name_err color-red"></strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Delivery Address </label>
                                    <input name="shipping_address" placeholder="Address" class="form-control">
                                    <strong class="shipping_address_err color-red"></strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Previous Due </label>
                                    <input type="text" name="previous_due" class="form-control" placeholder="Previous Due">
                                    <strong class="previous_due_err color-red"></strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Previous Due Date</label>
                                    <input type="date" name="previous_due_date" class="form-control" placeholder="Previous Due Date">
                                    <strong class="previous_due_date_err color-red"></strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Note</label>
                                    <input type="text" name="notes" class="form-control" placeholder="Note">
                                    <strong class="notes_err color-red"></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit"  class="btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


        <!-- Add reference modal -->
        <div class="modal fade" id="add-reference" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Reference
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </h4>

                    </div>
                    <form action="{{route('admin.reference.store')}}" method="POST" class="referenceCreate">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name </label>
                                        <input type="text" name="name" class="form-control" placeholder="Reference Name">
                                        <strong class="name_err color-red"></strong>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Phone </label>
                                        <input type="text" name="phone" class="form-control" placeholder="Phone">
                                        <strong class="phone_err color-red"></strong>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email </label>
                                        <input type="text" name="email" class="form-control" placeholder="Email">
                                        <strong class="email_err color-red"></strong>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Profession</label>
                                        <input type="text" name="profession" class="form-control" placeholder="Profession">
                                        <strong class="profession_err color-red"></strong>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Address </label>
                                        <input name="address" placeholder="Address" class="form-control">
                                        <strong class="address_err color-red"></strong>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Note</label>
                                        <input type="text" name="notes" class="form-control" placeholder="Note">
                                        <strong class="notes_err color-red"></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit"  class="btn btn-info">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>




    <input type="hidden" id="popupModalWhenWantToeditSaleEditModal" value="{{route('sale.editSaleEditModal')}}" >
    <!-- Edti Cart modal -->
    <div class="modal fade" id="popupProductModalWhenEditOfCreatingAddToCart" role="dialog" aria-hidden="true"></div>




    <input type="hidden" value="{{$sale_final->id}}" class="order_id_class" />
    <input type="hidden" value="{{route('sale.saleEditWhenEditCartExit')}}" class="saleEditWhenEditCartExit_class" />

    <input type="hidden" value="{{route('sale.removeSingleDataFromEditSaleCart')}}" class="removeSingleDataFromEditSaleCart" />
    <input type="hidden" value="{{route('sale.removeAllDataFromEditSaleCart')}}" class="removeAllDataFromEditSaleCart" />


    <input type="hidden" id="changingQuantityFromSaleEditCartList" value="{{route('sale.changingQuantityFromSaleEditCartList')}}" >




    @push('js')
    <script src="{{ asset('public') }}/custom_js/backend/sale_edit/create.js?v=1"></script>
    <script src="{{ asset('public') }}/custom_js/backend/sale_edit/create_cart.js?v=1"></script>
    <script src="{{ asset('public') }}/custom_js/backend/sale_edit/product_list_or_cart.js?v=1"></script>

    <script src="{{ asset('public') }}/custom_js/backend/sale/create_customer.js?v=1"></script>
    <script src="{{ asset('public') }}/custom_js/backend/sale/create_reference.js?v=1"></script>
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
