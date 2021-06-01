 @extends('home')
 @section('title','Product Damage')
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
             <li class="active">Product Damage</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
     
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px"> Product Damage</span>
                         
                     </div>
                     <div class="widget-body" style="background-color: #fff;">


                            <form action="" method="get"> 
                                <div class="row">
                                    <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="">Supplier</label>
                                            <select name="supplier_id" id="" class="form-control">
                                                <option value="">Select Supplier</option>
                                                @foreach($suppliers as $supplier)
                                                <option @if(isset($supplier_id)) {{ $supplier_id == $supplier->id ? 'selected' : ''}} @endif value="{{ $supplier->id }}"> {{ $supplier->name }} </option>


                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <br>
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                
                                </div>
                            </form>



                          <form action="{{ route('supplierListExport') }}" method="get">
                            <div class="table-toolbar text-right">
                                <button class="btn btn-primary pull-left" name="pdf"> <i class="fa fa-download"></i> PDF</button>
                               <a href="{{route('supplier.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Product Damage</a>
                            </div>




                         <table id="example1" class="table table-bordered table-striped table-hover">
                             <thead>
                                 <tr>
                                    <th >
                                        <input type="checkbox" value="all" name="check_all" class="check_all_class"/>
                                    </th>
                                     <th style="width:3%">SN</th>
                                     <th>Supplier Name</th>
                                     <th>Product Name</th>
                                     <th>Price</th>
                                     <th>Quantity</th>
                                     <th>Total Price</th>
                                     <th>Date </th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tbody>

                                @foreach($damages as $damage)
                                <td></td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $damage->supplier?$damage->supplier->name:'' }}  </td>
                                <td>{{ $damage->product?$damage->product->name:'' }}  </td>
                                <td> {{ $damage->price }} </td>
                                <td> {{ $damage->quantity }} </td>
                                <td> {{ $damage->total_price }} </td>
                                <td> {{ $damage->created_at }} </td>
                                <td>
                                          
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                              
                                                <li>
                                                    <a href="{{ route('damage.edit',$damage->id) }}"><i class="fa fa-pencil tiny-icon"></i> Edit</a>
                                                </li>
                                                 
                                            </ul> 
                                        </div>



                                    </td>

                                @endforeach
                              
                                  
                             </tbody>
                             <tfoot>
                                   <tr>
                                     <th></th>
                                     <th style="width:3%">SN</th>
                                     <th>Supplier Name</th>
                                     <th>Product Name</th>
                                     <th>Price</th>
                                     <th>Quantity</th>
                                     <th>Total Price</th>
                                     <th>Date </th>
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
