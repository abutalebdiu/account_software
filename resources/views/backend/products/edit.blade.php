@extends('home')
@section('title','Edit Products')
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
             <li class="active">Add Product</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
   
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Edit Product</span>
                     </div>
                     <div class="widget-body">
                         <form action="{{route('product.update',$product->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                             <div class="row">
                                  <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Supplier <a href="#" data-toggle="modal" data-target="#supplierModal"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                         <select id="supplier_id" name="supplier_id" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($suppliers as $supplier)
                                             <option {{$supplier->id == $product->supplier_id ? 'selected' : ''}} value="{{$supplier->id}}">{{$supplier->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('supplier_id'))?($errors->first('supplier_id')):''}}</div>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Product Name</label>
                                         <input value="{{$product->name}}" name="name" type="text" placeholder="Product Name" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('name'))?($errors->first('name')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 
                                <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Category <a href="#" data-toggle="modal" data-target="#categoryModal"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                         <select name="category_id" id="category_id" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($categories as $category)
                                             <option {{$category->id == $product->category_id ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('category_id'))?($errors->first('category_id')):''}}</div>


                                     </div>
                                 </div>
                                 
                                  <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Group Name</label>
                                         <select id="" name="group_id" class="group form-control">
                                             <option value="">Select Group</option>
                                             @foreach($groupes as $group)
                                             <option {{$group->id == $product->group_id ? 'selected' : ''}} value="{{$group->id}}">{{$group->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('group_id'))?($errors->first('group_id')):''}}</div>
                                     </div>
                                 </div> 
                                 
                                

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Brand <a href="#" data-toggle="modal" data-target="#addBrandModal"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                         <select id="brand_id" name="brand_id" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($brands as $brand)
                                             <option {{$brand->id == $product->brand_id ? 'selected' : ''}} value="{{$brand->id}}">{{$brand->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('brand_id'))?($errors->first('brand_id')):''}}</div>
                                     </div>
                                 </div>
                                 

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Purchase Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->purchase_price}}" name="purchase_price" type="text"  step="any" min="0" class="form-control" placeholder="Purchase Price">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_price'))?($errors->first('purchase_price')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">whole Sale Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->whole_sale_price}}" name="whole_sale_price" type="text"  step="any" min="0" class="form-control" placeholder="whole Sale Price">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('whole_sale_price'))?($errors->first('whole_sale_price')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Sale Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->sale_price}}" name="sale_price" type="text"  step="any" min="0" class="form-control" placeholder="Sale Price (Regular Price)">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('sale_price'))?($errors->first('sale_price')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">MRP Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->mrp_price}}" name="mrp_price" type="text"  step="any" min="0" class="form-control" placeholder="MRP Price">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('mrp_price'))?($errors->first('mrp_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Offer Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->online_sell_price}}" name="online_sell_price" type="text"  step="any" min="0" class="form-control" placeholder="Online Sale Price">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('online_sale_price'))?($errors->first('online_sale_price')):''}}</div>
                                     </div>
                                 </div>

                                {{--   <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Online Discount Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input name="online_discount_price" type="text"  step="any" min="0" class="form-control" placeholder="Online Discount Price">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('online_discount_price'))?($errors->first('online_discount_price')):''}}</div>
                                     </div>
                                 </div>  --}}


                                <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Product Grade Type </label>
                                         <select id="" name="grade_type_id" class="grade_type_id form-control">
                                             @foreach($grades as $grade)
                                             <option {{$product->grade_type_id == $grade->id ?'selected' : ''}} value="{{$grade->id}}">{{$grade->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('grade_type_id'))?($errors->first('grade_type_id')):''}}</div>
                                     </div>
                                 </div> 

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Purchase Unit <i class="fa fa-info-circle"></i><a href="#" data-toggle="modal" data-target="#addPurchaseUnitModal"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                         <select id="purchase_unit_id" name="purchase_unit" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($units as $unit)
                                                @if ($unit->short_name)
                                                <option {{$unit->id == $product->purchase_unit_id ? 'selected' : ''}} value="{{$unit->id}}">{{$unit->short_name}}</option>
                                                @endif
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_unit'))?($errors->first('purchase_unit')):''}}</div>
                                     </div>
                                 </div>


                                 {{--  <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Sale Unit <i class="fa fa-info-circle"></i><a href="#" data-toggle="modal" data-target="#exampleModal4"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                         <select name="sale_unit" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($units as $unit)
                                             <option value="{{$unit->id}}">{{$unit->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('sale_unit'))?($errors->first('sale_unit')):''}}</div>
                                     </div>
                                 </div>  --}}


                                 {{--  <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Low Sale Qty <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->low_sale_qty}}" name="low_sale_qty" type="number"  step="any" min="0" placeholder="Low Sale Qty" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('low_sale_qty'))?($errors->first('low_sale_qty')):''}}</div>
                                     </div>
                                 </div>  --}}
                                <input type="hidden" name="low_sale_qty" value="" />
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Low Alert Qty <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->low_alert_qty}}" name="low_alert_qty" type="number"  step="any" min="0" placeholder="Low Alert Qty" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('low_alert_qty'))?($errors->first('low_alert_qty')):''}}</div>
                                     </div>
                                 </div>

                                 {{-- <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Warranty Period Type<i class="fa fa-info-circle"></i></label>
                                        <select id="warrantity_period_type" name="warrantity_period_type" class="form-control">
                                            <option value="">Select</option>
                                            <option {{ $product->warrantity_period_type == 'days'?'selected':'' }} value="days">Day</option>
                                            <option {{ $product->warrantity_period_type == 'months'?'selected':'' }} value="months">Month</option>
                                            <option {{ $product->warrantity_period_type == 'years'?'selected':'' }} value="years">Year</option>
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('warrantity_period_type'))?($errors->first('warrantity_period_type')):''}}</div>
                                     </div>
                                 </div> --}}
                                 <input type="hidden" name="warrantity_period_type" value="months" />
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Warranty Period<i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->warranty_period}}"  name="warranty_period" type="number"  step="any"  placeholder="Warranty Period" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('warranty_period'))?($errors->first('warranty_period')):''}}</div>
                                     </div>
                                 </div>
                                {{--  <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Guarantee Period Type<i class="fa fa-info-circle"></i></label>
                                        <select id="guarantee_period_type" name="guarantee_period_type" class="form-control">
                                             <option value="">Select</option>
                                             <option {{$product->guarantee_period_type == 'days'?'selected':''}} value="days">Day</option>
                                             <option {{$product->guarantee_period_type == 'months'?'selected':''}} value="months">Month</option>
                                             <option {{$product->guarantee_period_type == 'years'?'selected':''}} value="years">Year</option>
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('guarantee_period_type'))?($errors->first('guarantee_period_type')):''}}</div>
                                     </div>
                                 </div> --}}
                                 <input type="hidden" name="guarantee_period_type" value="months" />
                                {{--   <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Guarantee Period <i class="fa fa-info-circle"></i></label>
                                         <input  value="{{$product->guarantee_period}}"  name="guarantee_period" type="number"  step="any"  placeholder="Guarantee Period" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('guarantee_period'))?($errors->first('guarantee_period')):''}}</div>
                                     </div>
                                 </div>  --}}
                                 <input type="hidden" name="guarantee_period" value="" />
                                 {{-- <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Expiry Period Type<i class="fa fa-info-circle"></i></label>
                                        <select id="expiry_period_type" name="expiry_period_type" class="form-control">
                                             <option value="">Select</option>
                                             <option {{$product->expiry_period_type == 'days'?'selected':''}} value="days">Day</option>
                                             <option {{$product->expiry_period_type == 'months'?'selected':''}} value="months">Month</option>
                                             <option {{$product->expiry_period_type == 'years'?'selected':''}} value="years">Year</option>
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('expiry_period_type'))?($errors->first('expiry_period_type')):''}}</div>
                                     </div>
                                 </div> --}}
                                 <input type="hidden" name="expiry_period_type" value="months" />
                                <!-- <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Expiry Period <i class="fa fa-info-circle"></i></label>-->
                                         <input   value="{{$product->expiry_period}}"  name="expiry_period" type="hidden"  step="any"  value="1" placeholder="Expiry Period" class="form-control">
                                        <!-- <div style='color:red; padding: 0 5px;'>{{($errors->has('expiry_period'))?($errors->first('expiry_period')):''}}</div>
                                     </div>
                                 </div>-->
                                 
                                 {{-- <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Discount Type <small>(for sale)</small><i class="fa fa-info-circle"></i></label>
                                        <select id="discount_type" name="discount_type" class="form-control">
                                             <option {{$product->discount_type == 'fixed'?'selected':''}} value="fixed">Fixed</option>
                                             <option {{$product->discount_type == 'fixed'?'percent':''}} value="percent">Percent</option>
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('discount_type'))?($errors->first('discount_type')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Discount Value <small>(for sale)</small><i class="fa fa-info-circle"></i></label>
                                         <input  value="{{$product->discount_value}}"  name="discount_value" type="number"  step="any"  placeholder="Discount Value" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('discount_value'))?($errors->first('discount_value')):''}}</div>
                                     </div>
                                 </div> --}}
                                <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">AS Code</label>
                                         <input name="custom_code" type="text" value="{{$product->custom_code}}" placeholder="As Code" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('custom_code'))?($errors->first('custom_code')):''}}</div>
                                     </div>
                                 </div>
                                 
                                  <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Company Code</label>
                                         <input name="company_code" type="text" value="{{$product->company_code}}" placeholder="Company Code" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('company_code'))?($errors->first('company_code')):''}}</div>
                                     </div>
                                 </div>
                                
                                 
                                
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Description</label>
                                         <input value="{{$product->description}}"  name="description" type="text" placeholder="Description" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('description'))?($errors->first('description')):''}}</div>
                                     </div>
                                 </div>
                                {{--  <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Initial Stock</label>
                                         <input value="{{$product->initial_stock}}"  name="initial_stock"  type="number"  step="any"   placeholder="Initial Stock" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('initial_stock'))?($errors->first('initial_stock')):''}}</div>
                                     </div>
                                 </div>  --}}

                                  <div class="col-sm-3">
                                     <div class="form-group">
                                         <a style="margin-top: 23px" href="#" class="btn btn-info btn-block" data-toggle="modal" data-target="#exampleModal6"><i class="fa fa-edit"></i> Change Image</a>

                                         <!-- Add image modal -->
                                         <div class="modal fade" id="exampleModal6" role="dialog" aria-hidden="true">
                                             <div class="modal-dialog" role="document">
                                                 <div class="modal-content">
                                                     <div class="modal-header">
                                                         <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Image
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                 <span aria-hidden="true">&times;</span>
                                                             </button>
                                                         </h4>

                                                     </div>
                                                     <div class="modal-body">
                                                         <div class="form-group">
                                                             <label>Image </label>
                                                             <span class="file-input btn btn-block btn-info btn-file">
                                                                 Browse <input name="default_photo" id="image" type="file">
                                                             </span>

                                                             <img style="padding:4px;border:1px solid gray; margin-top: 15px" width="250" id="showImage" class="mt-2 img-fluid mb-3" src="@if(@$product->default_photo) {{asset($product->default_photo)}} @else {{asset('public/frontend')}}/default_image/no-image-icon.png @endif" alt="image">
                                                         </div>
                                                     </div>
                                                     <div class="modal-footer">
                                                         <button type="button" class="btn btn-info" data-dismiss="modal">Ok</button>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-sm-12">
                                     <div class="form-group">
                                         <input type="submit" value="Update" class="btn btn-primary">
                                         <a href="{{route('product.index')}}" class="btn btn-info">Back</a>
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






 <!-- Sale unit modal -->
 <div class="modal fade" id="exampleModal4" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Unit
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </h4>

             </div>
             <form action="">
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Unit Name </label>
                         <input type="text" class="form-control" placeholder="Unit Name">
                     </div>
                     <div class="form-group">
                         <label>Description </label>
                         <input type="text" class="form-control" placeholder="Description">
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-info">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div>



 <!-- Purchase unit modal -->
 <div class="modal fade" id="addPurchaseUnitModal" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Unit
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </h4>

             </div>
             <form id="addPurchaseUnit" action="{{route('unitCreateByAjax')}}" method="POST">
             @csrf
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Unit Name </label>
                         <input name="name" type="text" class="form-control" placeholder="Unit Name">
                         <span id="name_0"></span>
                     </div>
                     <div class="form-group">
                         <label>Description </label>
                         <input name="description" type="text" class="form-control" placeholder="Description">
                        <span id="description_1"></span>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-info">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div>




 <!-- Supplier modal -->
 <div class="modal fade" id="supplierModal" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Supplier
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </h4>

             </div>
             <form action="{{route('supplierCreateByAjax')}}" method="POST" id="addSupplier">
                @csrf
                <div class="modal-body">
                     <div class="form-group">
                         <label>Supplier Name* </label>
                         <input type="text" required name="name" class="form-control" placeholder="Supplier Name">
                     </div>
                     <div class="form-group">
                         <label>Contact Person*</label>
                         <input type="text" name="contract_person" class="form-control" placeholder="Contact Person">
                     </div>
                     <div class="form-group">
                         <label>Phone*</label>
                         <input type="text" name="phone" class="form-control" placeholder="Phone">
                     </div>
                     <div class="form-group">
                         <label>Email </label>
                         <input type="text" name="email" class="form-control" placeholder="Email">
                     </div>
                     <div class="form-group">
                         <label>Previour Due </label>
                         <input type="number"  step="any" name="previous_due"  class="form-control" placeholder="Previour Due">
                     </div>
                     <div class="form-group">
                         <label>Address </label>
                         <textarea name="address" class="form-control"></textarea>
                     </div>
                     <div class="form-group">
                         <label>Description </label>
                         <textarea name="description" class="form-control"></textarea>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                     <button type="submit" id="supplierSubmit" class="btn btn-info">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div>




 <!-- add Brand Modal -->
 <div class="modal fade" id="addBrandModal" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Brand
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </h4>

             </div>
             <form id="addBrand" action="{{route('breandCreateByAjax')}}" method="POST">
             @csrf
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Name </label>
                         <input required="required" name="name" type="text" class="form-control" placeholder="Name">
                     </div>
                     <div class="form-group">
                         <label>Description </label>
                         <input name="description" type="text" class="form-control" placeholder="Description">
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-info">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <!-- Category modal -->
 <div class="modal fade" id="categoryModal" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Item Category
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </h4>

             </div>
             <form action="{{route('categoryCreateByAjax')}}" method="POST" id="addCategory">
                @csrf
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Name </label>
                         <input name="name" type="text" class="form-control" placeholder="Name">
                     </div>
                     <div class="form-group">
                         <label>Description </label>
                         <input name="description"  type="text" class="form-control" placeholder="Description">
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-info">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

    @push('js')
        <!-----for Ajax handeling----->
        <script type="text/javascript">
            $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
        </script>
        <!-----for Ajax handeling----->

        <script>
            $(document).ready(function(){



                //=========================== Add Supplier==============================
                        $('#addSupplier').on("submit",function(e){
                        e.preventDefault();

                        var form = $(this);
                        var url = form.attr("action");
                        var type = form.attr("method");
                        var data = form.serialize();
                                $.ajax({
                                url: url,
                                data: data,
                                type: type,
                                datatype:"JSON",
                                beforeSend:function(){
                                    //$('.loading').fadeIn();
                                },
                                success: function(response){
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#supplier_id").html(html);
                                                $('#supplierModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#supplier_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }else{
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                complete:function(){
                                    //$('.loading').fadeOut();
                                    console.log('complete');
                                },
                        });
                        //end ajax
                        });
                //=========================== Add Supplier==============================


                //=========================== Add Category==============================
                    $('#addCategory').on("submit",function(ee){
                        ee.preventDefault();

                        var form = $(this);
                        var url = form.attr("action");
                        var type = form.attr("method");
                        var data = form.serialize();
                                $.ajax({
                                url: url,
                                data: data,
                                type: type,
                                datatype:"JSON",
                                beforeSend:function(){
                                    //$('.loading').fadeIn();
                                },
                                success: function(response){
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#category_id").html(html);
                                                $('#categoryModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#category_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }else{
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                complete:function(){
                                    //$('.loading').fadeOut();
                                    console.log('complete');
                                },
                        });
                        //end ajax
                    });
                //=========================== Add Category==============================


                //=========================== Add Brand==============================
                    $('#addBrand').on("submit",function(ee){
                        ee.preventDefault();

                        var form = $(this);
                        var url = form.attr("action");
                        var type = form.attr("method");
                        var data = form.serialize();
                                $.ajax({
                                url: url,
                                data: data,
                                type: type,
                                datatype:"JSON",
                                beforeSend:function(){
                                    //$('.loading').fadeIn();
                                },
                                success: function(response){
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#brand_id").html(html);
                                                $('#addBrandModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#brand_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }else{
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                complete:function(){
                                    //$('.loading').fadeOut();
                                    console.log('complete');
                                },
                        });
                        //end ajax
                    });
                //=========================== Add Brand==============================


                //=========================== Add Unit==============================
                    $('#addPurchaseUnit').on("submit",function(ee){
                        ee.preventDefault();

                        var form = $(this);
                        var url = form.attr("action");
                        var type = form.attr("method");
                        var data = form.serialize();
                                $.ajax({
                                url: url,
                                data: data,
                                type: type,
                                datatype:"JSON",
                                beforeSend:function(){
                                    //$('.loading').fadeIn();
                                },
                                success: function(response){
                                        //===================Perfect Working===================
                                        if(response.status == 'success')
                                        {
                                            var len = 0;
                                            if(response['data'] != null){
                                                len = response['data'].length;
                                            }

                                            if(len > 0){
                                                // Read data and create <option >
                                                var html = '';
                                                for(var i=0; i<len; i++){
                                                    var id = response['data'][i].id;
                                                    var name = response['data'][i].short_name;
                                                    html += "<option value='"+id+"'>"+name+"</option>";
                                                }
                                                $("#purchase_unit_id").html(html);
                                                $('#addPurchaseUnitModal').modal("hide");
                                                form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                            }

                                            //=========this is also perfect working
                                            //$("#purchase_unit_id").html(response.data);
                                            //$('#supplierModal').modal("hide");
                                            //swal("Great","Successfully Updated Information","success");
                                            //form[0].reset();  //this for after completing processed, the all data of form will be clear.. like reset
                                        }
                                        else  if(response.status == 'errors')
                                        {
                                            console.log('ekhanne');
                                             console.log(response['data']);
                                            var leng = 0;
                                            if(response['data'] != null){
                                                leng = response['data'].length;
                                            }

                                            if(leng > 0){
                                                // Read data and create <option >
                                                for(var i=0; i<leng; i++){
                                                    //var id = response['data'][i].id;
                                                    //var name = response['data'][i].name;
                                                    console.log('leng');
                                                    $("#name_0").text('dkfj');
                                                    //$("#name_"+i).text(response['data'][i].name);
                                                }
                                                
                                            }
                                        }
                                        else{
                                            console.log('nai');
                                            //console.log('nai');
                                            //swal("Wrong","Information is not Updated","error");
                                        }
                                        //====================Perfect Working====================


                                    },
                                 error: function (reject) {
                                    if( reject.status === 422 ) {
                                        var errors = $.parseJSON(reject.responseText);
                                        $.each(errors, function (key, val) {
                                            $("#" + key + "_error").text(val[0]);
                                        });
                                    }
                                },
                                complete:function(reject){

                                    if( reject.status === 'errors' ) {
                                        console.log('eee');
                                        var errors = $.parseJSON(reject.responseText);
                                        $.each(errors, function (key, val) {
                                            $("#name_"+key).text(val[0]);
                                        });
                                    }
                                    //$('.loading').fadeOut();
                                },
                        });
                        //end ajax
                    });
                //=========================== Add Unit==============================



            });
        </script>
    @endpush

 @endsection

 
 
 
 
 


{{---==============================================================================================--}}
 {{--  
 @extends('home')
 @section('title','Edit Products')
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
             <li class="active">Edit Product</li>
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
                         <span class="widget-caption" style="font-size: 20px">Edit Product</span>
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
                         <form action="{{route('product.update',$product->id)}}" method="post" enctype="multipart/form-data">
                             @csrf
                             <div class="row">
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Supplier <a href="#" data-toggle="modal" data-target="#exampleModal2"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                         <select name="supplier_id" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($suppliers as $supplier)
                                             <option value="{{$supplier->id}}" @if( $product->supplier_id == $supplier->id ) selected @endif >{{$supplier->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('supplier_id'))?($errors->first('supplier_id')):''}}</div>


                                     </div>
                                 </div>

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Name</label>
                                         <input name="name" type="text" placeholder="Name" class="form-control" value="{{$product->name}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('name'))?($errors->first('name')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Purchase Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input name="purchase_price" type="number"  step="any" min="0" class="form-control" placeholder="Purchase Price" value="{{$product->purchase_price}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_price'))?($errors->first('purchase_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Sale Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input name="sale_price" type="number"  step="any" min="0" class="form-control" placeholder="Sale Price" value="{{$product->whole_sale_price}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('sale_price'))?($errors->first('sale_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Retail Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input name="retail_price" type="number"  step="any" min="0" class="form-control" placeholder="Retail Price" value="{{$product->retail_price}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('retail_price'))?($errors->first('retail_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">MRP Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input name="mrp_price" type="number"  step="any" min="0" class="form-control" placeholder="MRP Price" value="{{$product->mrp_price}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('mrp_price'))?($errors->first('mrp_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Online Sale Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input name="online_sell_price" type="number"  step="any" min="0" class="form-control" placeholder="Online Sale Price" value="{{$product->online_sell_price}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('online_sell_price'))?($errors->first('online_sell_price')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Online Discount Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input name="online_discount_price" type="number"  step="any" min="0" class="form-control" placeholder="Online Discount Price" value="{{$product->online_discount_price}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('online_discount_price'))?($errors->first('online_discount_price')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Category <a href="#" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                         <select name="category_id" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($categories as $category)
                                             <option value="{{$category->id}}" @if( $product->category_id == $category->id ) selected @endif >{{$category->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('category_id'))?($errors->first('category_id')):''}}</div>


                                     </div>
                                 </div>

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Brand <a href="#" data-toggle="modal" data-target="#exampleModal5"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                         <select name="brand_id" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($brands as $brand)
                                             <option value="{{$brand->id}}" @if( $product->brand_id == $brand->id ) selected @endif >{{$brand->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('brand_id'))?($errors->first('brand_id')):''}}</div>


                                     </div>
                                 </div>

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Purchase Unit <i class="fa fa-info-circle"></i><a href="#" data-toggle="modal" data-target="#exampleModal3"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                         <select name="purchase_unit" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($units as $unit)
                                             <option value="{{$unit->id}}" @if( $product->purchase_unit == $unit->id ) selected @endif >{{$unit->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_unit'))?($errors->first('purchase_unit')):''}}</div>


                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Sale Unit <i class="fa fa-info-circle"></i><a href="#" data-toggle="modal" data-target="#exampleModal4"><i class="fa fa-plus pull-right" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;"></i></a></label>
                                         <select name="sale_unit" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($units as $unit)
                                             <option value="{{$unit->id}}" @if( $product->sale_unit == $unit->id ) selected @endif >{{$unit->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('sale_unit'))?($errors->first('sale_unit')):''}}</div>


                                     </div>
                                 </div>

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Low Sale Qty <i class="fa fa-info-circle"></i></label>
                                         <input name="low_sale_qty" type="number"  step="any" min="0" placeholder="Low Sale Qty" class="form-control" value="{{$product->low_sale_qty}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('low_sale_qty'))?($errors->first('low_sale_qty')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Low Alert Qty <i class="fa fa-info-circle"></i></label>
                                         <input name="low_alert_qty" type="number"  step="any" min="0" placeholder="Low Alert Qty" class="form-control" value="{{$product->low_alert_qty}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('low_alert_qty'))?($errors->first('low_alert_qty')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Warranty <i class="fa fa-info-circle"></i></label>
                                         <input name="warranty" type="text" placeholder="eg: 1 Year" class="form-control" value="{{$product->warranty}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('warranty'))?($errors->first('warranty')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Guarantee <i class="fa fa-info-circle"></i></label>
                                         <input name="guarantee" type="text" placeholder="eg: 1 Year" class="form-control" value="{{$product->guarantee}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('guarantee'))?($errors->first('guarantee')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Description</label>
                                         <input name="description" type="text" placeholder="Description" class="form-control" value="{{$product->description}}">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('description'))?($errors->first('description')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <a style="margin-top: 23px" href="#" class="btn btn-info btn-block" data-toggle="modal" data-target="#exampleModal6"><i class="fa fa-edit"></i> Change Image</a>

                                         <!-- Add image modal -->
                                         <div class="modal fade" id="exampleModal6" role="dialog" aria-hidden="true">
                                             <div class="modal-dialog" role="document">
                                                 <div class="modal-content">
                                                     <div class="modal-header">
                                                         <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Image
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                 <span aria-hidden="true">&times;</span>
                                                             </button>
                                                         </h4>

                                                     </div>
                                                     <div class="modal-body">
                                                         <div class="form-group">
                                                             <label>Image </label>
                                                             <span class="file-input btn btn-block btn-info btn-file">
                                                                 Browse <input name="default_photo" id="image" type="file">
                                                             </span>

                                                             <img style="padding:4px;border:1px solid gray; margin-top: 15px" width="250" id="showImage" class="mt-2 img-fluid mb-3" src="@if(@$product->default_photo) {{asset($product->default_photo)}} @else {{asset('public/frontend')}}/default_image/no-image-icon.png @endif" alt="image">
                                                         </div>
                                                     </div>
                                                     <div class="modal-footer">
                                                         <button type="button" class="btn btn-info" data-dismiss="modal">Ok</button>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-sm-12">
                                     <div class="form-group">
                                         <input type="submit" value="Submit" class="btn btn-primary">
                                         <a href="#" class="btn btn-info">Back</a>
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






 <!-- Sale unit modal -->
 <div class="modal fade" id="exampleModal4" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Unit
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </h4>

             </div>
             <form action="">
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Unit Name </label>
                         <input type="text" class="form-control" placeholder="Unit Name">
                     </div>
                     <div class="form-group">
                         <label>Description </label>
                         <input type="text" class="form-control" placeholder="Description">
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-info">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <!-- Purchase unit modal -->
 <div class="modal fade" id="exampleModal3" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Unit
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </h4>

             </div>
             <form action="">
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Unit Name </label>
                         <input type="text" class="form-control" placeholder="Unit Name">
                     </div>
                     <div class="form-group">
                         <label>Description </label>
                         <input type="text" class="form-control" placeholder="Description">
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-info">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <!-- Supplier modal -->
 <div class="modal fade" id="exampleModal2" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Supplier
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </h4>

             </div>
             <form action="">
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Supplier Name </label>
                         <input type="text" class="form-control" placeholder="Supplier Name">
                     </div>
                     <div class="form-group">
                         <label>Contact Person </label>
                         <input type="text" class="form-control" placeholder="Contact Person">
                     </div>
                     <div class="form-group">
                         <label>Phone </label>
                         <input type="text" class="form-control" placeholder="Phone">
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-info">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <!-- Sale unit modal -->
 <div class="modal fade" id="exampleModal5" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Brand
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </h4>

             </div>
             <form action="">
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Name </label>
                         <input type="text" class="form-control" placeholder="Name">
                     </div>
                     <div class="form-group">
                         <label>Description </label>
                         <input type="text" class="form-control" placeholder="Description">
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-info">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <!-- Category modal -->
 <div class="modal fade" id="exampleModal" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Add Item Category
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </h4>

             </div>
             <form action="">
                 <div class="modal-body">
                     <div class="form-group">
                         <label>Name </label>
                         <input type="text" class="form-control" placeholder="Name">
                     </div>
                     <div class="form-group">
                         <label>Description </label>
                         <input type="text" class="form-control" placeholder="Description">
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-info">Submit</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 @endsection
  --}}