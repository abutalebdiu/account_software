                      


    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Quotation
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h4>
            </div>
            <form action="{{route('sale.storeFromAddToCartWithPayment')}}" method="POST" class="submitStoreFromAddToCartWithPayment"> <!------>
                
                <div class="modal-body">
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" name="customer_name" placeholder="Customer Name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Customer Phone<strong style="color:red">*</strong> <small style="font-size:8px;color:red;">(Minimum 6 , Maximum 20)</small></label>
                        <input type="text" name="phone" min="6" placeholder="Customer Phone Number" autofocus autocomplete="off" class="customer_phone form-control">
                    </div>
                    <div class="form-group">
                        <label>Quotation Number/Serial/ Others</label>
                        <input type="text" name="quotation_no" placeholder="Quptation Number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Validate Date</label>
                        <input type="date" name="validate_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Quotation Note</label>
                        <textarea name="quotation_note" class="form-control"></textarea>
                    </div>
                </div>
                @php
                $cartName = session()->has('cartName') ? session()->get('cartName')  : [];
                @endphp
                @foreach ($cartName as $key => $item)
                    <label>
                        <input type="hidden"  name="product_id[]"  value="{{ $item['productVari_id'] }}"/>
                        <input type="hidden"  name="purchase_price[]"  value="{{ $item['purchase_price'] }}"/>
                        <input type="hidden"  name="sale_price[]"  value="{{ $item['sale_price'] }}"/>
                        <input type="hidden"  name="quantity[]"  value="{{ $item['quantity'] }}"/>
                        <input type="hidden"  name="discount_value[]"  value="{{ $item['discountValue'] }}"/>
                        <input type="hidden"  name="discount_type[]"  value="{{ $item['discountType'] }}"/>
                        <input type="hidden"  name="product_sub_Total_sale_amount[]"  value="{{ $item['netTotalAmount'] }}"/>
                        <input type="hidden"  name="identity_number[]"  value="{{ $item['identityNumber'] }}"/>

                        <input type="hidden"  name="sale_type_id[]"  value="{{ $item['sale_type_id'] }}"/>
                        <input type="hidden"  name="sale_from_stock_id[]"  value="{{ $item['sale_from_stock_id'] }}"/>
                        <input type="hidden"  name="sale_unit_id[]"  value="{{ $item['sale_unit_id'] }}"/>
                    </label>
                    <br/>
                @endforeach
                <br/>
                <input type="hidden" name="customer_id" value="{{$customer_id}}"/>
                <input type="hidden" name="reference_id" value="{{$reference_id}}"/>
                <input type="hidden" name="fianl_total_item" value="{{$fianl_total_item}}"/>
                <input type="hidden" name="final_sub_total_amount" value="{{$final_sub_total_amount}}"/>
                <input type="hidden" name="final_discount_type" value="{{$final_discount_type}}"/>
                <input type="hidden" name="final_discount_value" value="{{$final_discount_value}}"/>
                <input type="hidden" name="final_discount_amount" value="{{$final_discount_amount}}"/>
                <input type="hidden" name="fianl_other_cost" value="{{$fianl_other_cost}}"/>
                <input type="hidden" class="cr_fianl_payable_amount_get" id="fianl_payable_amount_get" name="fianl_payable_amount" value="{{$fianl_payable_amount}}"/>

                <input type="hidden"  name="invoice_status" value="2"/>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Submit" class="btn btn-info">
                </div>
            </form>
        </div>
    </div>

