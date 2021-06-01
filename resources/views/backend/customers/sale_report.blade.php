@extends('home')
@section('title', 'customers Sale Report')
@push('css')
     <style>
        input[type=checkbox], input[type=radio]
        {
            opacity: inherit;
            position: inherit;
            left: -9999px;
            z-index: 12;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled {
            cursor: pointer;
            position: unset;
        }
     </style>
 @endpush
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
                <li class="active">customers Sale Report</li>
            </ul>
        </div>
        <!-- /Page Breadcrumb -->
      
        <!-- Page Body -->
        <div class="page-body">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="widget">
                        <div class="widget-header bg-info">
                            <span class="widget-caption" style="font-size: 20px">Customers Sale Report</span>
                          
                        </div>
                        <div class="widget-body" style="background-color: #fff;">

                            <form action="{{ route('customerSaleReportexport') }}" method="get">  
                                <div class="row" style="margin: 30px 0;margin-top:0px;">
                                    <div class="col-md-6">
                                        <div class="table-toolbar text-right">
                                            <button class="btn btn-primary pull-left" name="pdf"> <i class="fa fa-download"></i> PDF</button>
                                        </div>
                                    </div>
                                </div>

                                <table id="example1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th >
                                                <input type="checkbox" value="all" name="check_all" class="check_all_class"/>
                                            </th>
                                            <th>SN</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>
                                                Email
                                            </th>
                                            <th>Total Order</th>
                                            <th>Total Order <br />Amount</th>
                                            <th>Total Paid <br />Amount</th>
                                            <th>Total Due <br />Amount</th>
                                            <th>Total Discount <br />Amount</th>
                                            <th>Total Item</th>
                                        </tr>
                                    </thead>
                                    @php
                                        $totalOrder = 0;
                                        $totalOrderAmount = 0;
                                        $totalOrderPaidAmount = 0;
                                        $totalOrderDueAmount = 0;
                                        $totalOrderDiscountAmount = 0;
                                        $totalOrderItem = 0;
                                    @endphp
                                    <tbody>
                                        @foreach ($customers as $customer)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="customerid[]" value="{{ $customer->id }}" class="check_single_class" id="{{$customer->id}}"/>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->phone }} <br> {{ $customer->phone_2 }} </td>
                                            <td>{{ $customer->email }}</td>
                                            <td>
                                                @php
                                                $discountAmount = number_format($customer->totalSaleFinals->sum('discount_amount'),2,'.','');
                                                $otherCost      = number_format($customer->totalSaleFinals->sum('others_cost'),2,'.','');
                                                $shippingAmount = number_format($customer->totalSaleFinals->sum('shipping_cost'),2,'.','');

                                                $subTotal       = number_format($customer->totalSaleDetails->sum('sub_total'),2,'.','' );
                                                
                                                $totalAmount    = number_format(($subTotal - $discountAmount) + $otherCost + $shippingAmount,2,'.','');
                                                $subDiscount    = number_format($customer->totalSaleDetails->sum('discount_amount'),2,'.','');
                                                $totalDiscount  = number_format($subDiscount + $discountAmount,2,'.','');

                                                $totalPaidAmount = number_format($customer->paymentAmount(),2,'.','');
                                                $totalDueAmount  = number_format($totalAmount - $totalPaidAmount,2,'.',''); 

                                                $totalInvoice   = $customer->totalSaleFinals->count();
                                                $totalItemCount = $customer->totalSaleDetails->count();

                                                $totalOrder += $totalInvoice ;
                                                $totalOrderAmount += $totalAmount;
                                                $totalOrderPaidAmount += $totalPaidAmount;
                                                $totalOrderDueAmount += $totalDueAmount;
                                                $totalOrderDiscountAmount += $totalDiscount;
                                                $totalOrderItem += $totalItemCount;
                                            @endphp
                                                {{ $totalInvoice }}
                                            </td>
                                            <td> {{ $totalAmount }}</td>
                                            <td> {{ $totalPaidAmount }}</td>
                                            <td> {{ $totalDueAmount }}</td>
                                            <td> {{ $totalDiscount }}</td>
                                            <td> {{ $totalItemCount }}</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfooter>
                                        <tr>
                                            <th colspan="5" style="text-align:right">Total</th>
                                            <th>
                                                {{ $totalOrder }}
                                            </th>
                                            <th>{{ $totalOrderAmount }}</th>
                                            <th>{{ $totalOrderPaidAmount }}</th>
                                            <th>{{ $totalOrderDueAmount }}</th>
                                            <th>{{ $totalOrderDiscountAmount }}</th>
                                            <th>{{ $totalOrderItem }}</th>
                                        </tr>
                                    </tfooter>
                                </table>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Body -->
    </div>
    <!-- /Page Content -->

     @push('js')
     <script>
        //check_all_class
        //check_single_class
        $(document).on('click','.check_all_class',function(){
            if (this.checked == false)
            {
                //28.03.2021
                $('.bulk_assigning_partner').hide();
                //28.03.2021

                $('.check_single_class').prop('checked', false).change();
                $(".check_single_class").each(function ()
                {
                    var id = $(this).attr('id');
                    $(this).val('').change();

                });
            }else{
                 //28.03.2021
                $('.bulk_assigning_partner').show();
                //28.03.2021

                $('.check_single_class').prop("checked", true).change();

                $(".check_single_class").each(function ()
                {
                    var id = $(this).attr('id');
                    $(this).val(id).change();
                });
            }
        });
            //=======================
        $(document).on('click','.check_single_class',function(){
             //28.03.2021
            var $b = $('input[type=checkbox]');
            if($b.filter(':checked').length <= 0)
            {
                $('.bulk_assigning_partner').hide();
            }
            //28.03.2021

            var id = $(this).attr('id');
            if (this.checked == false)
            {
                $(this).prop('checked', false).change();
                $(this).val('').change();
            }else{
                  //28.03.2021
                $('.bulk_assigning_partner').show();
                //28.03.2021
                $(this).prop("checked", true).change();
                $(this).val(id).change();
            }
            //=======================
        });


      {{--    $(document).on('click', '#multiple-qr, #multiple-challan', function ()
        {
            var ids = [];
            $('input.check_single_class[type=checkbox]').each(function () {
                if(this.checked){
                    var v = $(this).val();
                    ids.push(v);
                }
            });

            var url = $(this).attr("id") == "multiple-qr" ? "route" : "route";

            $.ajax({
                url: url,
                data: {ids: ids, "_token": "{{ csrf_token() }}",},
                type: "POST",
                success: function(response){
                    // console.log(response);
                    $.print(response);
                },
            });
        });  --}}


        //28.03.2021
        {{--  $(document).on('click','.bulk_assigning_partner',function(){
            $('#bulk_assign_order_modal').modal('show');
            var getRoute  = $('.bulk_assign_route').val();
            $('#bulk_assign_order_action').attr('action',getRoute);
        });
        $(document).on('change','.bulk_partner_id_class',function(){
            $('.submitButton').attr('disabled','disabled');
            var partnerId = $(this).val();
            if(partnerId)
            {
                $('.submitButton').removeAttr('disabled','disabled');
            }else{
                $('.submitButton').attr('disabled','disabled');
            }
        })

        $(document).on("submit",'#bulk_assign_order_action',function(e){
		e.preventDefault();
            var form = $(this);
            var url = form.attr("action");
            var type = form.attr("method");

            var ids = [];
                $('input.check_single_class[type=checkbox]').each(function () {
                    if(this.checked){
                        var v = $(this).val();
                        ids.push(v);
                    }
                });
            $('.bulk_order_id').val(ids);
            var data = form.serialize();
                //ajax start	
                    $.ajax({
                    url: url,
                    data: data,
                    type: type,
                    datatype:"JSON",
                    beforeSend:function(){
                        $('.loading').fadeIn();
                    },
                    success: function(data){
                            if(data.delivery_status == 'success')
                            {
                                $('#bulk_assign_order_modal').modal("hide");
                                $('.check_all_class').prop('checked', false).change();
                                $('.check_single_class').prop('checked', false).change();
                                //swal("Great","Successfully Add Information","success");
                                form[0].reset();
                                    $('#msg').css({
                                        'color':'green',
                                        'height':'30px',
                                        'width':'100%'
                                    });
                                    $('#msg').html("data inserted successfully").fadeIn('slow') //also show a success message 
                                    $('#msg').delay(5000).fadeOut('slow');

                                location.reload();
                            }else{
                                 $('#msg').css({
                                        'color':'red',
                                        'height':'30px',
                                        'width':'100%'
                                });
                                $('#msg').html("data not inserted ").fadeIn('slow') //also show a success message 
                                $('#msg').delay(5000).fadeOut('slow');
                            }
                        },
                    complete:function(){
                        $('.loading').fadeOut();
                    },
                });
                //end ajax
            });
            // end submit optional details works
        //28.03.2021  --}}




     </script>
    @endpush

@endsection
