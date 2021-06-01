 @extends('home')
 @section('title','Product Damage')
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
             <li class="active">Product Damage</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
     
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px"> Product Damage</span>
                     </div>
                     <div class="widget-body" style="background-color: #fff;">

					    <form action="" method="get" accept-charset="utf-8">
                     	<div class="row">
					        <div class="col-md-2">
					            <div class="form-group"> 
					                <input type="date" id="date_search" @if(isset($date_search)) value="{{ $date_search }}" @endif name="date_search" class="form-control" placeholder="Date" value="">
					            </div> 
						     </div>
					        <div class="col-md-2">
					            <div class="form-group">
					                <button type="submit" class="btn btn-block btn-primary pull-left"><i class="fa fa-search"></i> Submit</button>
					            </div>
					        </div>
					        <div class="hidden-lg">
					            <div class="clearfix"></div>
					        </div> 
					         
					    </div>
					  

                     <div class="row">

					<div class="col-md-12">
						        
						                 
                    <h3 style="text-align: center;">Daily Summary Report</h3>
                    <h4 class="text-center">Date: @if(isset($date_search)) {{ $date_search }} @endif</h4>
                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Purchases</h4>
                    <hr>
                    <table style="width: 100%" class="table table-responsive">    
                        <tbody>

                        <tr role="row">
	                        <th class="sorting_asc" style="width: 163px;" >Date</th>
	                        <th class="sorting" style="width: 158px;">Payment Ref No.</th>
	                        <th class="sorting"style="width: 187px;" >Invoice No./Ref. No.</th>
	                        <th class="sorting" style="width: 133px;">Payment Module</th>
	                        <th class="sorting" style="width: 133px;">Amount</th>
	                        <th class="sorting" style="width: 10%;"><small>Credit/Debit</small></th>
	                        <th class="sorting" style="width: 133px;">Payment Method</th>
	                        <th class="sorting"  style="width: 84px;" >Account</th>
	                    </tr>
                        @foreach($purchases as $key => $payment)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">
                                        {{date('d-m-Y',strtotime($payment->payment_date))}}
                                    </td>
                                    <td>
                                        {{$payment->payment_reference_no}}
                                    </td>
                                    <td>
                                        {{$payment->module_invoice_no}}
                                    </td>
                                    <td>
                                        {{ getModuleName_HH($payment->module_id) }}
                                    </td>
                                    <td>
                                        {{ number_format($payment->payment_amount,2,'.','')}}
                                    </td>
                                     <td>
                                       <small> {{getCDFName_HH($payment->cdf_type_id)}} </small>
                                    </td>
                                    <td>
                                        <small style="font-size:11px;">
                                        {{$payment->paymentMethods?$payment->paymentMethods->method:NULL}}<br/>
                                        {{$payment->accounts?$payment->accounts->bank?"(".$payment->accounts->bank->short_name.")":NULL:NULL}}
                                        </small>
                                    </td>
                                    <td>
                                        <small style="font-size:13px;">
                                        {{$payment->accounts?$payment->accounts->account_name:NULL}}<br/>
                                        {{$payment->accounts?"(".$payment->accounts->account_no.")":NULL}}
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                	<td colspan="3"></td>
                                	<td>Total</td>
                                	<td>{{ $purchases->sum('payment_amount') }}</td>
                                </tr>
		                    </tbody>
		                </table> 

                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Sales</h4>
                    <hr>
                    <table style="width: 100%" class="table table-responsive">    
                        <tbody>


                         <tr role="row">
	                        <th class="sorting_asc" style="width: 163px;" >Date</th>
	                        <th class="sorting" style="width: 158px;">Payment Ref No.</th>
	                        <th class="sorting"style="width: 187px;" >Invoice No./Ref. No.</th>
	                        <th class="sorting" style="width: 133px;">Payment Module</th>
	                        <th class="sorting" style="width: 133px;">Amount</th>
	                        <th class="sorting" style="width: 10%;"><small>Credit/Debit</small></th>
	                        <th class="sorting" style="width: 133px;">Payment Method</th>
	                        <th class="sorting"  style="width: 84px;" >Account</th>
	                    </tr>


                         @foreach($sales as $key => $payment)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">
                                        {{date('d-m-Y',strtotime($payment->payment_date))}}
                                    </td>
                                    <td>
                                        {{$payment->payment_reference_no}}
                                    </td>
                                    <td>
                                        {{$payment->module_invoice_no}}
                                    </td>
                                    <td>
                                        {{ getModuleName_HH($payment->module_id) }}
                                    </td>
                                    <td>
                                        {{ number_format($payment->payment_amount,2,'.','')}}
                                    </td>
                                     <td>
                                       <small> {{getCDFName_HH($payment->cdf_type_id)}} </small>
                                    </td>
                                    <td>
                                        <small style="font-size:11px;">
                                        {{$payment->paymentMethods?$payment->paymentMethods->method:NULL}}<br/>
                                        {{$payment->accounts?$payment->accounts->bank?"(".$payment->accounts->bank->short_name.")":NULL:NULL}}
                                        </small>
                                    </td>
                                    <td>
                                        <small style="font-size:13px;">
                                        {{$payment->accounts?$payment->accounts->account_name:NULL}}<br/>
                                        {{$payment->accounts?"(".$payment->accounts->account_no.")":NULL}}
                                        </small>
                                    </td>
                                </tr>
                                @endforeach

                                <tr>
                                	<td colspan="3"></td>
                                	<td>Total</td>
                                	<td>{{ $sales->sum('payment_amount') }}</td>
                                </tr>
                    </tbody>

                </table> 


                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Expenses</h4>
                    <hr>
                    <table style="width: 100%" class="table table-responsive">    
                        <tbody><tr>
                            <th style="font-weight: bold; text-align: center;">SN</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Responsible Person</th>
                            <th>Note</th> 
                        </tr> 
                                                <tr>   
                            <td style="font-weight: bold; text-align: right;">Sum</td>  
                            <td>0.00</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody></table> 

                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Supplier Due Payments</h4>
                    <hr>
                    <table style="width: 100%" class="table table-responsive">    
                        <tbody><tr>
                            <th style="font-weight: bold; text-align: center;">SN</th>
                            <th>Amount</th>
                            <th>Supplier</th> 
                            <th>Note</th> 
                        </tr> 
                                                <tr>   
                            <td style="font-weight: bold; text-align: right;">Sum</td>  
                            <td>&nbsp;0.00</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>                            
                        </tr>
                    </tbody></table> 

                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Customer Due Receives</h4>
                    <hr>
                    <table style="width: 100%" class="table table-responsive">    
                        <tbody><tr>
                            <th style="font-weight: bold; text-align: center;">SN</th>
                            <th>Amount</th>
                            <th>Customer</th> 
                            <th>Note</th> 
                        </tr> 
                                                <tr>   
                            <td style="font-weight: bold; text-align: right;">Sum</td>  
                            <td>&nbsp;0.00</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody></table> 

                    <hr>
                    <h4 style="font-weight: bold; text-align: center; margin-top: 20px;">Damages</h4>
                    <hr>
                    <table style="width: 100%" class="table table-responsive">    
	                    <tbody>
	                      	<tr>
	                            <th style="font-weight: bold; text-align: center;">SN</th>
	                            <th>Reference No</th>
	                            <th>Supplier</th> 
	                            <th>Product</th> 
	                            <th>Amount</th> 
	                         </tr> 
	                        @foreach($damages as $damage)
	                        <tr>   
	                            <td>{{ $loop->iteration }}</td>
	                            <td> </td>
	                            <td>{{ $damage->supplier?$damage->supplier->name:'' }} </td>
	                            <td>{{ $damage->product?$damage->product->name:'' }} </td>
	                            <td>{{ $damage->total_price }} </td>
	                        </tr>
	                        @endforeach
	                        <tr>
	                        	<td colspan="3"></td>
	                        	<td>Total Amount</td>
	                        	<td>{{ $damages->sum('total_price') }}</td>
	                        </tr>
	                    </tbody>
	                </table> 
					
					

              
		            </div> 
		        </div>


		          </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- /Page Body -->
 </div>
 <!-- /Page Content -->

 
 @endsection
