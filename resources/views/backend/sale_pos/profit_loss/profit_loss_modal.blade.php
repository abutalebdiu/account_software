<div class="modal fade payment_modal in" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" style="font-size: calc(100%); display: block;">
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title no-print">
                    View Invoice Report ( Invoice No.: {{$saleFinal->order_no}} )
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
                            <strong>  {{$saleFinal->customers?$saleFinal->customers->name:NULL}}</strong>
                            : {{$saleFinal->customers?$saleFinal->customers->address:NULL}}
                            <br />
                            Mobile: : {{$saleFinal->customers?$saleFinal->customers->phone:NULL}}
                        </address>

                        
                        <address style="font-size:12px;font-weight:bold; color:#732323;background-color:#999999c9;">
                            <span style="padding:2px;padding-top:5px;">Total Invoice : 
                            <strong style="font-size:14px;">
                                {{$saleFinal->totalSaleAmount()}}
                            </strong>
                            </span> <br/>
                            <span style="padding:2px;">Total Purchase : 
                                <strong style="font-size:14px;">
                                {{  number_format($saleFinal->getTotalPurchaseAmountFromSaleDetail() , 2,'.','')}}
                                </strong>
                            </span> <br/>
                            <span style="padding:2px;padding-bottom:5px;">Total Profit/Loss : 
                                <strong style="font-size:14px;">
                                    {{ number_format($saleFinal->totalSaleAmount() - $saleFinal->getTotalPurchaseAmountFromSaleDetail() , 2,'.','')}}
                                </strong>
                            </span>
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
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <th>Sl.No</th>
                                    <th>AS Code</th>
                                    <th>Quantity</th>
                                    <th>Unit <br/>Purchase Price</th>
                                    <th>Total<br/> Purchase Price</th>
                                    <th>Unit<br/> Sale Price</th>
                                    <th>Total<br/> Sale Price</th>
                                    <th>Profit/Loss</th>
                                </thead>
                                <tbody >
                                    @php
                                        $totalQuantity      = 0;
                                        $totalPurchasePrice = 0;
                                        $totalSalePrice     = 0;
                                        $totalProfitLoss    = 0;
                                    @endphp
                                    @foreach ($saleFinal->saleDetails??$saleFinal->saleDetails as $item)
                                        <tr>
                                            <td> {{$loop->iteration}}</td>
                                            <td>
                                                {{$item->productVariations?$item->productVariations->products? $item->productVariations->products->custom_code:NULL:NULL}}
                                            </td>
                                            <td>{{$item->quantity}}</td>
                                            <td>{{$item->purchase_price}}</td>
                                            <td>{{ number_format($item->purchase_price * $item->quantity ,2,'.','')}}</td>
                                            <td>{{$item->unit_price}}</td>
                                            <td>{{$item->sub_total}}</td>
                                            <td>{{  number_format( $item->sub_total - number_format($item->purchase_price * $item->quantity ,2,'.',''),2,'.','') }}</td>
                                            
                                            @php
                                                $totalQuantity      += $item->quantity;
                                                $totalPurchasePrice += number_format($item->purchase_price * $item->quantity ,2,'.','');
                                                $totalSalePrice     += $item->sub_total;
                                                $totalProfitLoss    += number_format( $item->sub_total - number_format($item->purchase_price * $item->quantity ,2,'.',''),2,'.','');
                                            @endphp
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfooter >
                                <tr style="background-color:green;color:white;">
                                    <td colspan="2" style="text-align:right;">Total</td>
                                    <td>{{$totalQuantity}}</td>
                                    <td></td>
                                    <td>{{ number_format($totalPurchasePrice,2,'.','')}}</td>
                                    <td></td>
                                    <td>{{ number_format($totalSalePrice,2,'.','')}}</td>
                                    <td>{{ number_format($totalProfitLoss,2,'.','')}} <small>(Less : {{$saleFinal->discountAmountOfSaleFinal()}})</small> </td>
                                </tr>
                                <tfooter>
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
