 @extends('home')
 @section('title','Edit Plumber User')
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
             <li class="active">Edit Plumber User</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
      
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Edit Plumber User</span>
                    </div>
                     <div class="widget-body">
                         <form action="{{route('reference.update',$reference->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                             <div class="row">
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Name</label>
                                         <input name="name" value="{{ $reference->name }}" type="text" placeholder="name" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('name'))?($errors->first('name')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Email</label>
                                         <input name="email" type="text" value="{{ $reference->email}}" placeholder="email" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('email'))?($errors->first('email')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Mobile</label>
                                         <input name="mobile" value="{{$reference->phone}}" type="text" placeholder="mobile" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('mobile'))?($errors->first('mobile')):''}}</div>
                                     </div>
                                 </div> 
                                 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Mobile ( Optional)</label>
                                         <input name="phone_2" value="{{ $reference->phone_2 }}" type="text" placeholder="mobile" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('phone_2'))?($errors->first('phone_2')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Address</label>
                                         <input name="address" value="{{$reference->address}}" type="text" placeholder="address" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('address'))?($errors->first('address')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Profession</label>
                                         <input name="profession" value="{{$reference->profession}}" type="text" placeholder="profession" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('profession'))?($errors->first('profession')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Note</label>
                                         <input name="note" value="{{$reference->note}}" type="text" placeholder="note" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('note'))?($errors->first('note')):''}}</div>
                                     </div>
                                 </div>  
                                 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Blood Group</label>
                                         <input name="blood_group" value="{{$reference->blood_group}}" type="text" placeholder="Blood Group" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('blood_group'))?($errors->first('blood_group')):''}}</div>
                                     </div>
                                 </div>    
                                 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Religion</label>
                                         <input name="religion" value="{{$reference->religion}}" type="text" placeholder="religion" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('religion'))?($errors->first('religion')):''}}</div>
                                     </div>
                                 </div>
                                
 

                                  
                                 <div class="col-sm-12">
                                     <div class="form-group">
                                         <input class="btn btn-primary" type="submit" value="Submit">
                                         <a href="{{route('reference.index')}}" class="btn btn-info">Back</a>
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