 @extends('home')
 @section('title','Add multiple Products')
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
             <li class="active">Add multiple Product</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
   
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Add multiple Product</span>
                     </div>
                     <div class="widget-body">
                         <form action="{{route('product.multiple.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                          

                            <div class="productentryform" id="productentryform">
                                
                           
                             <div class="row">
                                <div class="col-sm-4">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Supplier </label>
                                         <select id="supplier_id[]" name="supplier_id[]" class="form-control" required>
                                             <option value="">Select</option>
                                             @foreach($suppliers as $supplier)
                                             <option @if(isset($supplier_id)) {{ $supplier_id == $supplier->id ? " selected" : "" }} @endif value="{{$supplier->id}}">{{$supplier->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('supplier_id'))?($errors->first('supplier_id')):''}}</div>
                                     </div>
                                 </div>
                                  <div class="col-sm-3" >
                                     <br>
                                     <p> AS Code Serial : {{ $findsupplierascode }}</p>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Product Name</label>
                                         <input name="name[]" type="text" placeholder="Product Name" class="form-control" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('name'))?($errors->first('name')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 
                                    <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Category </label>
                                         <select name="category_id[]" id="category_id" class="form-control" required>
                                             <option value="">Select</option>
                                             @foreach($categories as $category)
                                             <option value="{{$category->id}}">{{$category->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('category_id'))?($errors->first('category_id')):''}}</div>


                                     </div>
                                 </div>
                                 
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Group Name</label>
                                         <select id="" name="group_id[]" class="group form-control">
                                             <option value="">Select Group</option>
                                             @foreach($groupes as $group)
                                             <option value="{{$group->id}}">{{$group->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('group_id'))?($errors->first('group_id')):''}}</div>
                                     </div>
                                 </div> 
                                 
                                <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Brand Name</label>
                                         <select id="brand_id" name="brand_id[]" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($brands as $brand)
                                             <option value="{{$brand->id}}">{{$brand->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('brand_id'))?($errors->first('brand_id')):''}}</div>
                                     </div>
                                 </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                         <label for="">Purchase Price (Tk) </label>
                                         <input name="purchase_price[]" type="text" step="any"  min="0" class="form-control" placeholder="Purchase Price" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_price'))?($errors->first('purchase_price')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">whole Sale Price (Tk) </label>
                                         <input name="whole_sale_price[]" type="text" step="any"  min="0" class="form-control" placeholder="whole Sale Price" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('whole_sale_price'))?($errors->first('whole_sale_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Sale Price (Tk) </label>
                                         <input name="sale_price[]" type="text" step="any"  min="0" class="form-control" placeholder="Sale Price (Regular Price)" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('sale_price'))?($errors->first('sale_price')):''}}</div>
                                     </div>
                                 </div>
                                
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">MRP Price (Tk) </label>
                                         <input name="mrp_price[]" type="text" step="any"  min="0" class="form-control" placeholder="MRP Price" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('mrp_price'))?($errors->first('mrp_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Offer Price (Tk) </label>
                                         <input name="online_sell_price[]" type="text" step="any"  min="0" class="form-control" placeholder="Offer Price" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('online_sale_price'))?($errors->first('online_sale_price')):''}}</div>
                                     </div>
                                 </div>

                                 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                         <label for="">Low Alert Qty </label>
                                         <input name="low_alert_qty[]" type="number" step="any"  min="0" placeholder="Low Alert Qty" class="form-control" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('low_alert_qty'))?($errors->first('low_alert_qty')):''}}</div>
                                    </div>
                                 </div>
                                 
                                 
                                 <input type="hidden" name="warrantity_period_type" value="months" />
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Warranty Period</label>
                                         <input name="warranty_period[]" type="text" step="any" placeholder="Warranty Period (month)" value="1" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('warranty_period'))?($errors->first('warranty_period')):''}}</div>
                                     </div>
                                 </div>

                               
                                
                                <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Purchase Unit </label>
                                         <select id="purchase_unit_id" name="purchase_unit[]" class="form-control" required>
                                             <option value="">Select</option>
                                             @foreach($units as $unit)
                                                @if ($unit->short_name)
                                                <option value="{{$unit->id}}">{{$unit->short_name}}</option>
                                                @endif
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_unit'))?($errors->first('purchase_unit')):''}}</div>
                                     </div>
                                 </div>
 
                                 <input type="hidden" name="guarantee_period_type[]" value="months" />
                              
                                  <input type="hidden" name="guarantee_period[]" value="" />
                                 
                                 <input type="hidden" name="expiry_period_type[]" value="months" />
                                 
                                 <input name="expiry_period[]" type="hidden" step="any" placeholder="Expiry Period (month)" value="1" class="form-control">
                                         
                                 
                                

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">AS Code</label>
                                         <input name="custom_code[]" type="text" placeholder="As Code" class="form-control" >
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('custom_code'))?($errors->first('custom_code')):''}}</div>
                                     </div>
                                 </div>
                                

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Company Code</label>
                                         <input name="company_code[]" type="text" placeholder="Company Code" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('company_code'))?($errors->first('company_code')):''}}</div>
                                     </div>
                                 </div>
                                 
                                  <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Product Grade Type </label>
                                         <select id="" name="grade_type_id[]" class="grade_type_id form-control">
                                             @foreach($grades as $grade)
                                             <option value="{{$grade->id}}">{{$grade->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('grade_type_id'))?($errors->first('grade_type_id')):''}}</div>
                                     </div>
                                 </div> 
  
                                  <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Description</label>
                                         <input name="description[]" type="text" placeholder="Description" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('description'))?($errors->first('description')):''}}</div>
                                     </div>
                                 </div>
                            </div>
                          </div>

                            <span class="container1photo">
                                               
                            </span>


                             <div class="row">
                                 <div class="col-sm-12">
                                     <div class="form-group">
                                           <a href="{{ route('product.index') }}" class="btn btn-info"><i class="fa fa-arrow-left"></i> Back</a>
                                         <input type="submit" value="Submit" class="btn btn-primary">
                                       
                                          <span class="add_form_fieldforphoto help-block btn btn-primary"> <i class="fa fa-plus"></i> Add More </span>
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


 

            });
        </script>
  


        <script>
                /*=========== for description update ============== */
                $(document).ready(function() {
                    var max_fields      = 20;
                    var wrapper         = $(".container1photo");
                    var add_button      = $(".add_form_fieldforphoto");
                 
                    var x = 1;
                    $(add_button).click(function(e){
                        e.preventDefault();
                        if(x < max_fields){
                            x++;
                            $(wrapper).append(` <div class="productentryform" id="productentryform">
                            <div class="col-md-12">
                                <hr style="border-color:red">
                            </div>
                                 <a href="#" class="delete btn btn-danger btn-sm text-right pull-right" >Delete</a>
                                
                           
                             <div class="row">
                              
                                <div class="col-sm-4">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Supplier </label>
                                         <select id="supplier_id[]" name="supplier_id[]" class="form-control" required>
                                             <option value="">Select</option>
                                             @foreach($suppliers as $supplier)
                                             <option @if(isset($supplier_id)) {{ $supplier_id == $supplier->id ? " selected" : "" }} @endif value="{{$supplier->id}}">{{$supplier->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('supplier_id'))?($errors->first('supplier_id')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3" >
                                     <br>
                                     <p> AS Code Serial : {{ $findsupplierascode }}</p>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Product Name</label>
                                         <input name="name[]" type="text" placeholder="Product Name" class="form-control" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('name'))?($errors->first('name')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 
                                    <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Category </label>
                                         <select name="category_id[]" id="category_id" class="form-control" required>
                                             <option value="">Select</option>
                                             @foreach($categories as $category)
                                             <option value="{{$category->id}}">{{$category->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('category_id'))?($errors->first('category_id')):''}}</div>


                                     </div>
                                 </div>
                                 
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Group Name</label>
                                         <select id="" name="group_id[]" class="group form-control">
                                             <option value="">Select Group</option>
                                             @foreach($groupes as $group)
                                             <option value="{{$group->id}}">{{$group->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('group_id'))?($errors->first('group_id')):''}}</div>
                                     </div>
                                 </div> 
                                 
                                <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Brand Name</label>
                                         <select id="brand_id" name="brand_id[]" class="form-control">
                                             <option value="">Select</option>
                                             @foreach($brands as $brand)
                                             <option value="{{$brand->id}}">{{$brand->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('brand_id'))?($errors->first('brand_id')):''}}</div>
                                     </div>
                                 </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                         <label for="">Purchase Price (Tk) </label>
                                         <input name="purchase_price[]" type="text" step="any"  min="0" class="form-control" placeholder="Purchase Price" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_price'))?($errors->first('purchase_price')):''}}</div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">whole Sale Price (Tk) </label>
                                         <input name="whole_sale_price[]" type="text" step="any"  min="0" class="form-control" placeholder="whole Sale Price" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('whole_sale_price'))?($errors->first('whole_sale_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Sale Price (Tk) </label>
                                         <input name="sale_price[]" type="text" step="any"  min="0" class="form-control" placeholder="Sale Price (Regular Price)" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('sale_price'))?($errors->first('sale_price')):''}}</div>
                                     </div>
                                 </div>
                                
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">MRP Price (Tk) </label>
                                         <input name="mrp_price[]" type="text" step="any"  min="0" class="form-control" placeholder="MRP Price" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('mrp_price'))?($errors->first('mrp_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Offer Price (Tk) </label>
                                         <input name="online_sell_price[]" type="text" step="any"  min="0" class="form-control" placeholder="Offer Price" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('online_sale_price'))?($errors->first('online_sale_price')):''}}</div>
                                     </div>
                                 </div>

                                 
                                <div class="col-sm-3">
                                    <div class="form-group">
                                         <label for="">Low Alert Qty </label>
                                         <input name="low_alert_qty[]" type="number" step="any"  min="0" placeholder="Low Alert Qty" class="form-control" required>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('low_alert_qty'))?($errors->first('low_alert_qty')):''}}</div>
                                    </div>
                                 </div>
                                 
                                 
                                 <input type="hidden" name="warrantity_period_type" value="months" />
                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Warranty Period</label>
                                         <input name="warranty_period[]" type="text" step="any" placeholder="Warranty Period (month)" value="1" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('warranty_period'))?($errors->first('warranty_period')):''}}</div>
                                     </div>
                                 </div>

                               
                                
                                <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Purchase Unit </label>
                                         <select id="purchase_unit_id" name="purchase_unit[]" class="form-control" required>
                                             <option value="">Select</option>
                                             @foreach($units as $unit)
                                                @if ($unit->short_name)
                                                <option value="{{$unit->id}}">{{$unit->short_name}}</option>
                                                @endif
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_unit'))?($errors->first('purchase_unit')):''}}</div>
                                     </div>
                                 </div>
 
                                 <input type="hidden" name="guarantee_period_type[]" value="months" />
                              
                                  <input type="hidden" name="guarantee_period[]" value="" />
                                 
                                 <input type="hidden" name="expiry_period_type[]" value="months" />
                                 
                                 <input name="expiry_period[]" type="hidden" step="any" placeholder="Expiry Period (month)" value="1" class="form-control">
                                         
                                 
                                

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">AS Code</label>
                                         <input name="custom_code[]" type="text" placeholder="As Code" class="form-control" >
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('custom_code'))?($errors->first('custom_code')):''}}</div>
                                     </div>
                                 </div>
                                

                                 <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Company Code</label>
                                         <input name="company_code[]" type="text" placeholder="Company Code" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('company_code'))?($errors->first('company_code')):''}}</div>
                                     </div>
                                 </div>
                                 
                                  <div class="col-sm-3">
                                     <div class="form-group">
                                         <label style="display: block;" for="">Product Grade Type </label>
                                         <select id="" name="grade_type_id[]" class="grade_type_id form-control">
                                             @foreach($grades as $grade)
                                             <option value="{{$grade->id}}">{{$grade->name}}</option>
                                             @endforeach
                                         </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('grade_type_id'))?($errors->first('grade_type_id')):''}}</div>
                                     </div>
                                 </div> 
  
                                  <div class="col-sm-3">
                                     <div class="form-group">
                                         <label for="">Description</label>
                                         <input name="description[]" type="text" placeholder="Description" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('description'))?($errors->first('description')):''}}</div>
                                     </div>
                                 </div>
                            </div>
                          </div>`); //add input box
                        }
                  else
                  {
                  alert('You Reached the limits')
                  }
                    });
                 
                    $(wrapper).on("click",".delete", function(e){
                        e.preventDefault(); $(this).parent('div').remove(); x--;
                    })
                });  
     
        </script>
  @endpush


 @endsection
