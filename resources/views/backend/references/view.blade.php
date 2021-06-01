 @extends('home')
 @section('title','Plumber List')
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
             <li class="active">Plumber List</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
 
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Plumber List</span>
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
                     <div class="widget-body" style="background-color: #fff;">
                      
                       <a href="{{ route('reference.create') }}" class="pull-right btn btn-primary btn-sm">Add New</a>
                       <br>

                         <table id="example1" class="table table-bordered table-striped table-hover">
                             <thead>
                                 <tr>
                                     <th width="5%"> Sl.No</th>
                                     <th>Name</th>
                                     <th>Address</th>
                                     <th>Mobile</th>
                                    
                                     
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 
                                @foreach($references as $user)

                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td> {{ $user->name }} </td>
                                    <td> {{ $user->address}}  </td>
                                    <td> {{ $user->phone }} </td>
                         
                                 
                                    <td>
                                        <div class="btn-group dropdown">
                                            <button class="btn btn-sm btn-info btn-secondary dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-cogs"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li class="dropdown-item">
                                                    <a href="{{route('reference.show',$user->id)}}">View</a>
                                                </li>
                                                <li class="dropdown-item">
                                                    <a href="{{route('reference.edit',$user->id)}}"> Edit</a>
                                                </li>
                                                <li class="dropdown-item">
                                                    <a href="{{route('reference.show',$user->id)}}" > Show  </a>
                                                </li>
                                             
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                                
                                @endforeach

                              
                             </tbody>
                             <tfooter>
                                <tr>
                                     <th>Sl.No</th>
                                     <th>Name</th>
                                     <th>Address</th>
                                     <th>Mobile</th>
                                   
                                   
                                     <th>Action</th>
                                 </tr>
                             </tfooter>
                         </table>
                      
                 </div>
             </div>
         </div>
     </div>
     <!-- /Page Body -->
 </div>
 <!-- /Page Content -->

 @endsection
