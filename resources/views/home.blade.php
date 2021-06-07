<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') - Inventory</title>

    <meta name="description" content="Dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('public/frontend') }}/img/favicon.png" type="image/x-icon">


    <!--Basic Styles-->
    <link href="{{ asset('public/frontend') }}/css/bootstrap.min.css" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="{{ asset('public/frontend') }}/css/font-awesome.min.css" rel="stylesheet" />
    <link href="{{ asset('public/frontend') }}/css/weather-icons.min.css" rel="stylesheet" />

    <!--Fonts-->
    <link href="../fonts.googleapis.com/css@family=open+sans_3a300italic,400italic,600italic,700italic,400,600,700,300.css" rel="stylesheet" type="text/css">
    <link href='../fonts.googleapis.com/css@family=roboto_3a400,300.css' rel='stylesheet' type='text/css'>
    <!--Beyond styles-->
    <link href="{{ asset('public/frontend') }}/css/beyond.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/frontend') }}/css/demo.min.css" rel="stylesheet" />
    <link href="{{ asset('public/frontend') }}/css/typicons.min.css" rel="stylesheet" />
    <link href="{{ asset('public/frontend') }}/css/animate.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('public/frontend') }}/css/custom.css">

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="{{ asset('public/frontend') }}/js/skins.min.js"></script>




    <!--extra added-->

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public/frontend') }}/table/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('public/frontend') }}/table/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!--toastr.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" />


    <script src="{{ asset('public/frontend') }}/js/jquery.min.js"></script>
    <style>
        .page-breadcrumbs .breadcrumb{
            line-height: 35px;
        }
        
        .table{
            font-size: 12px !important;
        }
    </style>

    @stack('css')
</head>
<!-- /Head -->
<!-- Body -->

