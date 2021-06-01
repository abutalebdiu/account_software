<div class="modal fade payment_modal in" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="font-size: calc(100%); display: block;">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title no-print">
                    View Payments ( Invoice No.: {{$saleFinal->order_no}} ) 
                </h4>
                <h4 class="modal-title visible-print-block">
                    Invoice No.: {{$saleFinal->order_no}}
                </h4>
            </div>
            <div class="modal-body">
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        Customer:
                        <address>
                            <strong> : {{$saleFinal->customers?$saleFinal->customers->name:NULL}}</strong>
                            : {{$saleFinal->customers?$saleFinal->customers->address:NULL}}
                            <br />
                            Mobile: : {{$saleFinal->customers?$saleFinal->customers->phone:NULL}}
                        </address>
                        
                       
                    </div>
                    <div class="col-md-4 invoice-col">
                        Business:
                        <address>
                            <strong>Amader Sanitary</strong>
                           
                            <br />
                            Janata Bank More, (Hafez Building Under Graound) Mujib Sarak, Niltuli,Faridpur <br />
                            .,.,. <br />
                            Mobile: +8801711111192  , +8801613000450<br />
                            {{--  Email: kamrulislam643@gmail.com  --}}
                        </address>
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>Invoice No.:</b> #{{$saleFinal->order_no}}
                        <br />
                        <b>Date:</b> {{date('d-m-Y h:i:s a',strtotime($saleFinal->sale_date))}}<br />

                         
                            <b> Invoice Amount :</b> {{$saleFinal->totalSaleAmount()}}<br/>
                            <b> Paid Amount : </b> {{$saleFinal->totalPaidAmount()}} <br/>
                           <b>  Due Amount : </b>{{$saleFinal->totalDueAmount()}}  <br/>
                       

                        <b>Payment Status:</b> 
                            @if($saleFinal->totalPaidAmount() > 0)
                                <span>
                                    @if($saleFinal->totalSaleAmount() == $saleFinal->totalPaidAmount())
                                        <span class="badge badge-primary"> Paid </span>
                                    
                                    @elseif($saleFinal->totalSaleAmount() > 0 && $saleFinal->totalSaleAmount()  < $saleFinal->totalPaidAmount())
                                            <small class="badge badge-warning"> Over</small><span class="badge badge-primary"> Paid </span>
                                    
                                    @elseif($saleFinal->totalSaleAmount() > 0 && $saleFinal->totalSaleAmount()  > $saleFinal->totalPaidAmount())
                                        <span class="badge badge-danger">Due</span>
                                    
                                    @elseif($saleFinal->totalSaleAmount() < 0)
                                        <span class="badge badge-defalut" style="backgrounc-color:#06061f;color:red;">Invalid </span>
                                    @endif
                                    </span>
                                @else
                                    <span class="badge badge-danger">Due</span>
                            @endif
                        <br />
                    </div>
                </div>
                <div class="row no-print">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-info btn-modal btn-xs" data-href="" data-container="">
                            <i class="fa fa-envelope"></i> Send Payment Received Notification
                        </button>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>Date</th>
                                    <th>Reference No</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Payment Account</th>
                                    <th>Payment Note</th>
                                     <th>Credit/Debit</th>
                                    <th class="no-print">Actions</th>
                                </thead>
                                <tbody >
                                    @foreach($saleFinal->payments??NULL as $payment)
                                    <tr>
                                        <td style="font-size:11px">
                                            {{date('d-m-Y',strtotime($payment->payment_date))}}
                                        </td>
                                        <td style="font-size:12px">
                                            {{$payment->payment_reference_no}}
                                        </td>
                                        <td style="font-size:12px">
                                            {{number_format($payment->payment_amount,2,'.','')}}
                                        </td>
                                        <td style="font-size:12px">
                                            {{--  {{getCDFName_HH($payment->cdf_type_id)}}  --}}
                                            {{$payment->paymentMethods?$payment->paymentMethods->method:NULL}}
                                            <small>{{$payment->accounts?$payment->accounts->bank? "(".$payment->accounts->bank->short_name .")":NULL:NULL}}</small>
                                        </td>
                                        <td style="font-size:12px">
                                            {{$payment->accounts?$payment->accounts->account_no:NULL}}<br/>
                                            <small>{{$payment->accounts?"(".$payment->accounts->account_name.")":NULL}}</small>
                                        </td>
                                        <td style="font-size:12px">
                                            <small style="font-size:11px;">
                                            {{ $payment->paymentNotes?$payment->paymentNotes->payment_note:"--" }}
                                            </small>
                                        </td>
                                        <td style="font-size:11px">
                                            {{getCDFName_HH($payment->cdf_type_id)}}
                                        </td>
                                        <td class="no-print" style="display: flex;font-size:11px;">
                                            {{--  <a  href="#" data-id="{{$payment->id}}" data-sale_final_id="{{$saleFinal->id}}" data-payment_invoice_no="{{$payment->payment_reference_no}}" class="btn btn-info btn-xs edit_payment" data-href=""><i class="glyphicon glyphicon-edit"></i></a>
                                                &nbsp;   --}}
                                            <a href="#" data-id="{{$payment->id}}" data-sale_final_id="{{$saleFinal->id}}" data-payment_invoice_no="{{$payment->payment_reference_no}}" class="btn btn-danger btn-xs delete_payment" data-href=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                &nbsp;
                                            {{--  <a  href="#" data-id="{{$payment->id}}" data-sale_final_id="{{$saleFinal->id}}" data-payment_invoice_no="{{$payment->payment_reference_no}}" class="btn btn-primary btn-xs view_payment" data-href="">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>  --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{--  <button type="button" class="btn btn-primary no-print" aria-label="Print" onclick="$(this).closest('div.modal').printThis();"><i class="fa fa-print"></i> Print</button>  --}}
                <button type="button" class="btn btn-default no-print" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
