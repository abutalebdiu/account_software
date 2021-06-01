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
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="width:45%;">
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>Sale Unit</label>
                                                    <select id="" name="" class="form-control">
                                                        <option value="">Sale Unit</option>
                                                    </select>
                                            </div>
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>Sale From Stock</label>
                                                <select id="" name="" class="form-control">
                                                    <option value="">Sale From Stock</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>Avaliable Stock</label>
                                                <select id="" name="" class="form-control">
                                                    <option value="">
                                                        Showroom Stock : 5
                                                    </option>
                                                    <option value="">
                                                        Godown Stock : 5
                                                    </option>
                                                </select>
                                            </div>
                                        </td>
                                        <td style="width:30%;">
                                            <div class="form-group" >
                                                <label class="btn btn-primary">
                                                    <input name="price" value="{{number_format($product->sale_price,2)}}" checked type="radio" class="priceClass colored-blue">
                                                    <span class="text"> Sale Price: tk {{$product->sale_price}}</span>
                                                </label>
                                            </div>
                                            <div class="form-group" >
                                                <label class="btn btn-warning">
                                                    <input name="price" value="{{ number_format($product->purchase_price,2)}}" type="radio" class="priceClass colored-blue">
                                                    <span class="text">Purchase Price: tk {{$product->purchase_price}}</span>
                                                </label>
                                            </div>
                                            <div class="form-group" >
                                                <label class="btn btn-info" >
                                                    <input name="price" value="{{number_format($product->whole_sale_price,2)}}" type="radio" class="priceClass colored-blue">
                                                    <span class="text"> Whole Sale Price: tk {{$product->whole_sale_price}}</span>
                                                </label>
                                            </div>
                                        </td>
                                        <td style="width:25%;">
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>Price</label>
                                                <input name="sale_price" class="form-control sallingPrice"  type="number" step="any" placeholder="Price">
                                            </div>
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>Quantity Amount (Pcs)</label>
                                                <input name="quantity" class="form-control quantity"  type="number" value="1" step="any" placeholder="Quantity Amount">
                                            </div>
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>
                                                    <small>Discount</small>: <br/>
                                                    <label style="cursor: pointer;margin-right:5px;">
                                                        <input name="discountType" value="percentage" type="radio" class="colored-blue discountTypeClass" style="font-size:12px;cursor: pointer">
                                                        <span class="text" style="font-size:12px;">Percentage (%)</span>
                                                    </label>
                                                    <label style="cursor: pointer">
                                                        <input name="discountType" checked value="fixed" type="radio" class="colored-blue discountTypeClass" style="font-size:12px;cursor: pointer">
                                                        <span class="text" style="font-size:12px;">Fixed</span>
                                                    </label>
                                                </label>
                                                <input class="form-control discountValue" name="discountValue" value="0" type="number" step="any" placeholder="Only Numeric Value">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  style="text-align: right">
                                            <strong>Total</strong>
                                        </td>
                                        <td>
                                            <strong id="totalQtyWithUnitId"> 400 </strong>
                                            <strong id="finalSaleUnitId">gm</strong>
                                        </td>
                                        <td>
                                            <strong id="totalAmount"><strong>
                                            <input type="hidden" name="netTotalAmount" value="" id="netTotalAmount">
                                        </td>
                                    </tr>
                                </table>
                            </div>
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
