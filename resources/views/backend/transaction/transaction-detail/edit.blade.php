@extends('home')
@section('title','Edit Units')
@section('content')
<!-- Page Content -->
<div class="page-content">
    <!-- Page Breadcrumb -->
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="#">Home</a>
            </li>
            <li class="active">Edit Units</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Header -->
    <div class="page-header position-relative">
        <div class="header-title">
            <h1>
                Dashboard
            </h1>
        </div>
        <!--Header Buttons-->
        <div class="header-buttons">
            <a class="sidebar-toggler" href="javascript:void(0)">
                <i class="fa fa-arrows-h"></i>
            </a>
            <a class="refresh" id="refresh-toggler" href="javascript:void(0)" onclick="location.reload()">
                <i class="glyphicon glyphicon-refresh"></i>
            </a>
            <a class="fullscreen" id="fullscreen-toggler" href="javascript:void(0)">
                <i class="glyphicon glyphicon-fullscreen"></i>
            </a>
        </div>
        <!--Header Buttons End-->
    </div>
    <!-- /Page Header -->
    <!-- Page Body -->
    <div class="page-body">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="widget">
                    <div class="widget-header bg-info">
                        <span class="widget-caption" style="font-size: 20px">Add Transaction Detail</span>
                        <div class="widget-buttons">
                            <a href="javascript:void(0)" data-toggle="maximize">
                                <i class="fa fa-expand"></i>
                            </a>
                            <a href="javascript:void(0)" data-toggle="collapse">
                                <i class="fa fa-minus"></i>
                            </a>
                            <a href="javascript:void(0)" data-toggle="dispose">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <form action="{{route('admin.transaction-detail.update', $transactionFinal)}}" method="post">
                            @csrf
                            @method("PUT")
                            <label class="text-align-center"> <strong>Transaction Final</strong> </label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="transaction_type">Type</label>
                                        <select name="transaction_type_id" id="transaction_type_id"
                                            class="form-control">
                                            <option selected>Choose Type</option>
                                            @foreach ($transactionTypes as $item)
                                            <option
                                                {{$transactionFinal->transaction_type_id == $item->id?'selected':''}}
                                                value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <div style='color:red; padding: 0 5px;'>
                                            {{($errors->has('transaction_type_id'))?($errors->first('transaction_type_id')):''}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="transaction_category_id">Category</label>
                                        <select name="transaction_category_id" id="transaction_category_id"
                                            class="form-control">
                                            <option selected>Choose Category</option>
                                            @foreach ($transactionCategories as $item)
                                            <option
                                                {{$transactionFinal->transaction_category_id == $item->id?'selected':''}}
                                                value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <div style='color:red; padding: 0 5px;'>
                                            {{($errors->has('transaction_category_id'))?($errors->first('transaction_category_id')):''}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="transaction_final_reference">Reference</label>
                                        <input name="transaction_final_reference" type="text"
                                            id="transaction_final_reference" placeholder="Reference No"
                                            class="form-control" value="{{$transactionFinal->reference_no}}">
                                        <div style='color:red; padding: 0 5px;'>
                                            {{($errors->has('transaction_final_reference'))?($errors->first('transaction_final_reference')):''}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="transaction_date">Transaction Date</label>
                                        <input name="transaction_date" type="date" id="transaction_date"
                                            class="form-control"
                                            value="{{date("Y-m-d", strtotime($transactionFinal->transaction_date))}}">
                                        <div style='color:red; padding: 0 5px;'>
                                            {{($errors->has('transaction_date'))?($errors->first('transaction_date')):''}}
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="discount_type">Discount Type</label>
                                        <select name="discount_type" id="discount_type" class="form-control">
                                            <option selected>Choose Type</option>
                                            <option {{$transactionFinal->discount_type == 0 ? 'selected' : ''}}
                                value="0">Percent</option>
                                <option {{$transactionFinal->discount_type == 1 ? 'selected' : ''}} value="1">Fixed
                                </option>
                                </select>
                                <div style='color:red; padding: 0 5px;'>
                                    {{($errors->has('discount_type'))?($errors->first('discount_type')):''}}
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="discount_value">Discount Value</label>
                            <input name="discount_value" type="number" value="{{$transactionFinal->discount_value}}"
                                id="discount_value" placeholder="00.00" class="form-control" min="0" step=".01">
                            <div style='color:red; padding: 0 5px;'>
                                {{($errors->has('discount_value'))?($errors->first('discount_value')):''}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="discount_amount">Discount Amount</label>
                            <input name="discount_amount" type="number" value="{{$transactionFinal->discount_amount}}"
                                id="discount_amount" placeholder="00.00" class="form-control" min="0" step=".01">
                            <div style='color:red; padding: 0 5px;'>
                                {{($errors->has('discount_amount'))?($errors->first('discount_amount')):''}}
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="transaction_note">Transaction Note</label>
                            <input name="transaction_note" type="text" value="{{$transactionFinal->transaction_note}}"
                                id="transaction_note" placeholder="" class="form-control">
                            <div style='color:red; padding: 0 5px;'>
                                {{($errors->has('transaction_note'))?($errors->first('transaction_note')):''}}
                            </div>
                        </div>
                    </div>
                    <div style="padding: 1.5rem">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Transaction Date</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Sub Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-transaction">
                                @foreach ($transactionFinal->transactionDetails as $item)
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input name="transaction_created_date[]" type="date" placeholder=""
                                                class="form-control"
                                                value="{{date("Y-m-d", strtotime($item->transaction_created_date))}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input name="transaction_title[]" type="text" placeholder=""
                                                class="form-control" value="{{$item->transaction_title}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input name="description[]" type="text" placeholder="" class="form-control"
                                                value="{{$item->description}}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input name="sub_total[]" type="text" placeholder="" class="form-control"
                                                value="{{$item->sub_total}}">
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-success add-row" type="button" onclick="addRow()">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn btn-danger delete-row" type="button"
                                            onclick="deleteRow(this)">
                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr>
                                    <th>Transaction Date</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Sub Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="col-sm-6 float-right">
                        <div class="form-group float-right">
                            <input class="btn btn-primary" type="submit" value="Submit">
                            <a href="{{route('admin.transaction-detail.index')}}" class="btn btn-info">Back</a>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /Page Body -->
</div>
<!-- /Page Content -->
@endsection

@push('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        $("#transaction_type_id").on("change", () => {
            $.ajax({
                url: '{{url("admin/transaction-detail/transaction-categories")}}' + "/" + $("#transaction_type_id").val(),
                type: 'GET',
                success: function(response){
                    $("#transaction_category_id").empty();
                    $("#transaction_category_id").append(
                        `
                            <option sselected>Choose Category</option>
                        `
                    );
                    response.forEach(item => {
                        $("#transaction_category_id").append(
                            `
                                <option value="${item.id}">${item.name}</option>
                            `
                        );
                    });
                },
            });
        })
    });
    function addRow(){
        $("#tbody-transaction").append(`
            <tr>
                <td>
                    <div class="form-group">
                        <input name="transaction_created_date[]" type="date" placeholder="" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input name="transaction_title[]" type="text" placeholder="" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input name="description[]" type="text" placeholder="" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <input name="sub_total[]" type="text"  placeholder="" class="form-control">
                    </div>
                </td>
                <td>
                    <button class="btn btn-success add-row" type="button" onclick="addRow()">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-danger delete-row" type="button" onclick="deleteRow(this)">
                        <i class="fa fa-minus" aria-hidden="true"></i>
                    </button>
                </td>
            </tr>
        `);
    }
    function deleteRow(e){
        e.parentNode.parentNode.remove();
    }
</script>
@endpush