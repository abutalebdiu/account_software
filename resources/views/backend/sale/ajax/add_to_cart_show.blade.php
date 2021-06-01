@php
    $cartName = session()->has('cartName') ? session()->get('cartName')  : [];
    //$total = array_sum(array_column($cart,'total_price'));
    $i = 1;
    @endphp

    @foreach ($cartName as $key => $item)
    <tr>
        {{--  <td>
            {{ $i }}
            <input type="hidden" value="{{ $i }}" class="totalId" />
        </td>  --}}
        <td>
        <a href="#" class="showProductShortDeatisByModalEditingCart" data-toggle="modal" data-id="{{ $item['product_id'] }}" data-target="#showingProductShortDetailForEditingCartByModal"><i class="fa fa-pencil" style="margin-right: 5px; font-size: 18px"></i></a>
            <input name="product_id[]" type="hidden" value="{{ $item['product_id'] }}" />
            {{ $item['name'] }}
        </td>
        <td>
            <span class="clickToGet" id="price-{{ $item['sale_price'] }}">{{ $item['sale_price'] }}</span>
        </td>
        <td>
            <span class="quantityChange" data-change_type="minus" data-product_id="{{ $item['product_id'] }}" data-quantity="{{ $item['quantity'] }}" style="cursor:pointer">
                <i class="fa fa-minus-circle"></i>
            </span>

                <span id="set-{{ $item['quantity'] }}">{{ $item['quantity'] }}</span>

            <span class="quantityChange" data-change_type="plus" data-product_id="{{ $item['product_id'] }}" data-quantity="{{ $item['quantity'] }}" style="cursor:pointer">
                <i class="fa fa-plus-circle"></i>
            </span>
            Pcs
        </td>

        <td>
            <input style="width: 70px" type="text" disabled="disabled" value="{{ $item['discountValue'] }}:{{ $item['discountType'] }}" placeholder="Amt or %">
            <input style="width: 70px" type="hidden" value="{{ $item['discountValue'] }}" placeholder="Amt or %">
            {{--  <span id="set-{{ $item['discountValue'] }}">{{ $item['discountValue'] }}</span>  --}}
        </td>

        <td>
            <span id="set-{{ $item['netTotalAmount'] }}" class="getSubtotalClass">{{ $item['netTotalAmount'] }}</span>
        </td>
        <td>
            <a href="#" class="getIdForDelete" data-id="{{ $item['product_id'] }}">
                <i class="fa fa-times-circle" style="color: red; margin-left: 10px;  font-size: 18px"></i>
             </a>
        </td>
        {{--  <td>
            <a href="#" class="clickForGetId"  data-url="" data-id="{{ $item['product_id'] }}">
                <i class="fas fa-trash"></i>
                Remove
            </a>
            <span id="set-{{ $item['product_id'] }}">{{ $item['total_price'] }}</span>
        </td>  --}}
    </tr>
    {{ $i++ }}
    @endforeach
      <input type="hidden" value="{{ $i-1 }}" class="totalId" />