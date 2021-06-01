 @extends('home')
 @section('title','customers')
 @push('css')
     <style>
        input[type=checkbox], input[type=radio]
        {
            opacity: inherit;
            position: inherit;
            left: -9999px;
            z-index: 12;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled {
            cursor: pointer;
            position: unset;
        }
     </style>
 @endpush
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
             <li class="active">customers</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
    
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Customers </span>
                     </div>

                    <div class="widget-body" style="background-color: #fff;">
                        <form action="{{ route('customer.export') }}" method="get">
                                               
                            <div class="table-toolbar text-right">
                                <button class="btn btn-primary pull-left" name="pdf"> <i class="fa fa-download"></i> PDF</button>
                                <a href="{{route('customer.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Customer</a>
                            </div>
                        
                        
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th >
                                            <input type="checkbox" value="all" name="check_all" class="check_all_class"/>
                                        </th>
                                        <th>Action</th>
                                        <th>SN</th>
                                        <th>C. ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Due Date</th>
                                        <th>Added By</th>
                                        <th>Created At</th>
                                        <th>Total Due</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="customerid[]" value="{{ $customer->id }}" class="check_single_class" id="{{$customer->id}}"/>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                    <li><a href="{{ route('customer.edit',$customer->id) }}"><i class="fa fa-pencil tiny-icon"></i> Edit</a></li>
                                                    <li><a href="{{ route('customer.show',$customer->id) }}"><i class="fa fa-eye tiny-icon"></i> Show</a></li>
                                                    <li>
                                                        <a href="{{route('admin.receiveListPreviousBill')}}"> <i class="fa fa-eye tiny-icon"></i>
                                                            <span class="menu-text">Received</span>
                                                        </a>
                                                    </li>
                                                     
                                                    <li>
                                                        <a href=""> <i class="fa fa-money tiny-icon"></i>
                                                            <span class="menu-text">Payment Histroy</span>
                                                        </a>
                                                    </li>
                            
                                                    <!--<li><a class="delete" href="{{ route('customer.destroy',$customer->id) }}"><i class="fa fa-trash tiny-icon"></i> Delete</a></li>-->
                                                </ul> 
                                            </div>
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $customer->id }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->phone }} <br> {{ $customer->phone_2 }} </td>
                                        <td>{{ $customer->address }}</td>
                                        <td> 
                                            @php
                                                $originalDate =$customer->previous_due_date;
                                                    echo $newDate = date("d-m-Y", strtotime($originalDate));
                                            @endphp
                                
                                        </td>
                                        <td>{{ $customer->author->name }}</td>
                                        <td>{{ $customer->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $customer->previous_due }}</td>

                                        
                                        
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <th>Action</th>
                                        <th>SN</th>
                                        <th>Customer ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                    
                                        <th>Due Date</th>
                                        <th>Added By</th>
                                        <th>Created At</th>
                                        <th>Total Due</th>
                                        <th>Action</th>
                                    </tr>
                                </tfooter>
                            </table>
                         </form>
                    </div>
                </div>
            </div>
         </div>
     </div>
     <!-- /Page Body -->
 </div>
 <!-- /Page Content -->

 @push('js')
     <script>
        //check_all_class
        //check_single_class
        $(document).on('click','.check_all_class',function(){
            if (this.checked == false)
            {
                //28.03.2021
                $('.bulk_assigning_partner').hide();
                //28.03.2021

                $('.check_single_class').prop('checked', false).change();
                $(".check_single_class").each(function ()
                {
                    var id = $(this).attr('id');
                    $(this).val('').change();

                });
            }else{
                 //28.03.2021
                $('.bulk_assigning_partner').show();
                //28.03.2021

                $('.check_single_class').prop("checked", true).change();

                $(".check_single_class").each(function ()
                {
                    var id = $(this).attr('id');
                    $(this).val(id).change();
                });
            }
        });
            //=======================
        $(document).on('click','.check_single_class',function(){
             //28.03.2021
            var $b = $('input[type=checkbox]');
            if($b.filter(':checked').length <= 0)
            {
                $('.bulk_assigning_partner').hide();
            }
            //28.03.2021

            var id = $(this).attr('id');
            if (this.checked == false)
            {
                $(this).prop('checked', false).change();
                $(this).val('').change();
            }else{
                  //28.03.2021
                $('.bulk_assigning_partner').show();
                //28.03.2021
                $(this).prop("checked", true).change();
                $(this).val(id).change();
            }
            //=======================
        });


     
 

     </script>
 @endpush
 @endsection
