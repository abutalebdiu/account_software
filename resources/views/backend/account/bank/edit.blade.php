 @extends('home')
 @section('title','Edit Banks')
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
             <li class="active">Edit Banks</li>
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
                         <span class="widget-caption" style="font-size: 20px">Edit Banks</span>
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
                         <form action="{{route('admin.bank.update',$bank->id)}}" method="post">
                             @csrf
                             @method('PUT')
                              <div class="row">
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Bank Name</label>
                                         <input value="{{$bank->name}}" name="name" type="text" placeholder="Full name" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('name'))?($errors->first('name')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Short Name</label>
                                         <input value="{{$bank->short_name}}" name="short_name" type="text" placeholder="Short Name" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('short_name'))?($errors->first('short_name')):''}}</div>
                                     </div>
                                 </div>
                                 {{--  <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Payment Method Name</label>
                                         <select id="" name="payment_method_id" class="form-control">
                                            <option value="" >Select Payment Method Name</option>
                                            <option {{$bank->payment_method_id == 0 ?'selected' : ''}} value="0">Empty Payment Method Name</option>
                                            @foreach ($paymentMethods as $item)
                                                <option {{$bank->payment_method_id == $item->id?'selected':''}} value="{{$item->id}}">{{$item->method}}</option>
                                            @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('payment_method_id'))?($errors->first('payment_method_id')):''}}</div>
                                     </div>
                                 </div>  --}}
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Address</label>
                                         <input value="{{$bank->address}}" name="address" type="text" placeholder="Address" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('address'))?($errors->first('address')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <input class="btn btn-primary" type="submit" value="Update">
                                         <a href="{{route('admin.bank.index')}}" class="btn btn-info">Back</a>
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
