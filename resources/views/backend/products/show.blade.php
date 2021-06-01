 @extends('home')
 @section('title','Show Product')
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
             <li class="active">Show Product</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
 
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Show Product</span>
                     </div>
                     <div class="widget-body">
                          <table class="table table-responsive table-bordered">
                              <tr>
                                  <th>Product Name</th>
                                  <td>{{ $product->name }}</td>
                             
                                  <th>Product ID</th>
                                  <td>{{ $product->id }}</td>
                              </tr> 
                               <tr>
                                  <th>AS Code</th>
                                  <td>{{ $product->custom_code }}</td>
                             
                                  <th>Company Code</th>
                                  <td>
                                      {{ $product->company_code }} <br>
                                  </td>
                              </tr> 
                              <tr>
                                  <th>Brand</th>
                                <td>{{$product->brand?$product->brand->name:NULL}}</td>
                             
                                  <th>Category</th>
                                  <td>{{ $product->categories?$product->categories->name:NULL }}</td>
                              </tr>
                              <tr>
                                  <th>Supplier</th>
                                    <td>{{$product->suppliers?$product->suppliers->name:NULL}}</td>
                             
                                  <th>Purchase Unit</th>
                                  <td>{{$product->purchaseUnit?$product->purchaseUnit->short_name:NULL}}</td>
                              </tr>
                              <tr>
                                  <th>Purchase Price</th>
                                  <td>{{ number_format($product->purchase_price,2,'.','')}}</td>
                                  <th>Sale Price</th>
                                  <td>
                                      {{ number_format($product->sale_price,2,'.','') }}
                                  </td>
                              </tr>
                              <tr>
                                  <th>Whole Price</th>
                                  <td>{{ number_format($product->whole_sale_price,2,'.','') }}</td>
                                  <th>MRP Price</th>
                                  <td>
                                      {{ number_format($product->mrp_price,2,'.','') }}
                                  </td>
                              </tr>
                              <tr>
                                  <th>Online Sale Price</th>
                                  <td>{{ number_format($product->online_sell_price,2,'.','') }}</td>
                                  <th>Low Alert Qty</th>
                                  <td>
                                      {{ $product->low_alert_qty }}
                                  </td>
                              </tr>


                              <tr>
                                  <th>Warranty Period</th>
                                  <td>
                                  @if ( $product->warranty_period)
                                    {{ $product->warranty_period }} Month
                                  @endif
                                  </td>
                                  <th>Grade Type</th>
                                  <td>
                                        {{$product->grades?$product->grades->name:NULL}}
                                  </td>
                                  {{--  <th>Guarantee Period </th>
                                  <td>
                                    @if ($product->guarantee_period)
                                      {{ $product->guarantee_period}} Month
                                    @endif
                                  </td>  --}}
                              </tr>

                              <tr>
                                  <th>Expiry Period</th>
                                  <td>
                                  @if ($product->expiry_period)
                                    {{ $product->expiry_period }} Month 
                                  @endif
                                  </td>
                                  <th>Description</th>
                                  <td>
                                      {{ $product->description }}
                                  </td>
                              </tr>





                              <tr>
                                  <th>Created At</th>
                                  <td>{{ $product->created_at }}</td>
                                  <th>Action</th>
                                  <td>
                                       <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                <li><a href="{{ route('product.index') }}"><i class="fa fa-check"></i>Back</a></li>
                                                <li><a href="{{ route('product.edit',$product->id) }}"><i class="fa fa-pencil tiny-icon"></i> Edit</a></li>
                                            </ul> 
                                        </div>
                                  </td>
                              </tr>
                          </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- /Page Body -->
 </div>
 <!-- /Page Content -->
 @endsection
