 @extends('home')
 @section('title','Edit Customer')
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
             <li class="active">Edit Customer</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->

     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Edit Customer</span>
                     </div>
                     <div class="widget-body">
                         <form action="{{route('customer.update',$customer->id)}}" method="post">
                            @csrf
                             <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                       <label>Customer Type </label>
                                       <select name="customer_type" class="form-control">
                                           <option {{$customer->customer_type == 1 ?'selected':''}} value="1">Walking Customer</option>
                                           <option {{$customer->customer_type == 2 ?'selected':''}} value="2">Permanent Customer</option>
                                       </select>
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('customer_type'))?($errors->first('customer_type')):''}}</div>
                                    </div>
                                </div> 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Name</label>
                                         <input name="name" type="text" placeholder="Name" value="{{ $customer->name }}" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('name'))?($errors->first('name')):''}}</div>
                                     </div>
                                 </div> 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">phone</label>
                                         <input name="phone" type="text" placeholder="phone"value="{{ $customer->phone }}" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('phone'))?($errors->first('phone')):''}}</div>
                                     </div>
                                 </div>     
                                  <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Phone (Optional)</label>
                                         <input name="phone_2" type="text" placeholder="phone (Optional)" value="{{ $customer->phone_2 }}" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('phone_2'))?($errors->first('phone_2')):''}}</div>
                                     </div>
                                 </div>
                                 
                                <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">email</label>
                                         <input name="email" type="text" placeholder="email" value="{{ $customer->email }}"  class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('email'))?($errors->first('email')):''}}</div>
                                     </div>
                                 </div>

                                

                                  <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Previous Due</label>
                                         <input name="previous_due" type="text" placeholder="Previous Due" value="{{ $customer->previous_due }}" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('previous_due'))?($errors->first('previous_due')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Previous Due</label>
                                         <input name="previous_due_date" type="date" placeholder="Previous Due date" value="{{ $customer->previous_due_date }}" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('previous_due_date'))?($errors->first('previous_due_date')):''}}</div>
                                     </div>
                                 </div>



                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Address</label>
                                         <input name="address" type="text" placeholder="Address" value="{{ $customer->address }}" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('address'))?($errors->first('address')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">note</label>
                                         <input name="notes" type="text" placeholder="notes" value="{{ $customer->notes }}" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('notes'))?($errors->first('notes')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <input class="btn btn-primary" type="submit" value="Submit">
                                         <a href="{{route('customer.index')}}" class="btn btn-info">Back</a>
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
