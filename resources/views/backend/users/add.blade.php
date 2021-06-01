 @extends('home')
 @section('title','Add New User')
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
             <li class="active">Add User</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
      
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Add User</span>
                    </div>
                     <div class="widget-body">
                         <form action="{{route('user.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                             <div class="row">
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Name</label>
                                         <input name="name" value="{{old('name')}}" type="text" placeholder="name" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('name'))?($errors->first('name')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Email</label>
                                         <input name="email" type="text" value="{{old('email')}}" placeholder="email" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('email'))?($errors->first('email')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Mobile</label>
                                         <input name="mobile" value="{{old('mobile')}}" type="text" placeholder="mobile" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('mobile'))?($errors->first('mobile')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Password</label>
                                         <input name="password" type="password" value="{{old('password')}}" placeholder="Password" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('password'))?($errors->first('password')):''}}</div>
                                     </div>
                                 </div>


                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">User Photo</label>
                                         <input name="photo" type="file" value="{{old('photo')}}" placeholder="photo" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('photo'))?($errors->first('photo')):''}}</div>
                                     </div>
                                 </div>


                                  
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <input class="btn btn-primary" type="submit" value="Submit">
                                         <a href="{{route('user.index')}}" class="btn btn-info">Back</a>
                                     </div>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- /Page Body -->
 </div>
 <!-- /Page Content -->
 @endsection
