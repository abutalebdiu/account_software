<!---- purchase show content -->
<div>
    <div>
        <div class="mb-2 text-right my-5">
            <label>
                <strong>Date</strong>{{ date('d-m-Y h:i:s a') }} {{--  {{ $purchase->created_at->format("d M Y") }}  --}}
            </label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-2">
                <label>
                    <strong>Invoice No: </strong> <strong>{{ $purchase->invoice_no }}</strong>
                </label>
            </div>
            {{--  <div class="mb-2">
                <label>
                    <strong>Status: </strong> {{ $purchase->status }}
                </label>
            </div>  --}}
            <div class="mb-2">
                <label>
                    <strong>Payment Status: </strong> 
                    @if($purchase->totalPurchaseAmount() <= $purchase->totalPaidAmount())
                            <span>
                                @if($purchase->totalPurchaseAmount() < $purchase->totalPaidAmount())
                                <small class="badge badge-warning"> Over</small><span class="badge badge-primary"> Paid </span>
                                    @else
                                    <span class="badge badge-primary"> Paid </span>
                                @endif
                            </span>
                        @else
                        <span class="badge badge-danger">Un-paid</span>
                    @endif
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-2">
                <label>
                    <strong>Supplier Name : </strong> 
                    <strong>
                        {{ $purchase->suppliers->name }}
                    </strong>
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-2">
                <label>
                    <strong>Shipping Address : </strong> {{ $purchase->shipping->address }}
                </label>
            </div>
        </div>
    </div>

    {{-- Start of Products --}}
    <div class="row">
        <div class="col-md-12">
            <h4>Products: </h4>
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="width:10%;">Quantity</th>
                            <th style="width:10%;">Unit Price</th>
                            <th style="width:10%;">Discount</th>
                            <th style="width:10%;">Tax</th>
                            <th style="width:10%;">Price Inc. Tax</th>
                            <th style="width:10%;">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase->details as $item)
                            <tr>
                                <td>
                                    {{$item->productVariations?$item->productVariations->products?$item->productVariations->products->name:NULL:NULL}}
                                    {{$item->productVariations?$item->productVariations->colors? "(".$item->productVariations->colors->name .")":NULL:NULL}}
                                    {{$item->productVariations?$item->productVariations->sizes? "(". $item->productVariations->sizes->name .")":NULL:NULL}}
                                    {{$item->productVariations?$item->productVariations->weights? "(". $item->productVariations->weights->name .")" :NULL:NULL}}
                                </td>
                                <td style="width:10%;">
                                    {{ $item->quantity }}
                                    <small>{{ $item->defaultPurchaseUnits?$item->defaultPurchaseUnits->short_name:NULL }}</small>
                                </td>
                                <td style="width:10%;">{{ number_format($item->purchase_unit_price_before_discount,2,'.','') }}</td>
                                <td style="width:10%;">{{ number_format($item->discount_amount,2,'.','') }}</td>
                                <td style="width:10%;">{{ number_format($item->product_tax,2,'.','') }}</td>
                                <td style="width:10%;">{{ number_format($item->purchase_unit_price_inc_tax,2,'.','') }}</td>
                                <td style="width:10%;">
                                    {{ number_format($item->purchase_sub_total_inc_tax_amount,2,'.','') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Start of Payment Info --}}
    <div class="row">
        <div class="col-md-12">
            <h4>Payment Info: </h4>
        </div>
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
                        @foreach($purchase->payments??NULL as $payment)
                        <tr>
                            <td>{{date('d-m-Y',strtotime($payment->payment_date))}}</td>
                            <td>{{$payment->payment_reference_no}}</td>
                            <td>{{number_format($payment->payment_amount,2,'.','')}}</td>
                            <td>
                                {{getCDFName_HH($payment->cdf_type_id)}}
                            </td>
                            <td>{{$payment->paymentMethods?$payment->paymentMethods->method:NULL}}</td>
                            <td>
                               {{ $payment->paymentNotes?$payment->paymentNotes->payment_note:"--" }}
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
                            <td>
                                <strong>SubTotal</strong>
                            </td>
                            <td></td>
                            <td>&#2547; 
                            {{ number_format($subtotal,2,'.','') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Discount</strong>
                            </td>
                            <td>(-)</td>
                            <td>&#2547; 
                            {{ number_format($discount,2,'.','') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Order Tax</strong>
                            </td>
                            <td>(+)</td>
                            <td>&#2547; 
                                {{ number_format($tax,2,'.','') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Shipping</strong>
                            </td>
                            <td></td>
                            <td>&#2547; 
                                {{ number_format($shippingAmount,2,'.','') }}
                            </td>
                        </tr>
                        {{--  <tr>
                            <td>
                                <strong>Round off</strong>
                            </td>
                            <td></td>
                            <td>&#2547; {{ 0 }}</td>
                        </tr>  --}}
                        <tr>
                            <td>
                                <strong>Total Payable</strong>
                            </td>
                            <td></td>
                            <td>&#2547; 
                            {{ number_format($purchaseAmount,2,'.','') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Total Paid</strong>
                            </td>
                            <td></td>
                            <td>&#2547; 
                                {{ number_format($paidAmount,2,'.','') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Due</strong>
                            </td>
                            <td></td>
                            <td>&#2547; 
                                {{ number_format($dueAmount,2,'.','') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!---- purchase show content -->
