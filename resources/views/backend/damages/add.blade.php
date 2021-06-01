 @extends('home')
 @section('title','Add New Damage Product')
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
             <li class="active">Add Damage Product</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
      
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Add Damage Product</span>
                    </div>
                     <div class="widget-body">
                         <form action="{{route('damage.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                             <div class="row">
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Supplier</label>
                                          <select name="supplier_id" id="supplier_id" class="form-control">
                                              <option value="">Select Supplier</option>
                                               @foreach($suppliers as $supplier)
                                               <option value="{{ $supplier->id }}"> {{ $supplier->name }} </option>
                                               @endforeach
                                          </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('supplier_id'))?($errors->first('supplier_id')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Product </label>
                                          <select name="product_id" id="product_id" class="form-control">
                                              <option value="">Select Product</option>

                                          </select>
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('product_id'))?($errors->first('product_id')):''}}</div>
                                     </div>
                                 </div>



                                   <script>

                                        function offer(){
                                          var price = document.getElementById('price').value;
                                          var quantity = document.getElementById('quantity').value;
                                         

                                          if(price <= 1){
                                             var result = price * 1;
                                          }
                                          else if(quantity){
                                            var result = price * quantity;
                                          }
                         

                                           if (!isNaN(result)) {
                                            document.getElementById('total_price').value = result;
                                          }
                                        }

                                      </script>




                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="">Price</label>
                                         <input name="price" id="price" value="{{old('price')}}"  onkeyup="offer()" type="text" placeholder="Price" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('price'))?($errors->first('price')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="">Quantity</label>
                                         <input name="quantity" id="quantity" type="text"  onkeyup="offer()" value="{{old('quantity')}}" placeholder="Quantity" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('quantity'))?($errors->first('quantity')):''}}</div>
                                     </div>
                                 </div>


                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="">Total Price</label>
                                         <input name="total_price" id="total_price"  onkeyup="offer()" type="text" value="{{old('total_price')}}" placeholder="Total Price" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('total_price'))?($errors->first('total_price')):''}}</div>
                                     </div>
                                 </div>


                                  
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <input class="btn btn-primary" type="submit" value="Submit">
                                         <a href="{{route('damage.index')}}" class="btn btn-info">Back</a>
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
    <script>
        
          $(document).on("change", "#supplier_id", function(){

            var supplier_id = $(this).val();
            var url = "{{ route('find.supplier.product') }}";

            $.ajax({
                url: url,
                data: {supplier_id: supplier_id},
                type: "GET",
                success: function(response){
                    $("#product_id").html(response);
                },
            });

        });

    </script>
 @endpush
 @endsection
