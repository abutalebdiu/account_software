<style>
    .modal-full {
            min-width: 90%;
            margin: 0;
            margin-left:5%;
        }

        .modal-full .modal-content {
            min-height: 100vh;
        }
</style>
<div class="modal-dialog modal-lg modal-full" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">
                <strong style="mergin-right:20px;">Sell Details (Quotation No.: {{ $saleFinal->quotationInvoices ? $saleFinal->quotationInvoices->quotation_no:NULL}})</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </h4>
        </div>
                  
        <div class="modal-body">


                    <div>
                        <div>
                            <div class="mb-2 text-right my-5">
                                <label>
                                    <strong>Date : </strong>  <span style="font-size:14px;"> {{date('d-m-Y h:i:s a',strtotime($saleFinal->sale_date))}}</span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label>
                                        <strong>Quotation No: </strong> <span style="font-size:14px;">
                                        {{$saleFinal->quotationInvoices ? $saleFinal->quotationInvoices->quotation_no:NULL}} 
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <label>
                                        <strong>Customer Name : </strong> <span style="font-size:14px;"> 
                                        {{$saleFinal->quotationInvoices ? $saleFinal->quotationInvoices->customer_name:NULL}}
                                        </span>
                                    </label>
                                </div>
                                <div class="mb-2">
                                    <label>
                                        <strong>Customer Phone : </strong> <span style="font-size:14px;"> 
                                            {{$saleFinal->quotationInvoices ? $saleFinal->quotationInvoices->phone:NULL}}
                                        </span>
                                    </label>
                                </div>
                            </div>
                            
                        </div>

                        <br/>
                        <!-----Start of Products--->
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Products: </h4>
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>AS Code</th>
                                                <th style="width:40%;">Product</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Less Amount</th>
                                                <th>Tax</th>
                                                <th>Price Inc. Tax</th>
                                                <th>SubTotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($saleFinal->quotationSaleDetails ? $saleFinal->quotationSaleDetails:NULL  as $item)    
                                            <tr>
                                                <td> {{$item->productVariations?$item->productVariations->products? $item->productVariations->products->custom_code:NULL:NULL}}</td>
                                                <td>
                                                    {{$item->productVariations?$item->productVariations->products? $item->productVariations->products->name:NULL:NULL}}
                                                    {{$item->productVariations?$item->productVariations->colors? "(". $item->productVariations->colors->name .")":NULL:NULL}}
                                                    {{$item->productVariations?$item->productVariations->sizes? "(". $item->productVariations->sizes->name .")":NULL:NULL}}
                                                    {{$item->productVariations?$item->productVariations->weights? "(". $item->productVariations->weights->name .")":NULL:NULL}}
                                                </td>
                                                <td>
                                                    {{$item->quantity}} <small>{{ $item->units?$item->units->short_name:NULL }}</small>
                                                </td>
                                                <td>
                                                    {{$item->unit_price}}
                                                </td>
                                                <td>
                                                    {{$item->quotationDiscountAmounts()}}
                                                </td>
                                                <td>0.0</td>
                                                <td>
                                                  {{$item->unit_price}}
                                                </td>
                                                <td>
                                                    {{$item->quotationSubTotalAmount()}}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-----End of Products--->

                            <br/><br/>

                        <!------Start of Payment Info --->
                        <div class="row">
                            <div class="col-md-12"> <h4>Payment Info: </h4> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Reference No</th>
                                                <th>Amount</th>
                                                <th>Credit/Debit</th>
                                                <th>Payment Method</th>
                                                <th>Payment Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($saleFinal->payments??NULL as $payment)
                                            <tr>
                                                <td>{{date('d-m-Y',strtotime($payment->payment_date))}}</td>
                                                <td>{{$payment->payment_reference_no}}</td>
                                                <td>{{number_format($payment->payment_amount,2,'.','')}}</td>
                                                 <td>
                                                    {{getCDFName_HH($payment->cdf_type_id)}}
                                                </td>
                                                <td>{{$payment->paymentMethods?$payment->paymentMethods->method:NULL}}</td>
                                                <td>
                                                    <small style="font-size:11px;">
                                                    {{ $payment->paymentNotes?$payment->paymentNotes->payment_note:"--" }}
                                                    </small>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped table-hover">
                                        <tbody>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Sub Total</strong>
                                                </td>
                                                <td></td>
                                                <td style="text-align:center;">
                                                    <span style="font-size:14px;"> {{$saleFinal->quotationSubTotalSaleAmount()}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                 <td colspan="2">
                                                    <strong>Less Amount</strong>
                                                </td>
                                                <td>(-)</td>
                                                <td style="text-align:center;">
                                                    <span style="font-size:14px;"> {{$saleFinal->quotationDiscountAmountOfSaleFinal()}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                 <td colspan="2">
                                                    <strong>Order Tax</strong>
                                                </td>
                                                <td>(+)</td>
                                                <td style="text-align:center;">
                                                    {{ $saleFinal->quotationTaxAmounts() }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Shipping</strong>
                                                </td>
                                                <td></td>
                                                <td style="text-align:center;">
                                                    <span style="font-size:14px;"> {{$saleFinal->quotationAdditionalShippingCharges()}}</span>
                                                </td>
                                            </tr>
                                            {{--  <tr>
                                                <td>
                                                    <strong>Round off</strong>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>  --}}
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Total Payable</strong>
                                                </td>
                                                <td></td>
                                                <td style="text-align:center;">
                                                    {{$saleFinal->quotationTotalSaleAmount()}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <strong>Total Paid</strong>
                                                </td>
                                                <td></td>
                                                <td style="text-align:center;">
                                                    {{$saleFinal->quotationTotalPaidAmount()}}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!------Start of Payment Info --->

                    </div>

                       
        </div>
        <div class="modal-footer">
            <a href="#" data-id="{{$saleFinal->id}}" class="printInvoiceClass btn btn-primary">Print</a>
            <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
</div>
