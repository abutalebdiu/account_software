 @extends('home')
 @section('title','Show Plumber')
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
             <li class="active">Show Plumber</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
  
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Show Plumber</span>
                     </div>
                     <div class="widget-body">
                          <table class="table table-responsive table-bordered">
                               <tr>
                                  <th>Plumber Name</th>
                                  <td>{{ $reference->name }}</td>
                             
                                  <th>Phone</th>
                                  <td>
                                      {{ $reference->phone }} <br>
                                     
                                  </td>
                              </tr> 
                              <tr>
                                  <th>Plumber  Email</th>
                                  <td>{{ $reference->email }}</td>
                             
                                  <th>Plumber Address</th>
                                  <td>{{ $reference->address }}</td>
                              </tr>
                              <tr>
                                  <th>Plumber  Notes</th>
                                  <td>{{ $reference->note }}</td>
                                  
                                  <th>Profession</th>
                                  <td>
                                      {{ $reference->profession }}
                                  </td>
                              </tr>  

                              <tr>
                                  <th>Religion</th>
                                  <td>{{ $reference->note }}</td>
                                  
                                  <th>Blood Group</th>
                                  <td>
                                      {{ $reference->blood_group }}
                                  </td>
                              </tr>
                              <tr>
                                  <th>Created At</th>
                                  <td>{{ $reference->created_at }}</td>
                                  <th>Action</th>
                                  <td>
                                       <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li><a href="{{ route('reference.edit',$reference->id) }}"><i class="fa fa-pencil tiny-icon"></i> Edit</a></li>
                                                 
                                                <li><a class="delete" href="{{ route('reference.show',$reference->id) }}"><i class="fa fa-trash tiny-icon"></i> Delete</a></li>
                                            </ul> 
                                        </div>
                                  </td>
                              </tr>
                          </table>






                          <br>

                          <hr>
                          <br>


                          <h4>Plumber Payment History</h4>
                          
                          <table class="table table-responsive table-bordered">
                            <thead>
                              <tr>
                                <th>SL</th>
                                <th>Invoice No</th>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Total Amount</th>
                                <th>Item No</th>
                              
                                <th>Plumber Commission</th>
                                <th>Payment Status</th>
                              </tr>
                            </thead>
                            <tbody>
                               @php 
                                    $totalAmount = 0;
                                    $paidTotalAmount = 0;
                                    $dueTotalAmount = 0;
                                    $totalItem  = 0;
                                    
                                    $machdate = '';
                                    @endphp
                              @foreach($salesfinals as $item)
                              <tr>
                                  <td>{{ $loop->iteration }}</td>
                                  
                                  <td>
                                            <a class="single_view_class" data-id="{{$item->id}}" href="#" style="text-decoration: none;">
                                                {{$item->order_no}}
                                            </a>
                                        </td>
                                        <td>
                                            <a class="single_view_class" data-id="{{$item->id}}" href="#" style="text-decoration: none;">
                                                {{date('d-m-Y h:i:s ',strtotime($item->sale_date))}}
                                            </a>
                                        </td>
                                        <td>
                                            {{$item->customers?$item->customers->name:NULL}}
                                        </td>
                                        <td>
                                            @php 
                                            $totalAmount        += $item->totalSaleAmount();
                                            $paidTotalAmount    += $item->totalPaidAmount();
                                            $dueTotalAmount     += $item->totalDueAmount();
                                            $totalItem          += $item->totalSaleItems();
                                            @endphp
                                              {{ $item->totalSaleAmount() }}
                                        </td>
                                        
                                      
                                     
                                        <td>{{$item->totalSaleItems()}}</td>
                                        <td></td>
                                        <td></td>
                                     
                              </tr>
                              @endforeach
                            </tbody>
                            <tfoot>
                               <tr>
                                <th>SL</th>
                                <th>Invoice No</th>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Total Amount</th>
                                <th>Item No</th>
                           
                                <th>Plumber Commission</th>
                               
                                <th>Payment Status</th>
                              </tr>
                            </tfoot>
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
