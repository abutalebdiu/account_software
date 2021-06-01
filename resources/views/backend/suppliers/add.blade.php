 @extends('home')
 @section('title','Add Supplier')
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
             <li class="active">Add Supplier</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
     
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Add Supplier</span>
                         
                     </div>
                     <div class="widget-body">
                         <form action="{{route('supplier.store')}}" method="post">
                            @csrf
                             <div class="row">
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Supplier ID</label>
                                         <input name="uid" type="text" placeholder="ID" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('uid'))?($errors->first('uid')):''}}</div>
                                     </div>
                                 </div> 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Supplier Name</label>
                                         <input name="name" type="text" placeholder="Name" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('name'))?($errors->first('name')):''}}</div>
                                     </div>
                                 </div> 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Supplier Mobile</label>
                                         <input name="phone" type="text" placeholder="Enter Supplier Mobile" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('phone'))?($errors->first('phone')):''}}</div>
                                     </div>
                                 </div>          
                                <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Supplier Email</label>
                                         <input name="email" type="text" placeholder="Enter supplier email address" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('email'))?($errors->first('email')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Contact Person Name</label>
                                         <input name="contract_person" type="text" placeholder="contract person name" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('contract_person'))?($errors->first('contract_person')):''}}</div>
                                     </div>
                                 </div>   

                                  <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Previous Due</label>
                                         <input name="previous_due" type="text" placeholder="contract person" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('previous_due'))?($errors->first('previous_due')):''}}</div>
                                     </div>
                                 </div>



                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Supplier Address</label>
                                         <input name="address" type="text" placeholder="Enter Supplier Address" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('address'))?($errors->first('address')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Description/Notes</label>
                                         <input name="description" type="text" placeholder="Description" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('description'))?($errors->first('description')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">AS Code Serial</label>
                                         <input name="code_sequence" type="text" placeholder="Code Serial" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('code_sequence'))?($errors->first('code_sequence')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <input class="btn btn-primary" type="submit" value="Submit">
                                         <a href="{{route('supplier.index')}}" class="btn btn-info">Back</a>
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
