 @extends('home')
 @section('title','User List')
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
             <li class="active">User</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
 
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px"> User List</span>
                          
                     </div>
                     <div class="widget-body" style="background-color: #fff;">
                         
                        <div class="table-toolbar text-right">
                            <a href="{{route('user.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add User</a>
                        </div>




                         <table id="example1" class="table table-bordered table-striped table-hover">
                             <thead>
                                 <tr>
                                    
                                     <th>SN</th>
                                     <th>Name</th>
                                     <th>Email</th>
                                     <th>Phone</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tbody>
                             	@foreach($users as $user)
                             
                                <tr>
                             		<td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                             		<td>{{ $user->email }}</td>
                             		<td>{{ $user->mobile }}</td>
                             	    <td> <img src="{{ asset($user->image) }}" alt="" width="100"></td> 
                             		<td>
                             			  
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li>
                                                    <a href="{{ route('user.edit',$user->id) }}"><i class="fa fa-pencil tiny-icon"></i> Edit</a>
                                                </li>
                                                
                                              
                                            </ul> 
                                        </div>



                             		</td>
                             	</tr>
                             	@endforeach
                                  
                             </tbody>
                             <tfoot>
                                   <tr>
                                    
                                     <th>SN</th>
                                     <th>Name</th>
                                     <th>Email</th>
                                     <th>Phone</th>
                                     <th>Image</th>
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
