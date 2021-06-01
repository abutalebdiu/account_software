

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> Transfer Product
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h4>
            </div>
            <form action="{{route('admin.transferStockQuantity')}}" method="POST" id="form">
                @csrf
                <div class="modal-body" id="show-modal-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" value="{{$productName}}" readonly>
                                    <input type="hidden" name="product_id" value="{{$product_id}}">
                                    <input type="hidden" name="product_variation_id" value="{{$product_variation_id}}">
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Purchase Unit</label>
                                    <input type="text" class="form-control"  value="{{$purchaseUnit}}" readonly>
                                    <input type="hidden" name="purchase_unit_id" value="{{$purchaseUnitId}}">
                                </div>
                            </div>
                        
                            <div class="col-sm-6">
                                <h5>From</h5>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="stock_id">Stock Type</label>
                                            <input type="text" value="{{$stockTypeName}}" disabled class="form-control">
                                            <input type="hidden" name="from_stock_type_id" value="{{$stockTypeId}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="stock_id">Stock</label>
                                            <input type="text" value="{{$stockName}}" disabled class="form-control" />
                                            <input type="hidden" name='from_stock_id' value="{{$stockId}}" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="available_stock_quantity">Available Quantity</label>
                                            <input type="text" value="{{$availableQty}}" readonly class="form-control available_stock_quantity" name="available_stock_quantity" >
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-------------------------- transfer to Start------------------------>
                            <div class="col-sm-6">
                                <h5>To</h5>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="stock_id">Stock Type</label>
                                            <select name="to_stock_type_id" class="to_stock_type_id form-control" id="to_stock_type_id">
                                                <option value="">Choose Stock</option>
                                                @foreach($stock_types as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" value="{{$stockId}}" class="from_stock_id" />
                                    <input type="hidden" value="{{$stockTypeId}}" class="from_stock_type_id" />

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="stock_id">Stock</label>
                                            <select name="to_stock_id" class="form-control to_stock_id" >
                                                <option value="">Choose Stock</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="receive_quantity">Transfer Quantity</label> 
                                            <input type="number" min="0" step="any" class="form-control transfer_quantity" name="transfer_quantity">
                                            <span id="text_receive_quantity" class="text-danger"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary submitButton" disabled value="Submit">
                </div>
            </form>
        </div>
    </div>