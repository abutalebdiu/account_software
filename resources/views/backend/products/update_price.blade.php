 
  @extends('home')
 @section('title','Add Products')
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
                         <span class="widget-caption" style="font-size: 20px">Update Price</span>
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
                         <form action="{{route('updatePriceStore',$product->id)}}" method="post" >
                            @csrf
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input disabled value="{{$product->name}}" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label style="display: block;" for="">Purchase Unit </label>
                                            <input disabled value="{{$product->purchaseUnit?$product->purchaseUnit->short_name:NULL}}" type="text" class="form-control">   
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label style="display: block;" for="">Supplier </label>
                                            <input disabled value="{{$product->suppliers?$product->suppliers->name:NULL}}" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <hr/><br/>
                                <input type="hidden" name="product_id" value="{{$product->id}}"/>
                                
                             <div class="row">
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="">Purchase Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->purchase_price}}" name="purchase_price" type="number"  step="any" min="0" class="form-control" placeholder="Purchase Price">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('purchase_price'))?($errors->first('purchase_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="">Sale Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->sale_price}}" name="sale_price" type="number"  step="any" min="0" class="form-control" placeholder="Sale Price (Regular Price)">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('sale_price'))?($errors->first('sale_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="">whole Sale Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->whole_sale_price}}" name="whole_sale_price" type="number"  step="any" min="0" class="form-control" placeholder="whole Sale Price">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('whole_sale_price'))?($errors->first('whole_sale_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="">MRP Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->mrp_price}}" name="mrp_price" type="number"  step="any" min="0" class="form-control" placeholder="MRP Price">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('mrp_price'))?($errors->first('mrp_price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="">Online Sale Price (Tk) <i class="fa fa-info-circle"></i></label>
                                         <input value="{{$product->online_sell_price}}" name="online_sell_price" type="number"  step="any" min="0" class="form-control" placeholder="Online Sale Price">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('online_sale_price'))?($errors->first('online_sale_price')):''}}</div>
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
           
     @endpush

 @endsection

 