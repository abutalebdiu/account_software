 @extends('home')
 @section('title','Supplier')

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
             <li class="active">Supplier</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
     
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px"> Supplier</span>
                         
                     </div>
                     <div class="widget-body" style="background-color: #fff;">
                          <form action="{{ route('supplierListExport') }}" method="get">
                            <div class="table-toolbar text-right">
                                <button class="btn btn-primary pull-left" name="pdf"> <i class="fa fa-download"></i> PDF</button>
                               <a href="{{route('supplier.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Supplier</a>
                            </div>




                         <table id="example1" class="table table-bordered table-striped table-hover">
                             <thead>
                                 <tr>
                                    <th >
                                        <input type="checkbox" value="all" name="check_all" class="check_all_class"/>
                                    </th>
                                     <th style="width:3%">SN</th>
                                     <th style="width:3%">S.ID</th>
                                     <th>Supplier Name</th>
                                     <th>Contact Person</th>
                                     <th>Supplier Email</th>
                                     <th>Supplier Mobile</th>
                                     <th>AS Code Serial </th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tbody>
                              
                                  
                             </tbody>
                             <tfoot>
                                   <tr>
                                     <th></th>
                                     <th>SN</th>
                                     <th>S.ID</th>
                                     <th>Name</th>
                                     <th>Contact Person</th>
                                     <th>Email</th>
                                     <th>Suplier Mobile</th>
                                      <th>AS Code Serial </th>
                                     <th>Action</th>
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
