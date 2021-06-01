<div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">
                        {{$product->products->name}}
                        {{$product->sizes?" (".$product->sizes->name.")":NULL}}
                        {{$product->colors?" (".$product->colors->name.")":NULL}}
                        {{$product->weights?" (".$product->weights->name.")":NULL}}
                        - ({{$product->grades?$product->grades->name:NULL}})
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h4>
                </div>
                <form action="{{route('sale.addToCartWhenSubmitingFromModal')}}" method="POST" id="addToCartWhenSubmitingFromModal"> {{--id="addToCartFromProductShortDetailModal"--}}
                    @csrf
                     <input type="hidden" name="product_variation_id" value="{{$product->id}}" class="cr_product_variation_id_class" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <td style="width:45%;">
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>Sale Type</label>
                                                    <select id="" name="sale_type_id" class="cr_sale_type_class form-control">
                                                        <option value="1">Regular</option>
                                                        <option value="2">Offer</option>
                                                    </select>

                                                <input type="text" value="" class="cr_promo_code_running_class cr_promo_code_class form-control" placeholder="Type Promo code / offer code" id="" style="display:none;" />
                                            </div>
                                            <!----------------------------------->
                                                <input type="hidden" class="cr_promo_offer_activate_status_id_class" value="{{$promo_offer_activate_status}}"/>
                                                <input type="hidden" class="cr_promo_offer_code_class" value="{{$promo_offer_code}}"/>
                                            <!----------------------------------->
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>Sale From Stock</label>
                                                <select id="" name="sale_from_stock_id" class="cr_sale_from_stock_class form-control" data-class="cr_sale_from_stock_class">
                                                    @foreach($stocks as $stock)
                                                    <option value="{{$stock->id}}">{{$stock->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!---------------------------------------->
                                            <input type="hidden" value="{{route('sale.checkQtyAvailableByStockIdPvId')}}" class="cr_checkQtyAvailableByStockIdPvId"/>
                                            <!---------------------------------------->
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>Avaliable Stock</label>
                                                {{--  @foreach($primary_stocks as $stock)  --}}
                                                    <h5>
                                                        <strong class="cr_selected_stock_name_class"> {{--  {{$stock->stocks->name}}  --}}</strong> :
                                                        <strong class="cr_selected_stock_quantity_class">
                                                            {{--  {{availableStock_HH($product->default_sale_unit_id,$stock->available_stock)}}  --}}
                                                        </strong>
                                                        <strong class="cr_selected_stock_unit_name_class">
                                                            {{--  {{$product->defaultSaleUnits?$product->defaultSaleUnits->short_name:NULL}}  --}}
                                                        </strong>
                                                    </h5>
                                                {{--  @endforeach  --}}
                                            </div>
                                        </td>
                                        <td style="width:30%;">
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>Sale Unit</label>
                                                <select id="" name="sale_unit_id" data-class="cr_sale_unit_class" class="cr_sale_unit_id_class form-control">
                                                    @foreach($sale_units as $unit)
                                                    <option  {{$unit->id == $product->default_sale_unit_id?'selected':''}} value="{{ $unit->id }}">{{ $unit->short_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group" >
                                                <label class="btn btn-primary">
                                                    <input name="price" value="{{number_format($product->default_selling_price,2,'.', '')}}" checked type="radio" class="cr_priceClass cr_defalutSalePrice cr_defalutSalePriceClass colored-blue">
                                                    <span class="text"> Sale Price: tk
                                                        <span class="cr_defalutSalePriceClass_text">{{$product->default_selling_price}}</span>
                                                    </span>
                                                </label>
                                            </div>
                                             <div class="form-group">
                                                <label class="btn btn-info" >
                                                    <input name="price" value="{{number_format($product->whole_sale_price,2,'.', '')}}" type="radio" class="cr_priceClass cr_wholeSalePriceClass colored-blue">
                                                    <span class="text"> Whole Sale Price: tk
                                                        <span class="cr_wholeSalePriceClass_text">{{$product->whole_sale_price}}</span>
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="form-group" >
                                                <label class="btn btn-default">
                                                    <input name="price" value="{{ number_format($product->default_purchase_price,2,'.', '')}}" type="radio" class="cr_priceClass cr_defaultPurchasePriceClass colored-blue" disabled>
                                                    <span class="text" style="color: #ded8d8;">Purchase Price: tk
                                                            <span style="color: #d5bbbb;" class="cr_defaultPurchasePriceClass_text">{{$product->default_purchase_price}}</span>
                                                    </span>
                                                </label>
                                            </div>
                                            
                                            <div class="form-group" >
                                                <label class="btn btn-default">
                                                    <input name="price" value="{{ number_format($product->default_purchase_price,2,'.', '')}}" type="radio" class="cr_priceClass cr_defaultPurchasePriceClass colored-blue" disabled>
                                                    <span class="text" style="color: #ded8d8;">Offer Price: tk
                                                            <span style="color: #d5bbbb;" class="cr_defaultPurchasePriceClass_text">{{$product->online_sell_price}}</span>
                                                    </span>
                                                </label>
                                            </div>
                                            
                                            
                                            
                                           
                                            <div class="form-group cr_offer_sale_div" style="display:none;">
                                                <label class="btn btn-warning">
                                                    <input name="price" value="{{number_format($promo_offer_price,2,'.', '')}}" type="radio"  class="cr_priceClass cr_offerSaleClass colored-blue">
                                                    <span class="text"> Offer Sale Price: tk
                                                        <span class="cr_offerSaleClass_text"> {{number_format($promo_offer_price,2,'.', '')}}</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </td>
                                        <input type='hidden' value="{{ number_format($product->default_purchase_price,2,'.', '')}}" name="purchase_price" />

                                        <td style="width:25%;">
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>Price</label>
                                                <input name="sale_price" class="form-control cr_sallingPrice" type="number" step="any" placeholder="Price">
                                            </div>
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>Quantity Amount (Pcs)</label>
                                                <input name="quantity" class="cr_current_quantity_class form-control cr_quantity"  type="number" value="1" step="any" placeholder="Quantity Amount" data-class="cr_current_quantity_class">
                                                <strong style="color:red;font-size:10px;" class="cr_low_qty_alert_message"></strong>
                                            </div>
                                            <div class="form-group" style="background-color:rgb(241, 238, 238);padding:0px 5px 6px">
                                                <label>
                                                    <small>Less Amount</small>: <br/>
                                                    <label style="cursor: pointer;margin-right:5px;">
                                                        <input name="discountType" value="percentage" type="radio" class="colored-blue cr_discountTypeClass" style="font-size:12px;cursor: pointer">
                                                        <span class="text" style="font-size:12px;">Percentage (%)</span>
                                                    </label>
                                                    <label style="cursor: pointer">
                                                        <input name="discountType" checked value="fixed" type="radio" class="colored-blue cr_discountTypeClass" style="font-size:12px;cursor: pointer">
                                                        <span class="text" style="font-size:12px;">Fixed</span>
                                                    </label>
                                                </label>
                                                <input class="form-control cr_discountValue" name="discountValue" value="0" type="number" step="any" placeholder="Only Numeric Value">
                                                <strong class="cr_subtotal_amount" style="font-size:11px;"></strong>
                                                <strong class="cr_discount_amount pull-right" style="font-size:11px;"></strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td  style="text-align: right">
                                            <strong>Total</strong>
                                        </td>
                                        <td>
                                            <strong id="totalQtyWithUnitId" class="cr_totalQty_class">  </strong>
                                            <strong id="finalSaleUnitId" class="cr_finalSaleUnitId_class"></strong>
                                            <input type="hidden" name="selling_unit_name" value="" class="cr_finalSaleUnitId_class_text"/>
                                        </td>
                                        <td>
                                            <strong class="cr_totalAmount"></strong>
                                            <input type="hidden" name="netTotalAmount" value="" class="cr_netTotalAmount"/>
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
                        <button type="submit" class="cr_addToCart_button btn btn-info">Add To Cart</button>
                    </div>
                </form>
            </div>
        </div>
