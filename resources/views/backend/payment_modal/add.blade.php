<div class="modal fade payment_modal in" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="font-size: calc(100%); display: block;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{route('admin.purchaseBill')}}" accept-charset="UTF-8" id="transaction_payment_add_form" enctype="multipart/form-data">
                @csrf
                <input name="purchase_final_id" type="hidden" value="{{$purchase->id}}" />
                <input name="module_invoice_no"  type="hidden" value="{{$purchase->invoice_no}}" />
                <input name="supplier_id"  type="hidden" value="{{$purchase->supplier_id}}" />
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add payment</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="well">
                                <strong>
                                    Supplier
                                </strong>
                                : {{$purchase->suppliers?$purchase->suppliers->name:NULL}} <br />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="well">
                                <strong>Invoice No.: </strong> {{$purchase->invoice_no }}
                                <br />
                                <strong>Location: </strong>---
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="well"> 
                                <strong>Total amount: </strong><span class="display_currency" data-currency_symbol="true">৳ {{$purchase->totalPurchaseAmount()}}</span><br />
                                <strong>Paid Amount: </strong> {{$purchase->totalPaidAmount()}}
                                <input type="hidden" value="{{$purchase->totalPurchaseAmount() - $purchase->totalPaidAmount()}}" class="paid_amount" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <strong>Advance Balance:</strong> <span class="display_currency" data-currency_symbol="true">৳ 0.00</span> --}}

                            <input id="" data-error-msg="Required advance balance not available" name="" type="hidden" value="0.0000" />
                        </div>
                    </div>
                    <div class="row payment_row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="amount">Amount:*</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-money-bill-alt"></i>
                                    </span>
                                    <input
                                        class="form-control payment_amount"
                                        required=""
                                        placeholder="Amount"
                                        name="payment_amount"
                                        type="number"
                                        value="{{$purchase->totalPurchaseAmount() - $purchase->totalPaidAmount()}}"
                                        aria-required="true"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="paid_on">Paid on:*</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control" readonly="" required="" name="payment_date" type="text" value="{{date('d-m-Y')}}" id="" aria-required="true" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="method">Payment Method:*</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-money-bill-alt"></i>
                                    </span>
                                    <select name="payment_method_id" id="" class="payment_method_id_class form-control" required>
                                        <option value="">Select  Method</option>
                                        @foreach($payment_methods as $method)
                                            <option value="{{$method->id}}">{{$method->method}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="{{route('admin.getAccountByPaymentMethod')}}" class="getAccountByPaymentMethod" />

                        <!---Bank Account options---->
                        <div class="col-md-6 payment_account_div"  style="display:none;">
                            <div class="form-group">
                                <label for=""> Payment From Account </label>
                                <select name="account_id" id="bank_id" class="bank_id_class form-control" >
                                    <option value="">Select </option>
                                </select>
                                <div style='color:red; padding: 0 5px;'>{{($errors->has('total_purchase_amount'))?($errors->first('total_purchase_amount')):''}}</div>
                            </div>
                        </div>
                        <!---Bank Account options---->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="document">Attach Document:</label>
                                <input
                                    accept="application/pdf,text/csv,application/zip,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/jpg,image/png"
                                    name="document"
                                    type="file"
                                    id="document"
                                />
                                <p class="help-block">
                                    <br />
                                    Allowed File: .pdf, .csv, .zip, .doc, .docx, .jpeg, .jpg, .png
                                </p>
                            </div>
                        </div>

                        <!---card payment options---->
                            <div class="col-sm-12 col-md-12 card_div"   style="display:none;">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Card Number </label>
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
                                            <label for="">Card Expire Month</label>
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
                                    <label for="">Cheque No. </label>
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

                            <!-----payment Note--------->
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="">Payment note: </label>
                                    <textarea name="payment_note" value="" rows="3"  cols="50" class="form-control"></textarea>
                                    <div style='color:red; padding: 0 5px;'>{{($errors->has('payment_note'))?($errors->first('payment_note')):''}}</div>
                                </div>
                            </div>
                            <!---payment Note End--->

                            <!--------Payment part End--------->

                            <!--------Due part---->
                            <div class="col-sm-12 col-md-12">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Due Amount: </label>
                                            <input name="due_amount" type="text" class="total_due_amount_after_payment_class  form-control" readonly value="{{$purchase->totalPurchaseAmount() - $purchase->totalPaidAmount()}}" placeholder="Due Amount" style="font-size: 12px;color:red;font-weight:bold;">
                                            <div style='color:red; padding: 0 5px;'>{{($errors->has('due_amount'))?($errors->first('due_amount')):''}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--------Due part End---->
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="submit" disabled value="Save" class="btn btn-primary submitButton" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
