 @extends('home')
 @section('title','Add Units')
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
             <li class="active">Add Units</li>
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
                         <span class="widget-caption" style="font-size: 20px">Add Units</span>
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
                         <form action="{{route('unit.store')}}" method="post">
                            @csrf
                             <div class="row">
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Full Name</label>
                                         <input name="full_name" value="{{old('full_name')}}" type="text" placeholder="Full name" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('full_name'))?($errors->first('full_name')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Short Name</label>
                                         <input name="short_name" type="text" value="{{old('short_name')}}" placeholder="Short Name" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('short_name'))?($errors->first('short_name')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Parent Unit Name</label>
                                         <select id="" name="parent_id" class="form-control">
                                            <option value="" >Select Parent Unit Name</option>
                                            <option {{old('parent_id') == 0?'selected':''}}  value="0">Empty Parent Unit Name</option>
                                            @foreach ($units as $item)
                                                <option {{old('parent_id') == $item->id?'selected':''}} value="{{$item->id}}">{{$item->short_name}}</option>
                                            @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('parent_id'))?($errors->first('parent_id')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Calculation By This Value</label>
                                         <input name="calculation_value" type="number" step="any" value="{{old('calculation_value')}}" placeholder="Calculation By This Value" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('calculation_value'))?($errors->first('calculation_value')):''}}</div>
                                     </div>
                                 </div>
                                  <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Base Unit </label>
                                         <select id="" name="base_unit_id" class="form-control">
                                            <option value="">Select Base Unit Name</option>
                                            <option {{old('base_unit_id') == 0?'selected':''}}  value="0">Empty Base Unit Name</option>
                                            @foreach ($units as $item)
                                                <option {{old('base_unit_id') == $item->id?'selected':''}} value="{{$item->id}}">{{$item->short_name}}</option>
                                            @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('base_unit_id'))?($errors->first('base_unit_id')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Description</label>
                                         <input name="description" type="text" value="{{old('description')}}" placeholder="Description" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('description'))?($errors->first('description')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <input class="btn btn-primary" type="submit" value="Submit">
                                         <a href="{{route('unit.index')}}" class="btn btn-info">Back</a>
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
