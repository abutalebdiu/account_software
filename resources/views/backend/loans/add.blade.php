 @extends('home')
 @section('title','Add Customer Loan')
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
             <li class="active">Add Customer Loan</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
    
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Add Customer Loan</span>
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
                         <form action="{{route('customer.loan.store')}}" method="post">
                            @csrf
                             <div class="row">



                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Select Customer</label>

                                         <select name="customer_id" class="form-control">
                                             <option value="">Select Customer</option>
                                             @foreach($customers as $customer)
                                             <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                             @endforeach
                                         </select>
                                          
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('customer_id'))?($errors->first('customer_id')):''}}</div>
                                     </div>
                                 </div> 

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Amount</label>
                                         <input name="amount" value="{{old('amount')}}" type="text" placeholder="Amount" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('amount'))?($errors->first('amount')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Loan Reason</label>
                                         <input name="loan_reason" type="text" value="{{old('loan_reason')}}" placeholder="Loan Reason" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('loan_reason'))?($errors->first('loan_reason')):''}}</div>
                                     </div>
                                 </div>
                                
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Loan Date</label>
                                         <input name="loan_date" type="date"  value="{{old('loan_date')}}" placeholder="Loan Date" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('loan_date'))?($errors->first('loan_date')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Retrun Date</label>
                                         <input name="return_date" type="date"  value="{{old('return_date')}}" placeholder="Return Date" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('return_date'))?($errors->first('return_date')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Description</label>
                                         <input name="note" type="text" value="{{old('note')}}" placeholder="Note" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('note'))?($errors->first('note')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Responsible Person</label>
                                         <input name="takenby" type="text" value="{{old('takenby')}}" placeholder="Responsible Person" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('takenby'))?($errors->first('takenby')):''}}</div>
                                     </div>
                                 </div>

                                

                             
                                <!---Bank Account options---->
                                <div class="col-sm-12 col-md-12 " >
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Payment Method:* </label>
                                                <select name="payment_method_id" id="" class="payment_method_id_class form-control">
                                                    <option value="">Select Payment Method</option>
                                                    @foreach($payment_methods as $method)
                                                    <option value="{{$method->id}}">{{$method->method}}</option>
                                                    @endforeach
                                                </select>
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('payment_method_id'))?($errors->first('payment_method_id')):''}}</div>
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{route('admin.getAccountByPaymentMethod')}}" class="getAccountByPaymentMethod" />

                                        
                                        <div class="col-sm-8 payment_account_div"  style="display:none;">
                                            <div class="form-group">
                                                <label for=""> Payment From Account </label>
                                                <select name="account_id" id="bank_id" class="bank_id_class form-control" >
                                                    <option value="">Select </option>
                                                </select>
                                                <div style='color:red; padding: 0 5px;'>{{($errors->has('total_purchase_amount'))?($errors->first('total_purchase_amount')):''}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---Bank Account options---->


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
                                        <textarea name="payment_note" value="" type="text" class="form-control"></textarea>
                                        <div style='color:red; padding: 0 5px;'>{{($errors->has('payment_note'))?($errors->first('payment_note')):''}}</div>
                                    </div>
                                </div>
                                <!---payment Note End--->

                                <!--------Payment part End--------->



                                 <div class="col-sm-12">
                                     <div class="form-group">
                                         <input class="btn btn-primary" type="submit" value="Submit">
                                         <a href="{{route('customer.loan.index')}}" class="btn btn-info">Back</a>
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
        <!---- payment methods----->
        <script src="{{ asset('public') }}/custom_js/backend/payment/receive_previous_bill.js?v=1"></script>
        <script src="{{ asset('public') }}/custom_js/backend/payment/add_payment_methods.js?v=1"></script>
        <!---- payment methods----->
    @endpush
 @endsection
