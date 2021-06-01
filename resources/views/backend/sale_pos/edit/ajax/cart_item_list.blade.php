    @php
    $cartName = session()->has('saleEditCart') ? session()->get('saleEditCart')  : [];
    //$total = array_sum(array_column($cart,'total_price'));
    $i = 1;
    @endphp
    @foreach ($cartName as $key => $item)
    <tr class="product_row" data-row_index="0">
        <td>
            {{$i}}
            <input type="hidden" name="product_id[]" value="{{ $item['product_id'] }}" />
            <input type="hidden" name="product_variation_id[]" value="{{ $item['productVari_id'] }}" />
            <input type="hidden" name="unit_price[]" value="{{ $item['sale_price'] }}" />
            <input type="hidden" name="purchase_price[]" value="{{ $item['purchase_price'] }}" />
            <input type="hidden" name="sale_unit_id[]" value="{{ $item['sale_unit_id'] }}" />
            <input type="hidden" name="new_quantity[]" value="{{ $item['quantity'] }}" />
            <input type="hidden" name="sale_from_stock_id[]" value="{{ $item['sale_from_stock_id'] }}" />
            <input type="hidden" name="sale_type_id[]" value="{{ $item['sale_type_id'] }}" />
            <input type="hidden" name="discountType[]" value="{{ $item['discountType'] }}" />
            <input type="hidden" name="discountValue[]" value="{{ $item['discountValue'] }}" />
            <input type="hidden" name="discountAmount[]" value="{{ $item['discountAmount'] }}" />
            <input type="hidden" name="identity_number[]" value="{{ $item['identityNumber'] }}" />
        </td>
        <td>
            <div title="Edit product Unit Price and Tax">
                {{--  <a href="#" class="popupModalWhenWantToEditCart" data-product_var_id="{{ $item['productVari_id'] }}"  data-id="{{ $item['productVari_id'] }}" ><i class="fa fa-pencil" style="margin-right: 5px; font-size: 18px"></i></a>   --}}
                <span class="text-link text-info cursor-pointer" data-toggle="modal" data-target="#row_edit_product_price_modal_0">
                    {{ $item['name'] }} <br />
                    {{--  0334 &nbsp;<i class="fa fa-info-circle"></i> --}}
                </span>
            </div>
        </td>
        <td class="text-center">
            {{$item['selling_unit_name']}}
        </td>
        <td>
            <div class="input-group input-number">
                <span class="input-group-btn">
                    <span type="button" class="btn btn-default btn-flat quantityChange quantity-down" data-change_type="minus" data-quantity="{{$item['quantity']}}"data-product_var_id="{{ $item['productVari_id'] }}">
                        <i class="fa fa-minus text-danger"></i>
                    </span>
                </span>
                <input type="text" readonly class="form-control"value="{{$item['quantity']}}"name="quantity[]" />
                <span class="input-group-btn">
                    <span type="button" class="btn btn-default btn-flat quantityChange quantity-up"  data-change_type="plus" data-quantity="{{$item['quantity']}}"data-product_var_id="{{ $item['productVari_id'] }}">
                        <i class="fa fa-plus text-success"></i>
                    </span>
                </span>
            </div>
            Pc(s)
            <span id="not_available_message_{{$item['productVari_id']}}"style="color:red;font-size:10px;"></span>
        </td>
        <td class="">
            <input type="text" name="unit_price_inc_tax[]" readonly class="form-control pos_unit_price_inc_tax input_number" value="{{$item['sale_price']}}" />
        </td>
        <td class="text-center v-center">
            <input type="hidden" class="form-control pos_line_total" name="sub_total[]" value="{{ number_format($item['sub_total'],2,'.','') }}" />
            <span class="display_currency pos_line_total_text" data-currency_symbol="true">৳
                <span class="cr_getSubtotalClass">{{ $item['sub_total'] }}</span>
            </span>
        </td>
        <td class="text-center">
            <a class="pos_remove_row " data-id="{{ $item['productVari_id'] }}" data-product_var_id="{{ $item['productVari_id'] }}">
                <i class="fa fa-times text-danger " aria-hidden="true" style="cursor: pointer"></i>
            </a>
        </td>
    </tr>
    @php
    $i++;
    @endphp
    @endforeach
    <input type="hidden" class="totalId" value="{{ $i-1 }}" />