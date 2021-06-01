@php
    $receiveProductPurchaseCart = session()->has('receiveProductPurchaseCart') ? session()->get('receiveProductPurchaseCart')  : [];
    $i = 1;
@endphp
@foreach ($receiveProductPurchaseCart as $key=> $item)
    <tr>
        <td>
            {{$i}}
           <input type="hidden" name="product_variation_id[]" value=" {{$item['product_var_id']}} " />
           <input type="hidden" name="product_id[]" value=" {{$item['product_id']}} " />
        </td>
        <td>{{$item['product_name']}}</td>
        <td>
            {{$item['default_purchase_unit']}}
        </td>
        <td style="width:10%;">
            <input id="get_total_order_qty_id_{{$item['product_var_id']}}" name="purchase_quantity[]"  class="total_order_qty_class  form-control" value="{{$item['purchase_quantity']}}" readonly type="text"  />
        </td>
        <td style="width:10%;">
            <input id="get_total_received_qty_id_{{$item['product_var_id']}}" name="before_total_received_quantity[]" class="total_order_received_before_qty_class form-control"    value="{{$item['total_received_qty']}}"  readonly type="text"/>
        </td>
        <td style="width:8% !important;">
            <input id="receiving_qty_id_{{$item['product_var_id']}}" data-product_variation_id="{{$item['product_var_id']}}"  class="receiving_qty_id_class total_receiving_qty_class form-control"  value="{{$item['receiving_qty']}}" name="receiving_quantity[]" @if($item['purchase_quantity'] <= $item['total_received_qty']) readonly @else  @endif type="text" style="color:green;font-size:15px;"  />
        </td>
        <td style="width:10%;">
            <input id="set_due_qty_id_{{$item['product_var_id']}}"  class="total_current_due_qty_class form-control"  name="due_qty[]" value="{{$item['total_due_qty']}}" readonly type="text" style="color:red;font-size:15px;" />
        </td>
        <td style="width:8%;">
                @if($item['purchase_quantity'] <= $item['total_received_qty'] )
                    <span class="badge badge-primary">Received</span>
                    @else
                    <span class="badge badge-danger">Due<span>
                @endif
        </td>
        <td style="width:3%;">
            <a href="#" class="removeReceivePurchaseProductSingleCart" data-id="{{$item['product_var_id']}}" >
                <i class="fa fa-trash" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;color:red;"></i>
            </a>
        </td>
    </tr>
    @php
        $i++;
    @endphp
@endforeach
