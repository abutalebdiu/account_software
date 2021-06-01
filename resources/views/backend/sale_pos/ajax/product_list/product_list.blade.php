<div class="row">
    <div class="col-sm-2">
        <div class="ies-tab-btn">
            {{--  <a href="#" class="imran-custom-btn" data-filter=".all">All</a>  --}}
            <a href="#" data-id="all"  style="@if($selected_cat_id == 'all') color: #fff;background-color:#337ab7;border-color:#337ab7 @endif" class="productByCategory imran-custom-btn">All</a> 
            @foreach ($categories as $item)
                <a href="#" data-id="{{$item->id}}" style="@if($selected_cat_id == $item->id) color:#fff;background-color:#337ab7;border-color:#337ab7; @endif" class="productByCategory imran-custom-btn">{{$item->name}}</a> {{-- data-filter=".{{$item->name}}"--}}
            @endforeach
        </div>
        <input type="hidden" value="{{$selected_cat_id}}" class="category_selected_value" />
    </div>
    <div class="col-sm-10 product_scroll_div" >
        <div class="ies-tab-content">
            <div class="row mixit-js">
                @foreach ($products as $item)
                <div class="col-sm-4 mix "> {{--{{$item->products->categories?$item->products->categories->name:''}} all--}}
                    <div class="ies-tab-item popupModalWhenWantToCreateCart" data-toggle="modal" data-id="{{$item->id}}" data-target="#popupProductModalWhenCreatingAddToCart">
                        <p class="mt-5">tk {{$item->default_selling_price}}  @if($item->ascode)({{$item->ascode}})@endif</p>
                        <img src="{{asset('public/assets')}}/imran/image_thumb.png" class="img-fluid" alt="image">
                        <h5>
                            {{$item->productName}} - <small style="color:#797575eb;">({{$item->grades?$item->grades->name:NULL}})</small>
                            {{$item->sizes?" (".$item->sizes->name.")":NULL}}
                            {{$item->colors?" (".$item->colors->name.")":NULL}}
                            {{$item->weights?" (".$item->weights->name.")":NULL}}
                        </h5>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="product_pagination">
                {!! $products->links() !!}
            </div>
        </div>   
    </div>
</div>