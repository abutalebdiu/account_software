<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
    <title>Dashboard</title>

    <meta name="description" content="Dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{asset('public/assets')}}/img/favicon.png" type="image/x-icon">

   <!--Basic Styles-->
    <link href="{{asset('public/assets')}}/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="{{asset('public/assets')}}/css/font-awesome.min.css" rel="stylesheet" />
    <link href="{{asset('public/assets')}}/css/weather-icons.min.css" rel="stylesheet" />

    <!--Fonts-->
    <link href="../fonts.googleapis.com/css@family=open+sans_3a300italic,400italic,600italic,700italic,400,600,700,300.css" rel="stylesheet" type="text/css">
    <link href='../fonts.googleapis.com/css@family=roboto_3a400,300.css' rel='stylesheet' type='text/css'>
    <!--Beyond styles-->
    <link id="beyond-link" href="{{asset('public/assets')}}/css/beyond.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/assets')}}/css/demo.min.css" rel="stylesheet" />
    <link href="{{asset('public/assets')}}/css/typicons.min.css" rel="stylesheet" />
    <link href="{{asset('public/assets')}}/css/animate.min.css" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('public/assets')}}/css/custom.css">

   <link id="beyond-link" href="{{asset('public/assets')}}/css/select2.css" rel="stylesheet" type="text/css" />

    <!--imran-custom.css-->
    <link rel="stylesheet" href="{{asset('public/assets')}}/imran/imran-custom.css">

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="{{asset('public/assets')}}/js/skins.min.js"></script>
</head>
<!-- /Head -->
<!-- Body -->

