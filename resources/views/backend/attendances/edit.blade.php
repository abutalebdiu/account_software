 @extends('home')
 @section('title','Edit Attendance')
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
             <li class="active">Add Attendance</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
    
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Edit Attendance</span>
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
                         <form action="{{route('attendance.update',$attendance->id)}}" method="post">
                            @csrf
                             <div class="row">
                            <div class="col-sm-6">
                             <div class="row">
                          
                                 <div class="col-sm-12">
                                     <div class="form-group">
                                         <label for="">Stuff</label>
                                          <select name="user_id" class="form-control">
                                              <option value="">Select User</option>
                                              @foreach($users as $user)
                                              <option {{ $attendance->user_id == $user->id ? 'selected' :'' }} value="{{ $user->id }}">{{ $user->name }}</option>
                                              @endforeach
                                          </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('user_id'))?($errors->first('user_id')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-12">
                                     <div class="form-group">
                                         <label for="">Date and Time</label>
                                         <input name="date_time" type="datetime-local"  value="{{ $attendance->date_time }}" placeholder="date_time" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('date_time'))?($errors->first('date_time')):''}}</div>
                                     </div>
                                 </div>


                                 <div class="col-sm-12">
                                     <div class="form-group">
                                         <label for="">Attendance Type</label>
                                         <select name="type" class="form-control">
                                              <option value="">Select User</option>
                                              <option {{ $attendance->type == "1" ? "selected" : '' }} value="1">Entry</option>
                                              <option {{ $attendance->type == "2" ? "selected" : '' }} value="2">Exit</option>
                                               
                                          </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('type'))?($errors->first('type')):''}}</div>
                                     </div>
                                 </div>



                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <input class="btn btn-primary" type="submit" value="Submit">
                                         <a href="{{route('attendance.index')}}" class="btn btn-info">Back</a>
                                     </div>
                                 </div>
                             </div>
                         </form>
                     </div>
                     </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- /Page Body -->
 </div>
 <!-- /Page Content -->
 @endsection
