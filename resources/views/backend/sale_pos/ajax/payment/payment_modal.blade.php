<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Finalize Sale
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </h4>

        </div>
        <form action="{{route('sale.storeFromAddToCartWithPayment')}}" method="POST" class="submitStoreFromAddToCartWithPayment">
        
            <div class="modal-body" >
                <div class="row"  style="margin-top:-5%;">
                    <div class="col-sm-12" >
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
                        
                        <input type="hidden"  name="invoice_status" value="1"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <p style="border:1px dotted red;color:red;
                            padding: 10px;
                            border-bottom-right-radius: 25px;    
                            ;
                        ">
                            Previous Due <span class="pull-right">tk <strong>{{$total_due_amount->totalDueAmount()}}</strong>
                            </span>
                        </p>
                        <p>Grand Total <span class="pull-right">tk <strong>{{$fianl_payable_amount}}</strong></span></p>
                        <p>Total Payable <span class="pull-right">tk <strong>{{$fianl_payable_amount}}</strong></span></p>
                    </div>
                </div>
                <hr>
                <div class="row" style="margin:2%;">
                    <div class="col-sm-6">
                        <label>Paid Amount</label>
                        <input type="number" step="any" id="final_payable_amount"  name="paid_amount" value="{{$fianl_payable_amount}}" placeholder="Paid Amount" class="cr_final_payable_amount form-control">
                    </div>
                    <div class="col-sm-6">
                        <label>Due Amount</label>
                        <input type="number" step="any" id=""  disabled value="" placeholder="Due Amount" class="cr_final_due_amount form-control">
                        <input type="hidden" step="any" id=""  name="due_amount" value="" placeholder="Due Amount" class="cr_final_due_amount form-control">
                    </div>
                </div>

                
                <div style="border:1px dashed red;">
                    <p class="text-center mt-10">
                        <strong>This section just to help</strong>
                    </p>
                    <div class="row mt-10" style="margin-bottom:2%;padding:0 2% 0 2%;">
                        <div class="col-sm-6">
                            <label>Given Amount</label>
                            <input type="number" step="any" id=""   placeholder="Given Amount" class="cr_given_amount_for_take_and_change form-control">
                        </div>
                        <div class="col-sm-6">
                            <label>Change Amount</label>
                            <input type="number" step="any" disabled id="" placeholder="Change Amount" class="cr_change_amount_after_calculation form-control">
                        </div>
                    </div>
                </div>
                
                <div class="row mt-10" style="margin-top:10px;">
                    <div class="col-sm-12"style="text-align:center">
                        <label >Account</label>
                            <hr/ style="margin-top: 0px;margin-bottom: 0px;">
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="method">Payment Method:*</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fas fa-money-bill-alt"></i>
                                </span>
                                <select name="payment_method_id" id="" class="payment_method_id_class form-control">
                                    <option value="">Select  Method</option>
                                    @foreach($payment_methods as $method)
                                        <option value="{{$method->id}}">{{$method->method}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" value="{{route('admin.getAccountByPaymentMethod')}}" class="getAccountByPaymentMethod" />
                    </div>
                    <div class="col-sm-6">
                        
                    </div>
                

                <!---Bank Account options---->
                <div class="col-md-6 payment_account_div"  style="display:none;">
                    <div class="form-group">
                        <label for=""> Receive Payment To Account </label>
                        <select name="account_id" id="bank_id" class="bank_id_class form-control" >
                            <option value="">Select </option>
                        </select>
                        <div style='color:red; padding: 0 5px;'>{{($errors->has('total_purchase_amount'))?($errors->first('total_purchase_amount')):''}}</div>
                    </div>
                </div>
                <!---Bank Account options---->
                
                <!---card payment options---->
                    <div class="col-sm-12 col-md-12 card_div"   style="display:none;">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Card Number</label>
                                    <input name="card_number" value="0"  id="card_number_id" type="text" class="form-control">
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('card_number'))?($errors->first('card_number')):''}}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Card holder name* <small></small></label>
                                    <input name="card_holder_name" id="card_holder_name_id" type="text" class="form-control" value="">
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('card_holder_name'))?($errors->first('card_holder_name')):''}}</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Card Transaction No</label>
                                    <input name="card_transaction_no" id="card_transaction_no_id" type="text" class="form-control" value="">
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('card_transaction_no'))?($errors->first('card_transaction_no')):''}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Card Type </label>
                                    <select name="card_type" id="card_type_id"  class="form-control">
                                        <option value="">Select Card Type</option>
                                            @foreach (cardType_HH() as $item) 
                                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('advance_balance'))?($errors->first('advance_balance')):''}}</div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for=""><small>Card Expire Month</small></label>
                                    <select name="expire_month" class="form-control" id="">
                                        @foreach (months_HH() as $item) 
                                            <option value="{{$item['id']}}">{{$item['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('expire_month'))?($errors->first('expire_month')):''}}</div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Card Expire Year</label>
                                    <select name="expire_year" class="form-control">
                                        @foreach (years_HH() as $item)
                                            <option value="{{$item}}">{{$item}}</option>
                                        @endforeach
                                    </select>
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('expire_year'))?($errors->first('expire_year')):''}}</div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Security Code</label>
                                    <input name="card_security_code" type="text" class="form-control" value="">
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('card_security_code'))?($errors->first('card_security_code')):''}}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!---card payment options end---->
                    
                    <!---From Mobile Banking Account---->
                    <div class="col-sm-12 col-md-12 from_mobile_banking_account_div" id="" style="display:none;">
                        <div class="form-group">
                            <label for="">From Mobile Banking Account</label>
                            <input  name="from_mobile_banking_account" value="" type="text" class="form-control">
                            <div style='color:red; padding: 0 5px;'>{{($errors->has('from_mobile_banking_account'))?($errors->first('from_mobile_banking_account')):''}}</div>
                        </div>
                    </div>
                    <!---From Mobile Banking Account end---->
                    <!---Cheque No---->
                    <div class="col-sm-12 col-md-12 cheque_div" id="" style="display:none;">
                        <div class="form-group">
                            <label for="">Cheque No <small>(Customer Cheque No)</small> </label>
                            <input  name="cheque_no" value="" type="text" class="form-control">
                            <div style='color:red; padding: 0 5px;'>{{($errors->has('cheque_no'))?($errors->first('cheque_no')):''}}</div>
                        </div>
                    </div>
                    <!---Cheque No end---->

                    <!---Bank Transfer No---->
                    <div class="col-sm-12 col-md-12 bank_transfer_div"   style="display:none;">
                        <div class="form-group">
                            <label for="">Bank Account No </label>
                            <input  name="transfer_bank_account_no" value="" type="text" class="form-control">
                            <div style='color:red; padding: 0 5px;'>{{($errors->has('transfer_bank_account_no'))?($errors->first('transfer_bank_account_no')):''}}</div>
                        </div>
                    </div>
                    <!---Bank Transfer No---->

                    <!---Others Transaction---->
                    <div class="col-sm-12 col-md-12 custom_payment_div" id=""  style="display:none;">
                        <div class="form-group">
                            <label for="">Transaction No. </label>
                            <input  name="transaction_no" value="" type="text" class="form-control">
                            <div style='color:red; padding: 0 5px;'>{{($errors->has('transaction_no'))?($errors->first('transaction_no')):''}}</div>
                        </div>
                    </div>
                    <!---Others Transaction---->
                    <!--------Payment part End--------->

                    <!--------Due part---->
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Due Amount: </label>
                                    <input name="due_amount" type="text" class="total_due_amount_after_payment_class cr_final_due_amount    form-control" readonly value="" placeholder="Due Amount" style="font-size: 12px;color:red;font-weight:bold;">
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('due_amount'))?($errors->first('due_amount')):''}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--------Due part End---->
                </div>
                <hr>
                <div class="row mt-10">
                    <div class="col-sm-6">
                        <div class="checkbox">
                            <label>
                                <input name="send_sms" value="1" type="checkbox" class="colored-blue">
                                <span class="text">Send Invoice Via SMS</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6 text-right">
                        <div class="checkbox">
                            <label>
                                <input  name="send_email" value="1" type="checkbox" class="colored-blue">
                                <span class="text">Send Invoice Via Email</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label>Account Note</label>
                        <textarea name="payment_note" rows="3" class="form-control" placeholder="Enter..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" id="hidden" class="btn btn-info">Submit</button>
            </div>
        </form>
    </div>
</div>