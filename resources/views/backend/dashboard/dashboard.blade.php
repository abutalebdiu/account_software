 @extends('home')
 @section('title','Home')
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
             <li class="active">Dashboard</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
     

     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-lg-12 col-md-12 col-md-12 col-xs-12">
                 <div class="row">
                     <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                         <div class="boxitem bg-white" style="margin-bottom:20px">
                             <div class="singlebox ">
                                 <div class="itembox">
                                     <h1>{{ $totalproducts }} <span class="pull-right"><i class="fa fa-th-list"></i></span></h1>
                                     <p>Total Items</p>
                                     <a href="{{ route('product.index') }}" class="btn btn-default" style="width:100%">More Detials <i class="fa fa-arrow-circle-right"></i></a>
                                 </div>

                             </div>
                         </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                         <div class="boxitem bg-white" style="margin-bottom:20px">
                             <div class="singlebox ">
                                 <div class="itembox">
                                     <h1>{{ $allusers }} <span class="pull-right"><i class="fa fa-users"></i></span></h1>
                                     <p>Total Users</p>
                                     <a href="" class="btn btn-default" style="width:100%">More Detials <i class="fa fa-arrow-circle-right"></i></a>
                                 </div>

                             </div>
                         </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                         <div class="boxitem bg-white" style="margin-bottom:20px">
                             <div class="singlebox ">
                                 <div class="itembox">
                                     <h1>{{ $suppliers }} <span class="pull-right"><i class="fa fa-users"></i></span></h1>
                                     <p>Total Supplier</p>
                                     <a href="{{ route('supplier.index') }}" class="btn btn-default" style="width:100%">More Detials <i class="fa fa-arrow-circle-right"></i></a>
                                 </div>

                             </div>
                         </div>
                     </div>
                     <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                         <div class="boxitem bg-white" style="margin-bottom:20px">
                             <div class="singlebox ">
                                 <div class="itembox">
                                     <h1>{{ $customers }} <span class="pull-right"><i class="fa fa-users"></i></span></h1>
                                     <p>Total Customers</p>
                                     <a href="{{ route('customer.index') }}" class="btn btn-default" style="width:100%">More Detials <i class="fa fa-arrow-circle-right"></i></a>
                                 </div>

                             </div>
                         </div>
                     </div> 

                     <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                         <div class="boxitem bg-white" style="margin-bottom:20px">
                             <div class="singlebox ">
                                 <div class="itembox">
                                     <h1> {{ $customer1 }} <span class="pull-right"><i class="fa fa-users"></i></span></h1>
                                     <p>Total Walk Customers</p>
                                     <a href="{{ route('customer.walk.index') }}" class="btn btn-default" style="width:100%">More Detials <i class="fa fa-arrow-circle-right"></i></a>
                                 </div>

                             </div>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-lg-6 col-sm-6 col-xs-12">
                 <div class="well with-header with-footer">
                     <div class="header bordered-blue"><i class="fa fa-link"></i> Quick Links</div>
                     <div class="buttons-preview">
                         <a class="btn btn-default shiny blue" href="{{ route('product.index') }}"> <i class="fa fa-plus"></i> Add Item</a>

                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-list"></i>Daily Summery Reports</a>

                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-envelope"></i>Send SMS</a>
                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-user"></i> + Supplier Payments</a>

                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-list"></i> Register Reports</a>

                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-cube "></i>Stock</a>

                         <a class="btn btn-default shiny blue" href="{{ route('sale.createPos') }}"><i class="fa fa-desktop "></i>POS</a>

                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-tasks "></i>Profit Loss Reports</a>


                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-users "> +</i>Customer Receive</a>


                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-money text-info "> </i>Expense</a>

                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-tasks text-info "> </i>Sales Reports</a>

                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-clock-o text-info "> </i> +Attendance</a>


                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-tasks text-info "> </i> + Purchase</a>

                         <a class="btn btn-default shiny blue" href="javascript:void(0);"><i class="fa fa-tasks text-info "> </i> Sales Report</a>




                     </div>

                 </div>

             </div>
             <div class="col-lg-6 col-sm-6 col-xs-12">
                 <div class="well with-header with-footer">
                     <div class="header bordered-blue"><i class="fa fa-shopping-cart"></i> Suppliers Low (-) Item</div>
                     <div class="buttons-preview">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Supplier</th>
                                    <th>Total Item</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($supplierLowQtys as $item)    
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $item->suppliers($item->supplier_id) }}</td>
                                    <td>{{$item->total}}</td>
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