<body>
    <!-- Loading Container -->
    <div class="loading-container">
        <div class="loader"></div>
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


    <section class="imran-main-dashboard" >
        <div class="container-fluid" >
            <div class="row">
                <div class="col-md-6">
                    <div class="lag-btn">
                        <a href="#" data-toggle="modal" data-target="#hold-sales" class="imran-custom-btn"><i class="fa fa-folder-open"></i> Open Hold Sales</a>
                        <select name="" style="padding:5px 0px;">
                            <option value="">English</option>
                            <option value="">Bangla</option>
                        </select>
                        <a href="#" class="imran-custom-btn"><i class="fa fa-bell"></i> Online Order</a>

                        <a href="#" class="imran-custom-btn pull-right"><i class="fa fa-calculator"></i> Calculator</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dash-btn">
                        <div class="row">
                            <div class="col-sm-3">
                                <a href="#" class="imran-custom-btn"><i class="fa fa-history"></i> Your All Sales</a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{route('home')}}" class="imran-custom-btn main-dash-btn"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="imran-custom-btn"><i class="fa fa-sign-out"></i> Logout</a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{route('sale.createPos')}}" class="imran-custom-btn"><i class="fa fa-history"></i>Refresh</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Showing alert -->
            <div class="alert_message" style="padding:10px 0px 10px 10px;display:none;text-align:center;" > </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="imd-leftt">

                        <div class="imran-employee-select mt-10">
                            <div class="ies-header">
                                <div class="row" style="margin-left:5px;">
                                    
                                    <div class="col-md-5">
                                        <select name="reference_id" class="reference_id form-control  select2" style="width: 100%">
                                            <option value="">Select Reference</option>
                                            @foreach ($references as $item)
                                            <option value="{{$item->id}}">{{$item->name}} ({{$item->phone}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="#" style="text-align:left;"  data-toggle="modal" data-target="#add-reference"><i style="margin-left: -23px;margin-top: 6px;"  class="fa fa-plus"></i></a>
                                    </div>
                                    <div class="col-md-5">
                                        <select name="customer_id" class="customer_id form-control select2" style="width: 100%">
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name}} ({{$customer->phone}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="#"  style="text-align:left;" data-toggle="modal" data-target="#add-customer"><i  style="margin-left: -23px; margin-top: 6px;" class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="ies-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Unit</th>
                                            <th>Qty</th>
                                            <th>Less Amount</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="showResult">
                                    </tbody>
                                </table>
                            </div>
                            <div class="ies-footer">
                                <table class="table" style="    background: #F0F5F9;">
                                    <thead>
                                        <tr>
                                            <th>Total Item : <strong id="totalItemShow" class="cr_totalItemShow_class"> 0 </strong></th>
                                            <th><i class="fa fa-calendar"></i></th>
                                            <th>
                                                <a href="#" data-target="#type-note" data-toggle="modal"><i class="fa fa-file"></i></a>
                                            </th>
                                            <th style="width: 20%;font-size:13px">Sub Total</th>
                                            <th style="width: 15% ; font-size:12px;color:green;">
                                                <strong id="subTotal" class="cr_subTotal_class">00.00</strong> tk
                                                <input type="hidden" name="subTotal" value="" class="cr_subTotalValue_class" id="subTotalValue"/>
                                            </th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td colspan="2" style="font-size:12px;">
                                                <label>
                                                Less Amount :
                                                    <input name="cr_subDiscountType" checked value="fixedValue" type="radio" class="colored-blue cr_subDiscountTypeClass " style="font-size:11px;">
                                                    <span class="text" style="font-size:11px;">Fixed</span>
                                                    <input name="cr_subDiscountType" value="percentageValue" type="radio" class="colored-blue cr_subDiscountTypeClass" style="font-size:11px;">
                                                    <span class="text" style="font-size:11px;">%</span>
                                                </label>
                                            </td>
                                            <td>
                                                <input style="width: 70px;font-size:11px" id="discount_value" class="cr_mainDiscountValueClass" value="0" name="discount_value" type="text"  placeholder="Less Amount">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                          
                                            <td colspan="2" style="font-size:12px; text-align:right">Total Less Amount</td>
                                            <td style="font-size:11px;">tk <strong id="discountedAmountOfSubTotal" class="cr_discountedAmountOfSubTotalClass">00.00</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="font-size:12px;">Shipping/Other</td>
                                            <td>
                                                <input id="otherCostClass" class="cr_otherCostShippingCost_Class" value="0" name="other_cost" style="width: 70px;font-size:11px;" type="text" placeholder="Amt" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th>Payable</th>
                                            <th style="color:green;">
                                                <strong id="payableAmount" class="cr_payableAmount_class"></strong>
                                                <input type="hidden" value="" class="cr_payableAmountClass" />
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <div class="dash-btn mt-10">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <a href="#" class="imran-custom-btn removeAllDataFromCart"><i class="fa fa-times"></i> Cancel</a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="#" class="imran-custom-btn paymentButtonDisalbed"  style="display:none;"><i class="fa fa-hand-o-up"></i> Quotation</a>
                                            <a href="#" class="imran-custom-btn paymentButtonEnable makeSaleQuotation" style="display:none;"><i class="fa fa-hand-o-up"></i> Quotation</a>

                                        </div>
                                        <div class="col-md-4">
                                            <a href="#" class="imran-custom-btn paymentButtonDisalbed"  style="display:none;"><i class="fa fa-money"></i> Payment</a>
                                            <a href="#" class="imran-custom-btn paymentButtonEnable paymentModalBeforeSubmitingFromCart" data-target="#popupPaymentModalBeforeSubmitingFromCart" data-toggle="modal" style="display:none;"><i class="fa fa-money"></i> Payment</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="imd-right mt-10">
                        <div class="imran-employee-tab">
                            <div class="ies-header">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" class="searchProductByNameSkuBarCodeForAddToCartWhenSaleCreate" value="{{route('sale.searchProductByNameSkuBarCodeForAddToCartWhenSaleCreate')}}"/>
                                        <input type="hidden" class="addToCartSingleProductByResultOfSearchingByAjaxWhenSaleCreate" value="{{route('sale.addToCartSingleProductByResultOfSearchingByAjaxWhenSaleCreate')}}"/>
                                        <div class="form-group dropdown">
                                            <input type="text" class="p_name_sku_bar_code_class form-control" placeholder="Name or sku or bar Code" autofocus style="width:100%;"/>
                                            <div id="product_list" class="" > </div>
                                            <style>
                                                .dropdown .dropdown-menu {
                                                    top: 35px;
                                                    width:100%;
                                                }
                                            </style>
                                        </div>
                                    </div>
                                    {{--  <div class="col-md-6">
                                        <input type="text" placeholder="Search by barcode" class="form-control" autofocus style="width:100%;"/>
                                    </div>  --}}
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="p_name_sku_bar_code_ccode_ascode_class form-control" placeholder="Name or sku or bar code , as code, company code" autofocus style="width:100%;"/>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="ies-right-body">
                                <div class="product_list">
                                   
                                </div>
                                <input type="hidden" value="{{route('sale.productListByAjax')}}" class="productListByAjax"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Add To Cart-->
    <div class="modal fade" id="popupProductModalWhenCreatingAddToCart" role="dialog" aria-hidden="true">
    </div>


    <!-- product  modal -->
    <div class="modal fade" id="product-cart" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Finalize Sale
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>

                </div>
                <form action="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <p>Previous Due <span class="pull-right">tk 0.00</span></p>
                                <p>Grand Total <span class="pull-right">tk 57.08</span></p>
                                <p>Total Payable <span class="pull-right">tk 57.08</span></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Paid Amount</label>
                                <input type="text" placeholder="Paid Amount" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label>Due Amount</label>
                                <input type="text" placeholder="Due Amount" class="form-control">
                            </div>
                        </div>
                        <p class="text-center mt-10">
                            <strong>This section just to help</strong>
                        </p>
                        <div class="row mt-10">
                            <div class="col-sm-6">
                                <label>Given Amount</label>
                                <input type="text" placeholder="Given Amount" class="form-control">
                            </div>
                            <div class="col-sm-6">
                                <label>Change Amount</label>
                                <input type="text" placeholder="Change Amount" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-10">
                            <div class="col-sm-6">
                                <label>Account</label>
                            </div>
                            <div class="col-sm-6">
                                <select name="" class="form-control">
                                    <option value="">Cash</option>
                                    <option value="">Card</option>
                                    <option value="">Rocket</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-10">
                            <div class="col-sm-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="colored-blue">
                                        <span class="text">Send Invoice Via SMS</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6 text-right">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="colored-blue">
                                        <span class="text">Send Invoice Via Email</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Account Note</label>
                                <textarea name="" rows="3" class="form-control" placeholder="Enter..."></textarea>
                            </div>
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


    <!-- payment note modal -->
    <div class="modal fade" id="popupPaymentModalBeforeSubmitingFromCart" role="dialog" aria-hidden="true">

    </div>




    <!-- Edti Cart modal -->
    <div class="modal fade" id="popupProductModalWhenEditOfCreatingAddToCart" role="dialog" aria-hidden="true">
    </div>





    <!-- type note modal -->
    <div class="modal fade" id="type-note" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Type a note
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>

                </div>
                <form action="">
                    <div class="modal-body">
                        <input type="text" placeholder="Type a note" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Ok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- hold modal -->
    <div class="modal fade" id="createQuotationHoldModal" role="dialog" aria-hidden="true"></div>


    <!-- Hold Sales modal -->
    <div class="modal fade" id="hold-sales" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"> Hold Sales
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="ies-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Customer</th>
                                            <th>Date Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Blank</td>
                                            <td>Blank</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Blank</td>
                                            <td>Blank</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Blank</td>
                                            <td>Blank</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Blank</td>
                                            <td>Blank</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="ies-body">
                                <h5 class="text-center" style="font-weight: 500 !important; font-size: 20px">Sales Details</h5>
                                <p><strong>Customer : </strong></p>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Qty</th>
                                            <th>Qty/Amt</th>
                                            <th>Discount</th>
                                            <th>Total</th>
                                            <th style="text-align: center;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Imran Ahmed</td>
                                            <td>10</td>
                                            <td>200tk</td>
                                            <td><input style="width: 70px" type="text" placeholder="Amt or %"></td>
                                            <td>500tk</td>
                                            <td style="width: 70px;text-align:center;"><i class="fa fa-trash"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Imran Ahmed</td>
                                            <td>10</td>
                                            <td>200tk</td>
                                            <td><input style="width: 70px" type="text" placeholder="Amt or %"></td>
                                            <td>500tk</td>
                                            <td style="width: 70px;text-align:center;"><i class="fa fa-trash"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Imran Ahmed</td>
                                            <td>10</td>
                                            <td>200tk</td>
                                            <td><input style="width: 70px" type="text" placeholder="Amt or %"></td>
                                            <td>500tk</td>
                                            <td style="width: 70px;text-align:center;"><i class="fa fa-trash"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Imran Ahmed</td>
                                            <td>10</td>
                                            <td>200tk</td>
                                            <td><input style="width: 70px" type="text" placeholder="Amt or %"></td>
                                            <td>500tk</td>
                                            <td style="width: 70px;text-align:center;"><i class="fa fa-trash"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Imran Ahmed</td>
                                            <td>10</td>
                                            <td>200tk</td>
                                            <td><input style="width: 70px" type="text" placeholder="Amt or %"></td>
                                            <td>500tk</td>
                                            <td style="width: 70px;text-align:center;"><i class="fa fa-trash"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Imran Ahmed</td>
                                            <td>10</td>
                                            <td>200tk</td>
                                            <td><input style="width: 70px" type="text" placeholder="Amt or %"></td>
                                            <td>500tk</td>
                                            <td style="width: 70px;text-align:center;"><i class="fa fa-trash"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="ies-footer">
                                <table class="table" style="background: #F0F5F9;">
                                    <thead>
                                        <tr>
                                            <th>Total Item : 1</th>
                                            <th><i class="fa fa-calendar"></i></th>
                                            <th><i class="fa fa-file"></i></th>
                                            <th style="width: 20%">Sub Total</th>
                                            <th style="width: 15%">500tk</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th>Discount</th>
                                            <th><input style="width: 70px" type="text" placeholder="Amt or %"></th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th>Total Discount</th>
                                            <th>tk 0.00</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th>Shipping/Other</th>
                                            <th><input style="width: 70px" type="text" placeholder="Amt"></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-6">
                        <a href="#" class="imran-custom-btn text-center" style="width: 100%"> Delete all Hold Sales</a>
                    </div>
                    <div class="col-sm-2">
                        <a href="#" class="imran-custom-btn text-center" style="width: 100%"> Edit in Cart</a>
                    </div>
                    <div class="col-sm-2">
                        <a href="#" class="imran-custom-btn text-center" style="width: 100%"> Delete</a>
                    </div>
                    <div class="col-sm-2">
                        <a href="#" data-dismiss="modal" class="imran-custom-btn text-center" style="width: 100%"> Cancel</a>
                    </div>
                </div>
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
                                    <label>Customer Type </label>
                                    <select name="customer_type" class="form-control">
                                        <option value="1">Walking Customer</option>
                                        <option value="2">Permanent Customer</option>
                                    </select>
                                    <strong class="customer_type_err color-red"></strong>
                                </div>
                            </div>
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
                            {{-- <div class="col-sm-6">
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
                            </div> --}}
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




    <!--Basic Scripts-->
    <script src="{{asset('public/assets')}}/js/jquery.min.js"></script>
    <script src="{{asset('public/assets')}}/js/bootstrap.min.js"></script>
    <!--select2-->
    <script src="{{ asset('public/assets') }}/js/select2.main.js"></script>

        <script src="{{ asset('public') }}/assets/js/jquery.print.js"></script>

    <script src="{{asset('public/assets')}}/js/slimscroll/jquery.slimscroll.min.js"></script>

    <!--Beyond Scripts-->
    <script src="{{asset('public/assets')}}/js/beyond.js"></script>


    <!--Page Related Scripts-->
    <!--Sparkline Charts Needed Scripts-->
    <script src="{{asset('public/assets')}}/js/charts/sparkline/jquery.sparkline.js"></script>
    <script src="{{asset('public/assets')}}/js/charts/sparkline/sparkline-init.js"></script>

    <!--Easy Pie Charts Needed Scripts-->
    <script src="{{asset('public/assets')}}/js/charts/easypiechart/jquery.easypiechart.js"></script>
    <script src="{{asset('public/assets')}}/js/charts/easypiechart/easypiechart-init.js"></script>

    <!--Flot Charts Needed Scripts-->
    <script src="{{asset('public/assets')}}/js/charts/flot/jquery.flot.js"></script>
    <script src="{{asset('public/assets')}}/js/charts/flot/jquery.flot.resize.js"></script>
    <script src="{{asset('public/assets')}}/js/charts/flot/jquery.flot.pie.js"></script>
    <script src="{{asset('public/assets')}}/js/charts/flot/jquery.flot.tooltip.js"></script>
    <script src="{{asset('public/assets')}}/js/charts/flot/jquery.flot.orderbars.js"></script>


    <script src="{{asset('public/assets')}}/imran/mixitup.min.js"></script>


    <!-------------------------------------------------------------------------->
    <input type="hidden" id="whenCartIsExist" value="{{route('sale.whenCartIsExist')}}" >
    <input type="hidden" id="changeQuantityFromCartList" value="{{route('sale.changeQuantityFromCartList')}}" >

    <input type="hidden" id="removeSingleDataFromCart" value="{{route('sale.removeSingleDataFromCart')}}" >
    <input type="hidden" id="removeAllDataFromCreateCart" value="{{route('sale.removeAllDataFromCreateCart')}}" >

    <input type="hidden" id="paymentModalBeforeSubmitingFromCart" value="{{route('sale.popupPaymentModalBeforeSubmitingFromCart')}}" >

    <input type="hidden" id="makeSaleQuotation" value="{{route('sale.makeSaleQuotation')}}" >
    <!-------------------------------------------------------------------------->

    <script>
        $(document).ready(function() {
           // var mixer = mixitup(".mixit-js");
        });

    </script>
    <!-----for Ajax handeling----->
        <script type="text/javascript">
            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
        </script>
        <!-----for Ajax handeling----->


    {{--show Product Details By Modal For Adding Cart --}}
    {{--  <input type="hidden" id="showProductDetailsByModalForAddingCart" data-url="{{route('sale.showProductDetailsByModalForAddingCart')}}" >  --}}
    <input type="hidden" id="popupModalWhenWantToCreateAddToCart" value="{{route('sale.createShowModal')}}" >
    <input type="hidden" id="popupModalWhenWantToCreateEditOfAddToCart" value="{{route('sale.createShowEditModal')}}" >
    {{---
        <script>
                $(document).on('click','.showProductShortDeatisByModal',function(e)
                {
                    var url = $('#showProductDetailsByModalForAddingCart').data("url");
                    var product_id = $(this).data('id');
                    $.ajax({
                        url: url,
                        type: "GET",
                        data: {product_id:product_id},
                        success: function(response)
                        {
                            $('#popupProductModalWhenCreatingAddToCart').html(response).modal('show');

                            setProductAmountFieldWhenFieldIsEmptyOrChangingUnitId();
                            stockAvailableOrNotWhenChangingSaleUnitQtyAndPrimaryStock(event);
                            setAllInputAndTextAfterAllFinalCalculation();
                        },
                    });
                });
        </script>
    ---}}


    {{--show Product Details By Modal For Editing Cart --}}
    <input type="hidden" id="showProductDetailsByModalForEditingCart" data-url="{{route('sale.showProductDetailsByModalForEditingCart')}}" >
    <script>
            $(document).on('click','.showProductShortDeatisByModalEditingCart',function(e)
            {
                var url = $('#showProductDetailsByModalForEditingCart').data("url");
                var product_id = $(this).data('id');
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {product_id:product_id},
                    success: function(response)
                    {
                        $('#showingProductShortDetailForEditingCartByModal').html(response).modal('show');
                        var fianlAmount =  calculation();
                        $('#totalAmount').text(fianlAmount);
                        $('#netTotalAmount').val(fianlAmount);

                    },
                });
            });
    </script>




    {{--salling price, quantity, and other --}}
    <script>
            $(document).on('click','.priceClass',function(e)
            {   //console.log(e.currentTarget.name);//console.log(e.type);
                var price = $(this).val();
                $('.sallingPrice').val(price);
            });
    </script>

    {{--salling price, quantity, and other --}}
    <script>
            $(document).on('click , change , keyup','.priceClass , .sallingPrice , .quantity',function(e)
            {
                var price = $('input[name="pice"]:checked').val();
                var fianlAmountSet =  calculation();
                $('#totalAmount').text(fianlAmountSet);
                $('#netTotalAmount').val(fianlAmountSet);
                calculationWithDiscount();
            });
    </script>


    {{--some calculational function --}}
    <script>
            $(document).on('click , change , keyup','.discountTypeClass , .discountValue ',function(e)
            {
                calculationWithDiscount();
            });



            function calculationWithDiscount()
            {
                var discountTypeValue = $('input[name="discountType"]:checked').val()
                var discountValueNumeric = parseInt($('.discountValue').val());
                var preTotal =   calculation();

                if(discountTypeValue != 'NULL')
                {
                    var totalDiscountedAmount = 0;
                    if(discountTypeValue == 'percentage')
                    {
                        totalDiscountedAmount = preTotal * discountValueNumeric / 100 ;
                        totalDiscountedAmount = totalDiscountedAmount.toFixed(2);
                    }
                    else if(discountTypeValue == 'fixed'){
                        totalDiscountedAmount = discountValueNumeric.toFixed(2);
                    }
                        var netTotal =  parseInt(preTotal - totalDiscountedAmount) || 0;
                        //$('#totalAmount').text(netTotal);
                        netTotal = netTotal.toFixed(2);
                        $('#totalAmount').text(netTotal)
                        $('#netTotalAmount').val(netTotal)
                }
            }
    </script>

    {{-- calculational function --}}
    <script>
            function calculation()
            {
                var setSalingPrice =  parseInt($('.sallingPrice').val()) || 0;
                var setQuantity    =  parseInt($('.quantity').val()) || 0;
                var totalAount = setSalingPrice * setQuantity ;
                return totalAount;
            }
    </script>

    {{--calculational with percentage function --}}
    <script>
            function calculationWithPercentage()
            {
                var setSalingPrice =  parseInt($('.sallingPrice').val()) || 0;
                var setQuantity    =  parseInt($('.quantity').val()) || 0;
                var totalAount = setSalingPrice * setQuantity ;
                return totalAount;
            }
    </script>


    {{--change value function --}}
    <script>
            function chechedValue()
            {
               var selectedPrice =  $('input[name="price"]:checked').val();
               return selectedPrice;
            }
    </script>


    {{--calculation bottom part calculational function --}}
    {{---
        <script>
                function subTotalCalculationWithDiscountAndOtherCost()
                {
                    $(document).on('click , change , keyup','.subDiscountTypeClass , .discountValueClass , .otherCostClass',function(e)
                    {
                        //var price = $(this).val();
                        var subDiscountType =  $('input[name="subDiscountType"]:checked').val();
                        var subTotalValueGet = $('#subTotalValue').val();
                        var discountAmountNumeric = $('.discountValueClass').val();
                        var totalPayableAmountSet = 0 ;
                        if(subDiscountType != '')
                        {
                            var subTotalDiscountedAmount = 0;
                            if(subDiscountType == 'percentageValue')
                            {
                                subTotalDiscountedAmount = subTotalValueGet * discountAmountNumeric / 100 ;
                                subTotalDiscountedAmount = subTotalDiscountedAmount.toFixed(2);
                            }
                            else if(subDiscountType == 'fixedValue'){
                                subTotalDiscountedAmount = discountAmountNumeric;
                            }
                                var totalPayableAmount =  parseInt(subTotalValueGet - subTotalDiscountedAmount) || 0;
                                $('#discountedAmountOfSubTotal').text(subTotalDiscountedAmount)
                                $('#payableAmount').text(totalPayableAmount)

                                totalPayableAmountSet =  parseInt(subTotalValueGet - subTotalDiscountedAmount) || 0;
                        }else{
                            var totalPayableAmountSet = subTotalValueGet ;
                        }

                            var otherCost = parseInt($('#otherCostClass').val()) || 0;
                            var totalPayableAmount =  parseInt(totalPayableAmountSet + otherCost) || 0;
                            $('#payableAmount').text(totalPayableAmount)


                        if(discountAmountNumeric == "")
                        {
                            $('#discountedAmountOfSubTotal').text('00.00')
                        }
                    });

                    //var price = $(this).val();
                        var subDiscountType =  $('input[name="subDiscountType"]:checked').val();
                        var subTotalValueGet = $('#subTotalValue').val();
                        var discountAmountNumeric = $('.discountValueClass').val();
                        var totalPayableAmountSet = 0 ;
                        if(subDiscountType != '')
                        {
                            var subTotalDiscountedAmount = 0;
                            if(subDiscountType == 'percentageValue')
                            {
                                subTotalDiscountedAmount = subTotalValueGet * discountAmountNumeric / 100 ;
                                subTotalDiscountedAmount = subTotalDiscountedAmount.toFixed(2);
                            }
                            else if(subDiscountType == 'fixedValue'){
                                subTotalDiscountedAmount = discountAmountNumeric;
                            }
                                var totalPayableAmount =  parseInt(subTotalValueGet - subTotalDiscountedAmount) || 0;
                                $('#discountedAmountOfSubTotal').text(subTotalDiscountedAmount)
                                $('#payableAmount').text(totalPayableAmount)

                                totalPayableAmountSet =  parseInt(subTotalValueGet - subTotalDiscountedAmount) || 0;
                        }else{
                            var totalPayableAmountSet = subTotalValueGet ;
                        }

                            var otherCost = parseInt($('#otherCostClass').val()) || 0;
                            var totalPayableAmount =  parseInt(totalPayableAmountSet + otherCost) || 0;
                            $('#payableAmount').text(totalPayableAmount)

                }

                function totalPayableNetAmount()
                {
                    var subTotalValueGetSet = $('#subTotalValue').val();
                    $('#payableAmount').text(subTotalValueGetSet);
                }
        </script>
    --}}


    {{---Add To Cart--}}
    {{---
    <script>
        //=========================== Add To Cart==============================
            $(document).on("submit",'#addToCartFromProductShortDetailModal',function(e){
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
                                //if(response.status == 'success')
                                //{
                                    $('#popupProductModalWhenCreatingAddToCart').modal("hide");
                                    //swal("Great","Successfully Updated Information","success");
                                    form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                    $('#showResult').html(response);
                                        totalItem();
                                        subtotals();
                                        subTotalCalculationWithDiscountAndOtherCost();

                                //}else{
                                     //$('#showResult').html(response);
                                    //console.log('nai');
                                    //swal("Wrong","Information is not Updated","error");
                                //}
                                //====================Perfect Working====================
                            },
                        complete:function(){
                            //$('.loading').fadeOut();
                            console.log('complete');
                        },
                });
                //end ajax
            });
        //=========================== Add To Cart==============================
    </script>
    --}}

    {{---Edit Add To Cart--}}
    <script>
        //=========================== Edit Add To Cart==============================
            $(document).on("submit",'#editAddToCartFromProductShortDetailModal',function(e){
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
                                //if(response.status == 'success')
                                //{
                                    $('#showingProductShortDetailForEditingCartByModal').modal("hide");
                                    //swal("Great","Successfully Updated Information","success");
                                    form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                    $('#showResult').html(response);
                                        totalItem();
                                        subtotals();
                                        subTotalCalculationWithDiscountAndOtherCost();

                                //}else{
                                     //$('#showResult').html(response);
                                    //console.log('nai');
                                    //swal("Wrong","Information is not Updated","error");
                                //}
                                //====================Perfect Working====================
                            },
                        complete:function(){
                            //$('.loading').fadeOut();
                            console.log('complete');
                        },
                });
                //end ajax
            });
        //=========================== Add To Cart==============================
    </script>


    {{--if cart is exist and some calculational function, totalItem()--}}
    {{--      <input type="hidden" id="showCartIfExisting" data-url="{{route('sale.showCartIfExisting')}}" >
        <script>
            $(document).ready(function(){
                ifCartExisting();
            });

            function ifCartExisting()
            {
                var url = $('#showCartIfExisting').data("url");
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response)
                    {
                        $('#showResult').html(response);
                        subtotals();
                        totalItem();
                        subTotalCalculationWithDiscountAndOtherCost();
                    },
                });
            }

            function totalItem()
            {
                var getResult =  $('.totalId').val();
                $('#totalItemShow').text(getResult);
            }

            function subtotals()
            {
                var sum = 0;
                $('.getSubtotalClass').each(function(){
                    sum += parseInt($(this).text());
                });
                $('#subTotal').text(sum);
                $('#subTotalValue').val(sum);

                subTotalCalculationWithDiscountAndOtherCost();
                totalPayableNetAmount();
            }
        </script>
    --}}

    {{--Quantity Plus minus--}}
    <input type="hidden" id="changeQuantityFromCart" data-url="{{route('sale.changeQuantityFromCart')}}" >
    {{--
        <script>
            $(document).on('click','.quantityChange',function(e)
            {
                e.preventDefault();
                var url = $('#changeQuantityFromCart').data("url");
                var product_id = $(this).data("product_id");
                var change_type = $(this).data("change_type");
                var quantity = $(this).data("quantity");

                $.ajax({
                    url: url,
                    type: "GET",
                    data: {product_id:product_id,change_type:change_type,quantity:quantity},
                    success: function(response)
                    {
                        $('#showResult').html(response);
                        totalItem();
                        subtotals();
                        subTotalCalculationWithDiscountAndOtherCost();
                    },
                });
            });
        </script>
    --}}

    {{--remove Single Cart--}}
    <input type="hidden" id="removeSingleCart" data-url="{{route('sale.removeSingleCart')}}" >
    {{--
        <script>
        $(document).on('click','.getIdForDelete',function(e)
        {
            e.preventDefault();
            var remainingItem = $('.totalId').val();
            if(remainingItem == 1 || remainingItem == 0)
            {
                $('.discountValueClass').val('0');
                $('.otherCostClass').val('0');
            }
            var url = $('#removeSingleCart').data("url");
            var product_id = $(this).data('id');
            $.ajax({
                url: url,
                type: "GET",
                data: {product_id:product_id},
                success: function(response)
                {
                    $('#showResult').html(response);
                      totalItem();
                      subtotals();
                      subTotalCalculationWithDiscountAndOtherCost();
                },
            });
        });
        </script>
    --}}

    {{--remove All Data from Cart--}}
    <input type="hidden" id="removeAllDataFromCart" data-url="{{route('sale.removeAllDataFromCart')}}" >
    {{--
        <script>
            $(document).on('click','.removeAllDataFromCart',function(e)
            {
                e.preventDefault();

                $('.discountValueClass').val('0');
                $('.otherCostClass').val('0');

                var url = $('#removeAllDataFromCart').data("url");
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response)
                    {
                        $('#showResult').html(response);
                        totalItem();
                        subtotals();
                        subTotalCalculationWithDiscountAndOtherCost();
                    },
                });
            });
        </script>
    --}}



    <script>
            function paymentSubmitButtonEnableDisabled()
            {
                $('#paymentSubmit').attr('disabled','disabled');
                var payableAmount   = $('#fianl_payable_amount_get').val();
                payableAmount   = parseFloat(payableAmount);
                if(payableAmount < 1)
                {
                    $('#paymentSubmit').attr('disabled','disabled');
                }
                else{
                    $('#paymentSubmit').removeAttr('disabled','disabled');
                }
            }
    </script>


    {{--show Payment Modal For Submiting Adding Cart --}}
    <input type="hidden" id="showPaymentModalForSubmitingCart" data-url="{{route('sale.showPaymentModalForSubmitingCart')}}" >
    {{--
        <script>
                $(document).on('click','.PaymentModalBeforeSubmitingFromCart',function(e)
                {
                    var url = $('#showPaymentModalForSubmitingCart').data("url");
                    var customerId      = $('.customer_id').val();
                    var employeeId      = $('.employee_id').val();
                    var totalItem       = $('#totalItemShow').text();
                    var subTotalAmount  = $('#subTotalValue').val();
                    var discountType    = $('input[name="subDiscountType"]:checked').val();
                    var discountValue   = $('.discountValueClass').val();
                    var discountAmount  = $('#discountedAmountOfSubTotal').text();
                    var otherCost       = $('.otherCostClass').val();
                    var payableAmount   = $('#payableAmount').text();

                    $.ajax({
                        url: url,
                        type: "GET",
                        data: {customerId:customerId,employeeId:employeeId,
                            totalItem:totalItem,subTotalAmount:subTotalAmount,
                            discountType:discountType,discountValue:discountValue,
                            discountAmount:discountAmount,otherCost:otherCost,payableAmount:payableAmount
                            },
                        success: function(response)
                        {
                            $('#popupPaymentModalBeforeSubmitingFromCart').html(response).modal('show');
                            dueSetFinalPaybleAmount();
                            paymentSubmitButtonEnableDisabled();
                        },
                    });
                });
        </script>
    --}}

    {{--Final Calculation of Payment Modal For Submiting Adding Cart --}}
    {{---
        <script>
            $(document).on('keyup', '.final_payable_amount',function(e)
            {
                dueSetFinalPaybleAmount();
                calculationGivenAmountResult();
            });

            $(document).on('keyup', '#calculation_given_amount',function(e)
            {
                calculationGivenAmountResult();
            });


        function dueSetFinalPaybleAmount()
        {
            var payable = parseFloat(getFinalPaybleAmount());
            var finalAmountGet =  parseFloat($("#fianl_payable_amount_get").val());
            var totalDue =  finalAmountGet - payable;
            $('#final_due_amount_disabled').val(totalDue);
            $('#final_due_amount').val(totalDue);
        }
            function getFinalPaybleAmount()
            {
            return  $(".final_payable_amount").val();
            }


            function calculationGivenAmountResult()
            {
                var finalGetAmount =  parseFloat($(".final_payable_amount").val());
                var givenAmount =  parseFloat($("#calculation_given_amount").val());
                var changeableAmount =  finalGetAmount - givenAmount  ;
                $('#calculation_change_amount').val(changeableAmount);
            }
        </script>
    ---}}
    
    <script src="{{ asset('public') }}/custom_js/backend/sale/create.js?v=1"></script>
    <script src="{{ asset('public') }}/custom_js/backend/sale/product_list.js?v=1"></script>
    
    <script src="{{ asset('public') }}/custom_js/backend/sale/create_cart.js?v=1"></script>
    <script src="{{ asset('public') }}/custom_js/backend/sale/search_sku_barcode_name_and_cart.js?v=1"></script>

   

    <script src="{{ asset('public') }}/custom_js/backend/sale/create_payment.js?v=1"></script>
    <script src="{{ asset('public') }}/custom_js/backend/sale/create_edit_cart.js?v=1"></script>

    <script src="{{ asset('public') }}/custom_js/backend/sale/create_customer.js?v=1"></script>

    <script src="{{ asset('public') }}/custom_js/backend/sale/create_reference.js?v=1"></script>


    <!---- payment methods----->
    <script src="{{ asset('public') }}/custom_js/backend/payment/add_payment_methods.js?v=1"></script>
    <!---- payment methods----->

</body>
<!--  /Body -->

</html>
