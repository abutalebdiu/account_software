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


    <section class="imran-main-dashboard">
        <div class="container-fluid">
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
                            <div class="col-sm-4">
                                <a href="#" class="imran-custom-btn"><i class="fa fa-history"></i> Your All Sales</a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{route('home')}}" class="imran-custom-btn main-dash-btn"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="imran-custom-btn"><i class="fa fa-sign-out"></i> Logout</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="imd-leftt">

                        <div class="imran-employee-select mt-10">
                            <div class="ies-header">
                                <div class="row" style="margin-left:5px;">
                                    <select name="employee_id" class="employee_id form-control col-md-5">
                                        <option value="">Select Employee</option>
                                    </select>

                                    <select name="customer_id" class="customer_id form-control col-md-5">
                                        <option value="1">Walk-in Customer </option>
                                    </select>

                                    <a href="#"><i class="fa fa-pencil"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#add-customer"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="ies-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Qty/Amt</th>
                                            <th>Discount</th>
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
                                            <th>Total Item : <strong id="totalItemShow"> 0 </strong></th>
                                            <th><i class="fa fa-calendar"></i></th>
                                            <th><a href="#" data-target="#type-note" data-toggle="modal"><i class="fa fa-file"></i></a></th>
                                            <th style="width: 20%">Sub Total</th>
                                            <th style="width: 15%">
                                                <strong id="subTotal">00.00</strong> tk
                                                <input type="hidden" name="subTotal" value="" id="subTotalValue"/>
                                            </th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td colspan="2">
                                                <label>
                                                Discount :
                                                    <input name="subDiscountType" checked value="fixedValue" type="radio" class="colored-blue subDiscountTypeClass " style="font-size:11px;">
                                                    <span class="text" style="font-size:11px;">Fixed</span>
                                                    <input name="subDiscountType" value="percentageValue" type="radio" class="colored-blue subDiscountTypeClass" style="font-size:11px;">
                                                    <span class="text" style="font-size:11px;">%</span>
                                                </label>
                                            </td>
                                            <td>
                                            <input style="width: 70px;font-size:11px" id="discount_value" class="discountValueClass" value="" name="discount_value" type="text"  placeholder="Discount">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total Discount</td>
                                            <td style="font-size:11px;">tk <strong id="discountedAmountOfSubTotal">00.00</strong></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Shipping/Other</td>
                                            <td>
                                                <input id="otherCostClass" class="otherCostClass" value="" name="other_cost" style="width: 70px;font-size:11px;" type="text" placeholder="Amt">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th>Payable</th>
                                            <th>
                                                <strong id="payableAmount"></strong>
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
                                            <a href="#" class="imran-custom-btn " data-target="#hold" data-toggle="modal"><i class="fa fa-hand-o-up"></i> Hold</a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="#" class="imran-custom-btn PaymentModalForSubmitingCart" data-target="#showingPaymentModalForSubmitingCart" data-toggle="modal"><i class="fa fa-money"></i> Payment</a>
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
                                <input type="text" placeholder="Name or Code or Category">
                                <input type="text" placeholder="Search_barcode">
                                <a href="#" data-target="#showingProductShortDetailForAddingCartByModal" data-toggle="modal"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="ies-right-body">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="ies-tab-btn">
                                            <a href="#" class="imran-custom-btn" data-filter=".all">All</a>
                                            @foreach ($categories as $item)
                                                <a href="#" class="imran-custom-btn" data-filter=".{{$item->name}}">{{$item->name}}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="ies-tab-content">
                                            <div class="row mixit-js">
                                                @foreach ($products as $item)
                                                <div class="col-sm-4 mix {{$item->categories?$item->categories->name:''}} all">
                                                    <div class="ies-tab-item showProductShortDeatisByModal" data-toggle="modal" data-id="{{$item->id}}" data-target="#showingProductShortDetailForAddingCartByModal">
                                                        <p class="mt-5">tk {{$item->sale_price}}</p>
                                                        <img src="{{asset('public/assets')}}/imran/image_thumb.png" class="img-fluid" alt="image">
                                                        <h5>{{$item->name}}</h5>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
    <div class="modal fade" id="showingPaymentModalForSubmitingCart" role="dialog" aria-hidden="true">
        {{-- <div class="modal-dialog" role="document">
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
        </div> --}}
    </div>



    <!-- Add To Cart-->
    <div class="modal fade" id="showingProductShortDetailForAddingCartByModal" role="dialog" aria-hidden="true">
    </div>


    <!-- Edti Cart modal -->
    <div class="modal fade" id="showingProductShortDetailForEditingCartByModal" role="dialog" aria-hidden="true">
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
    <div class="modal fade" id="hold" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Hold
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>

                </div>
                <form action="">
                    <div class="modal-body">
                        <label>Hold Number</label>
                        <input type="text" placeholder="Hold Number" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                                <table class="table" style="    background: #F0F5F9;">
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
                <form action="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Name </label>
                                    <input type="text" class="form-control" placeholder="Supplier Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone </label>
                                    <input type="text" class="form-control" placeholder="Phone">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Fathers NID </label>
                                    <input type="text" class="form-control" placeholder="Fathers NID">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email </label>
                                    <input type="text" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Previous Due </label>
                                    <input type="text" class="form-control" placeholder="Previous Due">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date of Birth </label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date of Anniversary </label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Delivery Address </label>
                                    <input name="" placeholder="Address" class="form-control">
                                </div>
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




    <!--Basic Scripts-->
    <script src="{{asset('public/assets')}}/js/jquery.min.js"></script>
    <script src="{{asset('public/assets')}}/js/bootstrap.min.js"></script>
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

    <script>
        $(document).ready(function() {
            var mixer = mixitup(".mixit-js");
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
    <input type="hidden" id="showProductDetailsByModalForAddingCart" data-url="{{route('sale.showProductDetailsByModalForAddingCart')}}" >
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
                        $('#showingProductShortDetailForAddingCartByModal').html(response).modal('show');

                        var price = chechedValue();
                        $('.sallingPrice').val(price);
                        var fianlAmount =  calculation();
                        $('#totalAmount').text(fianlAmount);
                        $('#netTotalAmount').val(fianlAmount);
                    },
                });
            });
    </script>




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



    {{---Add To Cart--}}
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
                                    $('#showingProductShortDetailForAddingCartByModal').modal("hide");
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
    <input type="hidden" id="showCartIfExisting" data-url="{{route('sale.showCartIfExisting')}}" >
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


    {{--Quantity Plus minus--}}
    <input type="hidden" id="changeQuantityFromCart" data-url="{{route('sale.changeQuantityFromCart')}}" >
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

    {{--remove Single Cart--}}
    <input type="hidden" id="removeSingleCart" data-url="{{route('sale.removeSingleCart')}}" >
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

    {{--remove All Data from Cart--}}
    <input type="hidden" id="removeAllDataFromCart" data-url="{{route('sale.removeAllDataFromCart')}}" >
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
    <script>
            $(document).on('click','.PaymentModalForSubmitingCart',function(e)
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
                        $('#showingPaymentModalForSubmitingCart').html(response).modal('show');
                        dueSetFinalPaybleAmount();
                        paymentSubmitButtonEnableDisabled();
                    },
                });
            });
    </script>

    {{--Final Calculation of Payment Modal For Submiting Adding Cart --}}
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



</body>
<!--  /Body -->

</html>
