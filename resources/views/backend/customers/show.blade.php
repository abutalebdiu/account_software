 @extends('home')
 @section('title','Show Customer')
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
             <li class="active">Show Customer</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
  
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Show Customer</span>
                     </div>
                     <div class="widget-body">
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
                                  <th>Created At</th>
                                  <td>{{ $customer->created_at }}</td>
                                  <th>Action</th>
                                  <td>
                                       <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li><a href="{{ route('customer.edit',$customer->id) }}"><i class="fa fa-pencil tiny-icon"></i> Edit</a></li>
                                                 
                                                <li><a class="delete" href="{{ route('customer.destroy',$customer->id) }}"><i class="fa fa-trash tiny-icon"></i> Delete</a></li>
                                            </ul> 
                                        </div>
                                  </td>
                              </tr>
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
