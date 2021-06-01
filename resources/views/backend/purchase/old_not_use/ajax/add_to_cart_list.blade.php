  @php
      $productPurchaseCart = session()->has('productPurchaseCart') ? session()->get('productPurchaseCart')  : [];
        $i = 1;
  @endphp
  @foreach ($productPurchaseCart as $key=> $item)
  <tr>
        <td>
            {{$i}} .
            <input type="hidden" name="product_variation_id[]" value="{{$item['product_var_id']}}" />
            <input type="hidden" name="product_id[]" value="{{$item['product_id']}}" />
            <input type="hidden" name="default_purchase_unit_id[]" value="{{$item['default_purchase_unit_id']}}" />
            <input type="hidden" name="default_sale_unit_id[]" value="{{$item['default_sale_unit_id']}}" />
            (<strong>{{$item['default_purchase_unit']}}</strong>)
        </td>
        <td>
            {{$item['product_name']}}
        </td>
        <td>
            <input id="purchase_quantity_id_{{$item['product_var_id']}}" data-id="{{$item['product_var_id']}}"  value="{{$item['purchase_quantity']}}" class="get_current_data_class total_qty_class form-control"  name="purchase_quantity[]" type="text" />
        </td>
        <td style="width:10%;">
            <input id="purchase_unit_price_before_discount_id_{{$item['product_var_id']}}" data-id="{{$item['product_var_id']}}"   class="get_current_data_class form-control" value="{{$item['purchase_unit_price_before_discount']}}"  type="text" name="purchase_unit_price_before_discount[]" />
        </td>
        <td style="width:4%;">
            <input id="discount_value_in_parcent_id_{{$item['product_var_id']}}" data-id="{{$item['product_var_id']}}"   value="{{$item['discount_value_in_parcent']}}"   type="text" class="get_current_data_class form-control" name="discount_value_in_parcent[]" />
        </td>
        <td style="width:10%;">
            <input id="purchase_unit_price_before_tax_id_{{$item['product_var_id']}}" data-id="{{$item['product_var_id']}}"   value="{{$item['purchase_unit_price_before_tax']}}" readonly class="form-control"  name="purchase_unit_price_before_tax[]"  type="text" />
        </td>
        <td style="width:10%;">
            <input id="sub_total_before_tax_id_{{$item['product_var_id']}}"  data-id="{{$item['product_var_id']}}"   value="{{$item['sub_total_before_tax']}}" readonly class="form-control" name="sub_total_before_tax[]" type="text" />
        </td>
        <td style="width:4%;">
            <input id="product_tax_id_{{$item['product_var_id']}}"   data-id="{{$item['product_var_id']}}"   value="{{$item['product_tax']}}" @if($item['applicable_tax_for_purchase'])  @else readonly @endif class="get_current_data_class form-control" name="product_tax[]" type="text" />
        </td>
        <td style="width:10%;">
            <input id="net_cost_id_{{$item['product_var_id']}}" data-id="{{$item['product_var_id']}}"    value="{{$item['net_purchase_amount']}}" class="form-control"   name="purchase_unit_price_inc_tax[]" readonly type="text" />
        </td>
        <td style="width:10%;">
            <input id="line_total_id_{{$item['product_var_id']}}"  data-id="{{$item['product_var_id']}}"   value="{{$item['line_total']}}" class="line_total_class form-control" name="line_total[]" readonly type="text" />
        </td>
        <td style="width:6%;">
            <input id="profit_margin_parcent_id_{{$item['product_var_id']}}"  data-id="{{$item['product_var_id']}}"   value="{{$item['profit_margin_parcent']}}"  class="get_current_data_class form-control" name="profit_margin_parcent[]" type="text"/>
        </td>
        <td style="width:7%;">
            <input id="unit_selling_price_inc_tax_id_{{$item['product_var_id']}}" data-id="{{$item['product_var_id']}}"    value="{{$item['unit_selling_price_inc_tax']}}" class="form-control" readonly name="unit_selling_price_inc_tax[]" type="text" />
        </td>
        <td style="width:3%;">
            <a href="#" data-id="{{$item['product_var_id']}}" class="removePurchaseSingleCart">
                <i class="fa fa-trash" style="color: #333; padding: 1px 8px;border: 2px solid #848484; border-radius: 3px;color:red;"></i>
            </a>
        </td>
    </tr>
    @php $i++ ;@endphp
  @endforeach