<body>
    <!-- Loading Container -->
    <div class="loading-container">
        <div class="loader"></div>
    </div>
    <!--  /Loading Container -->
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-inner">
            <div class="navbar-container">
                <!-- Navbar Barnd -->
                <div class="navbar-header pull-left">
                    <a href="{{ route('home') }}" class="navbar-brand">
                        Admin Dashboard
                    </a>
                </div>
                <!-- /Navbar Barnd -->
                <!-- Sidebar Collapse -->
                <div class="sidebar-collapse" id="sidebar-collapse">
                    <i class="collapse-icon fa fa-bars"></i>
                </div>
                <!-- /Sidebar Collapse -->
                <!-- Account Area and Settings --->
                <div class="navbar-header pull-right">
                    <div class="navbar-account">
                        <ul class="account-area">
                            <li>
                                <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                    <div class="avatar" title="View your public profile">
                                        <img src="{{ asset(Auth::user()->image) }}">
                                    </div>
                                    <section>
                                        <h2><span class="profile"><span>{{ Auth::user()->name }}</span></span></h2>
                                    </section>
                                </a>
                                 <!--Login Area Dropdown-->
                                <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">

                                   
                                    <li class="">
                                        <a href="#" >Profile</a>
                                       
                                    </li>

                                    <li class="">
                                       <a href="#">Setting</a>
                                    </li>


                                    <li class="dropdown-footer">
                                         <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                      <i class="fa fa-sign-out"></i>  {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                    </li>
                                </ul>
                                <!--/Login Area Dropdown-->
                            </li>

                        </ul>

                    </div>
                </div>
                <!-- /Account Area and Settings -->
            </div>
        </div>
    </div>
    <!-- /Navbar -->
    <!-- Main Container -->
    <div class="main-container container-fluid">
        <!-- Page Container -->
        <div class="page-container">

            <!-- Page Sidebar -->
            <div class="page-sidebar" id="sidebar">

                <!-- Sidebar Menu -->
                <ul class="nav sidebar-menu">
                    <!--Home-->
                    
                    
                    <li>
                        <a href="{{ Request::url() }}"> 0 
                            <i class="menu-icon fa fa-refresh" aria-hidden="true"></i>
                            <span class="menu-text"> Refresh </span>
                        </a>
                    </li>
                    
                    
                    <li> 
                        <a href="{{route('home')}}">  1 
                            <i class="menu-icon glyphicon glyphicon-home"></i>
                            <span class="menu-text"> Home </span>
                        </a>
                    </li>
                    
                    
                       <!--Attendance Management-->
                    <li>
                        <a href="#" class="menu-dropdown"> 2
                            <i class="menu-icon fa fa-calendar"></i>
                            <span class="menu-text">Attendances </span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                               <li>
                                <a href="{{  route('attendance.create') }}">
                                    <span class="menu-text">Add Attendance</span>
                                </a>
                            </li> 

                            <li>
                                <a href="{{ route('attendance.index') }} ">
                                    <span class="menu-text">Attendences List </span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('attendance.reports') }}">
                                    <span class="menu-text"> Reports </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--Attendance Management End-->
                    
                    
                         <!--product-->
                    <li>
                        <a href="{{route('product.index')}}" > 3
                            <i class="menu-icon fa fa-list"></i>
                            <span class="menu-text"> Products </span>
                          
                        </a>
                    </li>
                    
                
                     <!--End Product-->
                     
                     
                    <!--Sale-->
                    <li>
                        <a href="#" class="menu-dropdown"> 4
                            <i class="menu-icon fa fa-shopping-cart"></i>
                            <span class="menu-text"> Sales </span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{route('sale.saleView')}}">
                                    <span class="menu-text">Sale List</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('sale.createPos')}}">
                                    <span class="menu-text">Sale Create</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('sale.saleQuotationList')}}">
                                    <span class="menu-text">Quotation List</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('sale.return.index') }}">
                                    <span class="menu-text">Sales Returns</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--Sale End-->
                    
                    
                    <!--Purchase-->
                    <li>
                        <a href="#" class="menu-dropdown"> 5
                            <i class="menu-icon fa fa-shopping-cart"></i>
                            <span class="menu-text"> Purchase </span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{route('admin.purchase.index')}}">
                                    <span class="menu-text">Purchase List</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.purchase.create')}}">
                                    <span class="menu-text">Purchase Create</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Purchase Returns</span>
                                </a>
                            </li>


                            <li>
                                <a href="{{route('admin.purchase.quotation.index')}}">
                                    <span class="menu-text">Quotation List</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{route('admin.purchase.quotation.create')}}">
                                    <span class="menu-text">Create Quotation</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('admin.bypass.purchase.create')}}">
                                    <span class="menu-text">Bypass Purchase</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!--Purchase End-->
                    
                    
                    <!--Suppliers -->
                    
                    
                    <li>
                        <a href="{{ route('supplier.index') }}"> 6
                            <i class="menu-icon fa fa-users"></i>
                            <span class="menu-text"> Suppliers </span>
                        </a>
                    </li>
                    
                      
                    
                    <!--Suppliers  End-->
                    
                        
                        
                    <!--Customers --> 
                    
                    <li>
                        <a href="#" class="menu-dropdown"> 7
                            <i class="menu-icon fa fa-users"></i>
                            <span class="menu-text"> Customers  </span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('customer.index') }}">
                                    <span class="menu-text">Customer List</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('customer.walk.index') }}">
                                    <span class="menu-text">Walk Customer List</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('customer.create') }}">
                                    <span class="menu-text">Add New Customer</span>
                                </a>
                            </li>  
                            <li>
                                <a href="{{ route('customer.loan.index') }}">
                                    <span class="menu-text">Customer Loan</span>
                                </a>
                            </li>
                            
                          
                           
                            <li>
                                <a href="#">
                                    <span class="menu-text">SMS</span>
                                </a>
                            </li> 
                            
                            <li>
                                <a href="#">
                                    <span class="menu-text">SMS Group</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!--Customers  End-->
                    

                     <!--Product setting-->
                     
                    <li>
                        <a href="#" class="menu-dropdown"> 8
                            <i class="menu-icon fa fa-cogs"></i>
                            <span class="menu-text"> Products Settings </span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            
                            
                             <li>
                                <a href="{{route('group.index')}}">
                                    <span class="menu-text">Groups</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{route('brand.index')}}">
                                    <span class="menu-text">Brands</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{route('category.index')}}">
                                    <span class="menu-text">Categories</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{route('unit.index')}}">
                                    <span class="menu-text">Units</span>
                                </a>
                            </li>
                           
                        </ul>
                    </li>
                    
                    <!--Product Setting End-->
                    
                    
                    <!--Stock -->
                    <li>
                        <a href="#" class="menu-dropdown"> 9
                            <i class="menu-icon fa fa-database"></i>
                            <span class="menu-text">Stocks</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{route('admin.primary-stock.index')}}">
                                    <span class="menu-text">Showroom Stock</span>
                                    {{--  <span class="menu-text">Primary Stock</span>  --}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.secondary-stock.index')}}">
                                    <span class="menu-text">Godwon Stock</span>
                                    {{--  <span class="menu-text">Secondary Stock</span>  --}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.main-stock.index')}}">
                                    <span class="menu-text">Total Stocks</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--Stock End-->
                    
                                   
                    <!--Expense/Deposit Or Withdraw  -->
                    <li>
                        <a href="#" class="menu-dropdown"> 10
                            <i class="menu-icon fa fa-money"></i>
                            <span class="menu-text">Expense </span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{route('reference.index')}}">
                                    <span class="menu-text">Plumber</span>
                                 
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.secondary-stock.index')}}">
                                    <span class="menu-text">Deposit</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.main-stock.index')}}">
                                    <span class="menu-text">Withdraw</span>
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                    <!--Expense/Deposit Or Withdraw  End-->
                    
                    
                    <li>
                        <a href="{{ route('dashboard') }}"> 11
                            <i class="menu-icon fa fa-dashboard"></i>
                            <span class="menu-text"> Dashboard </span>
                        </a>
                    </li>
                    
                    
                          <!--Account-->
                    <li>
                        <a href="#" class="menu-dropdown"> 12
                            <i class="menu-icon fa fa-money"></i>
                            <span class="menu-text"> Accounts </span>

                            <i class="menu-expand"></i>
                        </a>

                        <ul class="submenu">
                            <li>
                                <a href="{{route('admin.account.index')}}">
                                    <span class="menu-text">Accounts</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.bank.index')}}">
                                    <span class="menu-text">Banks</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.paymentMethod.index')}}">
                                    <span class="menu-text">Payment Method</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--Account End-->


                    <!--Account Payment-->
                    <li>
                        <a href="#" class="menu-dropdown"> 13
                            <i class="menu-icon fa fa-money"></i>
                            <span class="menu-text"> Account Report</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{route('admin.paymentAccountReport')}}">
                                    <span class="menu-text">Payment Report</span>
                                </a>
                            </li>
                            {{--  <li>
                                <a href="{{route('admin.paymentAccountCashFlow')}}">
                                    <span class="menu-text">Cash Flow</span>
                                </a>
                            </li>  --}}
                        </ul>
                    </li>
                    <!--Account Payment End-->


                    
                    <!--Settings  -->
                    <li>
                        <a href="#" class="menu-dropdown"> 14
                            <i class="menu-icon fa fa-cogs"></i>
                            <span class="menu-text">Settings </span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                           <li>
                                <a href="{{ route('user.index') }}">
                                    <span class="menu-text">Users</span>
                                </a>
                            </li> 
                            <li>
                                <a href="#">
                                    <span class="menu-text">Shop Setting</span>
                                </a>
                            </li>
                         </ul>
                    </li>
                    <!--Settings  End-->
                    
                        
                        
                     <!--Settings  -->
                    <li>
                        <a href="#" class="menu-dropdown"> 15
                            <i class="menu-icon fa fa-cogs"></i>
                            <span class="menu-text">Reports </span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">


                           <li>
                                <a href="{{ route('report.daily.summery') }}">
                                    <span class="menu-text">Daily Summary Report</span>
                                </a>
                            </li> 

                            <li>
                                <a href="{{ route('damage.index') }}">
                                    <span class="menu-text">Damage</span>
                                </a>
                            </li> 
                            <li>
                                <a href="#">
                                    <span class="menu-text">Customer Due Receive Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Customer new Due Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('customer.saleReport') }}">
                                    <span class="menu-text">Invoice Sale Reports</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Daily Sale Report</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="#">
                                    <span class="menu-text">Details Sale Report</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="#">
                                    <span class="menu-text">Stock Report</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="#">
                                    <span class="menu-text">Low Stock Report</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="#">
                                    <span class="menu-text">Profit Loss Report</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="#">
                                    <span class="menu-text">Product Profit Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Customer Profit Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Attendance Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('supplierPurchaseReport') }}">
                                    <span class="menu-text">Supplier Ledger</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Supplier Due Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Customer Due Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Customer Ledger</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Product Purchase Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Expense Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Purchase Return Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Sale Return Report</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Damage Report</span>
                                </a>
                            </li>
                         </ul>
                    </li>
                    <!--Settings  End-->
                    
                    
                  <!--Delete  -->
                    <li>
                        <a href="#" class="menu-dropdown"> 16
                            <i class="menu-icon fa fa-trash"></i>
                            <span class="menu-text">Delete </span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                           <li>
                                <a href="">
                                    <span class="menu-text">Users</span>
                                </a>
                            </li> 
                            <li>
                                <a href="#">
                                    <span class="menu-text">Customers</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="menu-text">Suppliers</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="#">
                                    <span class="menu-text">Cash Flow</span>
                                </a>
                            </li>         
                            
                            <li>
                                <a href="#">
                                    <span class="menu-text">Sales</span>
                                </a>
                            </li> 
                            
                            <li>
                                <a href="#">
                                    <span class="menu-text">Purchases</span>
                                </a>
                            </li>
                         </ul>
                    </li>
                    <!--Settings  End-->

 

                </ul>
                <!-- /Sidebar Menu -->
            </div>
            <!-- /Page Sidebar -->

            <!-- /Chat Bar -->
            @yield('content')

        </div>
        <!-- /Page Container -->
        <!-- Main Container -->



    </div>



    <!--Basic Scripts-->

    <script src="{{ asset('public/frontend') }}/js/bootstrap.min.js"></script>

    <!----print----->
    <!----<script src="{{ asset('public/assets') }}/print/jquery/jquery.print.js"></script> ----->
    <script src="{{ asset('public') }}/assets/js/jquery.print.js"></script>


    <script src="{{ asset('public/frontend') }}/js/slimscroll/jquery.slimscroll.min.js"></script>

    <!--Beyond Scripts-->
    <script src="{{ asset('public/frontend') }}/js/beyond.js"></script>
    <!--select2-->
    <script src="{{ asset('public/frontend') }}/js/select2/select2.js"></script>


    <!--Page Related Scripts-->
    <!--Sparkline Charts Needed Scripts-->
    <script src="{{ asset('public/frontend') }}/js/charts/sparkline/jquery.sparkline.js"></script>
    <script src="{{ asset('public/frontend') }}/js/charts/sparkline/sparkline-init.js"></script>

    <!--Easy Pie Charts Needed Scripts-->
    <script src="{{ asset('public/frontend') }}/js/charts/easypiechart/jquery.easypiechart.js"></script>
    <script src="{{ asset('public/frontend') }}/js/charts/easypiechart/easypiechart-init.js"></script>

    <!--Flot Charts Needed Scripts-->
    <script src="{{ asset('public/frontend') }}/js/charts/flot/jquery.flot.js"></script>
    <script src="{{ asset('public/frontend') }}/js/charts/flot/jquery.flot.resize.js"></script>
    <script src="{{ asset('public/frontend') }}/js/charts/flot/jquery.flot.pie.js"></script>
    <script src="{{ asset('public/frontend') }}/js/charts/flot/jquery.flot.tooltip.js"></script>
    <script src="{{ asset('public/frontend') }}/js/charts/flot/jquery.flot.orderbars.js"></script>
    <script>
        // If you want to draw your charts with Theme colors you must run initiating charts after that current skin is loaded
        $(window).bind("load", function() {

                    /*Sets Themed Colors Based on Themes*/
                    themeprimary = getThemeColorFromCss('themeprimary');
                    themesecondary = getThemeColorFromCss('themesecondary');
                    themethirdcolor = getThemeColorFromCss('themethirdcolor');
                    themefourthcolor = getThemeColorFromCss('themefourthcolor');
                    themefifthcolor = getThemeColorFromCss('themefifthcolor');

    </script>


    <!--extra added-->

    <!--sweet alert-->
    <script src="{{asset('public/frontend/sweetalert/sweetalert2@9.js')}}"></script>
    <!--toastr.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- DataTables -->
    <script src="{{ asset('public/frontend') }}/table/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('public/frontend') }}/table/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('public/frontend') }}/table/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('public/frontend') }}/table/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function() {
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "lengthMenu": [[10, 25, 50,100,500, -1], [10, 25, 50,100,500 ,"All"]]
            });
        });

    </script>
    <script>
        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            Swal.fire({
                title: 'Are you sure?',
                text: "Delete this data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = link;
                    Swal.fire(
                        'Deleted!',
                        'Data has been deleted.',
                        'success'
                    )
                }
            })
        });

    </script>
    <script>
        @if(Session::has('message'))
        var type = "{{Session::get('alert-type','info')}}"

        switch (type) {
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;
            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;
            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif

    </script>
    <script>
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });


         $(document).ready(function() {
            $('.select2').select2();
        });
    </script>


    @stack('js')

</body>
<!--  /Body -->

</html>
