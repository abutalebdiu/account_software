<div>
    <div>
        <div class="mb-2 text-right my-5">
            <label>
                <strong>Date</strong> {{ $purchase->created_at->format("d M Y") }}
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="mb-2">
                <label>
                    <strong>Invoice No: </strong> {{ $purchase->invoice_no }}
                </label>
            </div>
            <div class="mb-2">
                <label>
                    <strong>Status: </strong> {{ $purchase->status }}
                </label>
            </div>
            <div class="mb-2">
                <label>
                    <strong>Payment Status: </strong> {{ $purchase->status }}
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-2">
                <label>
                    <strong>Supplier Name</strong> {{ $purchase->suppliers->name }}
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-2">
                <label>
                    <strong>Shipping Address</strong> {{ $purchase->shipping->address }}
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
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Price Inc. Tax</th>
                            <th>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase->details as $detail)
                            <tr>
                                <td>{{ $detail->productVariations->products->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ $detail->purchase_unit_price_before_tax }}</td>
                                <td>{{ $detail->discount_amount }}</td>
                                <td>{{ $detail->purchase_unit_price_inc_tax }}</td>
                                <td>Price Inc. Tax</td>
                                <td>SubTotal</td>
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
                            <th>Payment Mode</th>
                            <th>Payment Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Date</td>
                            <td>Reference No</td>
                            <td>Amount</td>
                            <td>Payment Mode</td>
                            <td>Payment Note</td>
                        </tr>
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
                            <td>&#2547; {{ $subtotal }}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Discount</strong>
                            </td>
                            <td>(-)</td>
                            <td>&#2547; {{ $discount }}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Order Tax</strong>
                            </td>
                            <td>(+)</td>
                            <td>&#2547; {{ $tax }}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Shipping</strong>
                            </td>
                            <td></td>
                            <td>&#2547; {{ $shippingAmount }}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Round off</strong>
                            </td>
                            <td></td>
                            <td>&#2547; {{ 0 }}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Total Payable</strong>
                            </td>
                            <td></td>
                            <td>&#2547; {{ $purchaseAmount }}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Total Paid</strong>
                            </td>
                            <td></td>
                            <td>&#2547; {{ $paidAmount }}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Due</strong>
                            </td>
                            <td></td>
                            <td>&#2547; {{ $dueAmount }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>