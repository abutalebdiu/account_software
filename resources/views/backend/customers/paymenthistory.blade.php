 @extends('home')
 @section('title','Customers Payment History')
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
             <li class="active">Customers Payment History</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
    
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Customers Payment History  </span>
                         <a href="{{ route('customer.index') }}" style="float: right;color:white;font-size: 16px;padding: 2px 10px;">Customer List</a>
                     </div>

                    <div class="widget-body" style="background-color: #fff;">


                           <table class="table table-responsive table-bordered">
                              <tr>
                                  <th>Customer ID</th>
                                  <td>{{ $customer->id }}</td>
                             
                                  <th>User ID</th>
                                  <td>{{ $customer->id_no }}</td>
                              </tr> 
                               <tr>
                                  <th>Customer Name</th>
                                  <td>{{ $customer->name }}</td>
                             
                                  <th>Phone</th>
                                  <td>
                                      {{ $customer->phone }} <br>
                                      {{ $customer->phone_2 }}
                                  </td>
                              </tr> 
                              <tr>
                                  <th>Customer Email</th>
                                  <td>{{ $customer->email }}</td>
                             
                                  <th>Address</th>
                                  <td>{{ $customer->address }}</td>
                              </tr>
                              <tr>
                                  <th>Customer Notes</th>
                                  <td>{{ $customer->notes }}</td>
                             
                                  <th>Previous Due</th>
                                  <td>{{ $customer->previous_due }}</td>
                              </tr>
                              <tr>
                                  <th>Previous Due Date</th>
                                  <td>{{ $customer->previous_due_date }}</td>
                                  <th>Added By</th>
                                  <td>
                                      {{ $customer->author->name }}
                                  </td>
                              </tr>
                              <tr>
                                  <th>Total Due</th>
                                  <td>00000</td>
                                  <th>Total Loan</th>
                                  <td>0000</td>
                              </tr>
                              <tr>
                                  <th>Total Advance</th>
                                  <td>00000</td>
                                  <th>Account Create Date</th>
                                  <td>{{ $customer->created_at }}</td>
                              </tr>
                              
                              
                              
                              
                              
                              <tr>
                                   <td>
                                       <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                Action <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-left" role="menu"> 
                                                <li><a href="{{ route('customer.loan.create') }}?customer_id={{ $customer->id }}"><i class="fa fa-pencil tiny-icon"></i> Add Loan</a></li>
                                                <li><a class="" href=""><i class="fa fa-plus tiny-icon"></i> Add Advance</a></li>
                                                <li><a class="" href="{{route('admin.receivePreviousBill')}}?customer_id={{ $customer->id }}"><i class="fa fa-plus tiny-icon"></i> Due Receive </a></li>
                                            </ul> 
                                        </div>
                                  </td>
                              </tr>
                          
                            </tbody>
                        </table>


                            <hr></hr>

                        

                        <form action="{{ route('customer.payment.history.export',$customer->id) }}" method="post">
                            @csrf
                                               
                            <div class="table-toolbar text-right">
                                <button class="btn btn-primary pull-left" name="pdf"> <i class="fa fa-download"></i> PDF</button>
                                
                            </div>

                            <br>                        
                            <br>                        
                        
                        
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">
                                            <input type="checkbox" value="all" name="check_all" class="check_all_class"/>
                                        </th>
                                        <th width="5%">Invoice</th>
                                        <th width="5%">Date</th>
                                       
                                        <th width="20%">Media Name</th>
                                        <th width="10%">Loan</th>
                                        <th width="10%">Bill</th>
                                        <th width="10%">Received</th>
                                        <th width="10%">Due</th>
                                        <th width="10%">Total Due</th>
                                        <th width="10%">Advance</th>
                                        <th>Payment <br/> Method</th>
                                        <th><small>Credit/<br/>Debit</small></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($paymenthistories as $data)

                                    <tr>
                                        <td>
                                            <input type="checkbox" name="accountid[]" value="{{ $data->id }}" class="check_single_class" id="{{$data->id}}"/>
                                        </td>
                                        <td>{{ $data->payment_invoice_no }}</td>
                                        <td>{{ date('d-m-Y H:i:s',strtotime($data->payment_date)) }}</td>
                                       
                                      
                                        <td>{{ $data->takenby }}</td>
                                        <td>
                                            @if($data->module_id==5)
                                            {{ $data->payment_amount }}
                                            @endif
                                        </td>
                                        <td></td>
                                        <td>
                                            @if($data->module_id==2)
                                            {{ $data->payment_amount }}
                                            @endif
                                        </td>
                                       
                                        
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <small style="font-size:11px;">
                                            {{$data->paymentMethods?$data->paymentMethods->method:NULL}}<br/>
                                            {{$data->accounts?$data->accounts->bank?"(".$data->accounts->bank->short_name.")":NULL:NULL}}
                                            </small>
                                        </td>
                                         <td>
                                           <small> {{getCDFName_HH($data->cdf_type_id)}} </small>
                                        </td>
                                    </tr>

                                    @endforeach
                                  
                                    
                                </tbody>
                                <tfooter>
                                    <tr>
                                        <th></th>
                                        <th>Invoice</th>
                                        <th>Date</th> 
                                        <th>Name</th>
                                        <th>Loan</th>
                                        <th>Bill</th>
                                        <th>Received</th>
                                        <th>Due</th>
                                        <td>Total Due</td>
                                        <th>Advance</th>
                                        <th>Payment Method</th>
                                        <th>Credit/Debit</th>
                                    </tr>
                                </tfooter>
                            </table>
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
