<div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">{{$product->name}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>

                </div>
                <form action="{{route('sale.addToCartFromModal')}}" method="POST" id="addToCartFromProductShortDetailModal">
                    @csrf
                    <div class="modal-body">
                        <p><strong>Current Stock : {{$product->initial_stock}}</strong></p>

                        <input type="hidden" value="{{$product->id}}" name="product_id" />

                        <div class="row">
                            <div class="col-md-4">
                                <div class="radio text-center">
                                    <label>
                                        <input name="price" value="{{ number_format($product->purchase_price,2)}}" type="radio" class="priceClass colored-blue">
                                        <span class="text">Purchase Price: tk {{$product->purchase_price}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="radio text-center">
                                    <label>
                                        <input name="price" value="{{number_format($product->whole_sale_price,2)}}" type="radio" class="priceClass colored-blue">
                                        <span class="text"> Whole Sale Price: tk {{$product->whole_sale_price}}</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="radio text-center">
                                    <label>
                                        <input name="price" value="{{number_format($product->sale_price,2)}}" checked type="radio" class="priceClass colored-blue">
                                        <span class="text"> Sale Price: tk {{$product->sale_price}}</span>
                                    </label>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-4">
                                <label>Price</label>
                                <input name="sale_price" class="form-control sallingPrice"  type="number" step="any" placeholder="Price">
                            </div>
                            <div class="col-md-4">
                                <label>Quantity Amount (Pcs)</label>
                                <input name="quantity" class="form-control quantity"  type="number" value="1" step="any" placeholder="Quantity Amount">
                            </div>
                            <div class="col-md-4">
                                    <label>
                                        Discount : 
                                        <input name="discountType" value="percentage" type="radio" class="colored-blue discountTypeClass" style="font-size:11px;">
                                        <span class="text" style="font-size:11px;">Percentage</span>
                                        <input name="discountType" checked value="fixed" type="radio" class="colored-blue discountTypeClass" style="font-size:11px;">
                                        <span class="text" style="font-size:11px;">Fixed</span>
                                    </label>
                                <input class="form-control discountValue" name="discountValue" value="0" type="number" step="any" placeholder="Only Numeric Value">
                            </div>
                        </div>

                        <div class="row" style="margin:5px 5px;">
                            <div class="col-sm-9"></div>
                            <div class="col-sm-3">
                                <label style="text-align:right">Total Amount : Tk</label>
                                <strong id="totalAmount"><strong>
                            </div>
                             <input type="hidden" name="netTotalAmount" value="" id="netTotalAmount">
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <label>IMEI/Serial/Chassis/Engine Number</label>
                                <textarea name="identityNumber" rows="3" class="form-control" placeholder="Enter..."></textarea>
                               
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Add To Cart</button>
                    </div>
                </form>
            </div>
        </div>