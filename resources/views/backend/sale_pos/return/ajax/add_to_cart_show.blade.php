@php
    $cartName = session()->has('cartName') ? session()->get('cartName')  : [];
    //$total = array_sum(array_column($cart,'total_price'));
    $i = 1;
    @endphp

    @foreach ($cartName as $key => $item)
    <tr>
        {{--  
            <td>
                {{ $i }}
                <input type="hidden" value="{{ $i }}" class="totalId" />
            </td>  
        --}}
        <td>
            {{$i}} ) 
             <a href="#" class="popupModalWhenWantToEditCart" data-toggle="modal" data-id="{{ $item['productVari_id'] }}" data-target="#showingProductShortDetailForEditingCartByModal"><i class="fa fa-pencil" style="margin-right: 5px; font-size: 18px"></i></a> 
            {{ $item['name'] }}

            <input name="product_id[]" type="hidden" value="{{ $item['productVari_id'] }}" />
            <input  name="sale_type_id[]"  data-id="{{ $item['productVari_id'] }}" value="{{ $item['sale_type_id'] }}"  type="hidden"/>
            <input  name="sale_from_stock_id[]" data-id="{{ $item['productVari_id'] }}" value="{{ $item['sale_from_stock_id'] }}" type="hidden" />
            <input  name="sale_unit_id[]" data-id="{{ $item['productVari_id'] }}" value="{{ $item['sale_unit_id'] }}"  type="hidden"/>
        </td>
        <td>
            <span class="clickToGet" id="price-{{ $item['sale_price'] }}">{{ $item['sale_price'] }}</span>
        </td>
        <td style="width:5%;">
            <input style="width: 70px" type="text" disabled="disabled" value="{{ $item['selling_unit_name'] }}">
        </td>
        <td>
            <span class="quantityChange" data-change_type="minus" data-product_id="{{ $item['productVari_id'] }}" data-quantity="{{ $item['quantity'] }}" style="cursor:pointer">
                <i class="fa fa-minus-circle"></i>
            </span>

                <span id="set-{{ $item['quantity'] }}">{{ $item['quantity'] }}</span>

            <span class="quantityChange" data-change_type="plus" data-product_id="{{ $item['productVari_id'] }}" data-quantity="{{ $item['quantity'] }}" style="cursor:pointer">
                <i class="fa fa-plus-circle"></i>
            </span>
            Pcs 
            <br/>
            <strong id="not_available_message_{{$item['productVari_id']}}" style="font-size:11px; color:red;"></strong>
        </td>
        
        <td>
            <input style="width: 70px" type="text" disabled="disabled" value="{{ $item['discountValue'] }}-{{ $item['discountType'] }}">
        </td>

        <td>
            <span id="set-{{ $item['netTotalAmount'] }}" class="getSubtotalClass cr_getSubtotalClass">{{ $item['netTotalAmount'] }}</span>
        </td>
        <td>
            <a href="#" class="getIdForDelete" data-id="{{ $item['productVari_id'] }}">
                <i class="fa fa-times-circle" style="color: red; margin-left: 10px;  font-size: 18px"></i>
             </a>
        </td>
        {{--  
            <td>
                <a href="#" class="clickForGetId"  data-url="" data-id="{{ $item['productVari_id'] }}">
                    <i class="fas fa-trash"></i>
                    Remove
                </a>
                <span id="set-{{ $item['productVari_id'] }}">{{ $item['total_price'] }}</span>
            </td>  
        --}}
    </tr>
    {{ $i++ }}
    @endforeach
      <input type="hidden" value="{{ $i-1 }}" class="totalId" />