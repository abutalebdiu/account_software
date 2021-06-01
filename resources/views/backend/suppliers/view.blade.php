 @extends('home')
 @section('title','Supplier')
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
             <li class="active">Supplier</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
     
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px"> Supplier</span>
                         
                     </div>
                     <div class="widget-body" style="background-color: #fff;">
                          <form action="{{ route('supplierListExport') }}" method="get">
                            <div class="table-toolbar text-right">
                                <button class="btn btn-primary pull-left" name="pdf"> <i class="fa fa-download"></i> PDF</button>
                               <a href="{{route('supplier.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Supplier</a>
                            </div>




                         <table id="example1" class="table table-bordered table-striped table-hover">
                             <thead>
                                 <tr>
                                    <th >
                                        <input type="checkbox" value="all" name="check_all" class="check_all_class"/>
                                    </th>
                                      <th>Action</th>
                                     <th style="width:3%">SN</th>
                                     <th style="width:3%">S.ID</th>
                                     <th>Supplier Name</th>
                                     <th>Contact Person</th>
                                     <th>Supplier Email</th>
                                     <th>Supplier Mobile</th>
                                     <th>AS Code Serial </th>
                                   
                                 </tr>
                             </thead>
                             <tbody>
                             	@foreach($suppliers as $supplier)

                             	<tr>
                                    <td>
                                        <input type="checkbox" name="supplier_id[]" value="{{ $supplier->id }}" class="check_single_class" id="{{$supplier->id}}"/>
                                    </td>
                                    <td>
                                          
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-left" role="menu"> 
                                               <li>
                                                    <a href="{{ route('supplier.show',$supplier->id) }}"><i class="fa fa-eye tiny-icon"></i> Show</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('supplier.demand.order',$supplier->id) }}"><i class="fa fa-shopping-cart tiny-icon"></i> Supplier Product Order</a>
                                                </li>
                                                
                                                <li>
                                                    <a href="{{ route('admin.purchase.create') }}?supplier_id={{$supplier->id}}"><i class="fa fa-shopping-cart tiny-icon"></i> All Product Order</a>
                                                </li>
                                               
                                                <li>
                                                    <a href="{{ route('supplier.damage',$supplier->id) }}"> <i class="fa fa-ban tiny-icon"></i>
                                                        <span class="menu-text">Damage</span>
                                                    </a>
                                                </li>
                                             
                                                
                                                <li>
                                                    <a href="{{route('supplier.paymenthistory',$supplier->id)}}"><i class="fa fa-money tiny-icon"></i>
                                                        <span class="menu-text">Payment Histroy</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('supplier.edit',$supplier->id) }}"><i class="fa fa-pencil tiny-icon"></i> Supplier Edit</a>
                                                </li>
                                                
                                                <li>
                                                    <a href="{{ route('product.multiple.create',$supplier->id) }}"><i class="fa fa-plus tiny-icon"></i> Add Product</a>
                                                </li> 

                                                
                                                <li>
                                                    <a href="{{ route('product.supplier',$supplier->id) }}"><i class="fa fa-pencil tiny-icon"></i> Product Edit</a>
                                                </li>
                                                
                                               
                                              
                                               <li>
                                                    <a class="delete" href="{{ route('supplier.destroy',$supplier->id) }}"><i class="fa fa-trash tiny-icon"></i> Delete</a>
                                                </li> 
                                            </ul> 
                                        </div>



                                    </td>
                             		<td>{{ $loop->iteration }}</td>
                             		<td>{{ $supplier->uid }}</td>
                                    <td>{{ $supplier->name }}</td>
                                	<td>{{ $supplier->contract_person }}</td>
                             	
                             		<td>{{ $supplier->email }}</td>
                             		<td>{{ $supplier->phone }}</td>
                             		<td>{{ $supplier->code_sequence }}</td>
                             		 
                             	</tr>
                             	@endforeach
                                  
                             </tbody>
                             <tfoot>
                                 <tr>
                                     <th></th>
                                     <th>Action</th>
                                     <th style="width:3%">SN</th>
                                     <th style="width:3%">S.ID</th>
                                     <th>Supplier Name</th>
                                     <th>Contact Person</th>
                                     <th>Supplier Email</th>
                                     <th>Supplier Mobile</th>
                                     <th>AS Code Serial </th>
                                 </tr>
                             </tfoot>
                         </table>
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
