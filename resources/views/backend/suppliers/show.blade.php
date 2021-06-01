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
             <li class="active">Show Supplier</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
     <!-- Page Header -->
     <div class="page-header position-relative">
         <div class="header-title">
             <h1>
                 Dashboard
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
                         <span class="widget-caption" style="font-size: 20px">Show Supplier</span>
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
                          <table class="table table-responsive table-bordered">
                              <tr>
                                  <th>Supplier ID</th>
                                  <td>{{ $supplier->id }}</td>
                                  <th>Supplier Name</th>
                                  <td>{{ $supplier->name }}</td>
                              </tr>
                              <tr>
                                  <th>Phone</th>
                                  <td>{{ $supplier->phone }}</td>
                                  <th>Supplier Email</th>
                                  <td>{{ $supplier->email }}</td>
                             </tr>
                              <tr>
                                  <th>Address</th>
                                  <td>{{ $supplier->address }}</td>
                                  
                                  <th>Previous Due</th>
                                   <td>{{ $supplier->previous_due }}</td>
                              </tr>  
                               
                              
                              
                              <tr>
                                  <th>Created At</th>
                                  <td>{{ $supplier->created_at }}</td>
                                  <td>AS Code Serial</td>
                                  <td>
                                      {{ $supplier->code_sequence }}
                                  </td>
                              </tr>
                              
                              <tr>
                                   <th>Action</th>
                                  <td>
                                       <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li><a href="{{ route('supplier.edit',$supplier->id) }}"><i class="fa fa-pencil tiny-icon"></i> Edit</a></li>
                                                 
                                                <li><a class="delete" href="{{ route('supplier.destroy',$supplier->id) }}"><i class="fa fa-trash tiny-icon"></i> Delete</a></li>
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
