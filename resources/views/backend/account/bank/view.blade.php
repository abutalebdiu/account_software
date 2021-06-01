 @extends('home')
 @section('title','Banks')
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
                        <li class="active">Bank</li>
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
                        <a class="sidebar-toggler" href="#">
                            <i class="fa fa-arrows-h"></i>
                        </a>
                        <a class="refresh" id="refresh-toggler" href="default.htm">
                            <i class="glyphicon glyphicon-refresh"></i>
                        </a>
                        <a class="fullscreen" id="fullscreen-toggler" href="#">
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
                                    <span class="widget-caption" style="font-size: 20px">Banks</span>
                                    <div class="widget-buttons">
                                        <a href="#" data-toggle="maximize">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                        <a href="#" data-toggle="collapse">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                        <a href="#" data-toggle="dispose">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="widget-body" style="background-color: #fff;">
                                    <div class="table-toolbar text-right">
                                        <a href="{{route('admin.bank.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Banks</a>
                                    </div>
                                    <table id="example1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Bank Name</th>
                                                <th>Short Name</th>
                                                <th>Address</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($banks as $bank)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$bank->name}}</td>
                                                <td>{{$bank->short_name}}</td>
                                                <td>{{$bank->address}}</td>
                                                <td>
                                                    <a onclick="showData({{$bank->id}});" class="btn btn-success btn-xs"><i class="fa fa-eye" ></i> Show</a>
                                                    <a href="{{route('admin.bank.edit',$bank->id)}}" class="btn btn-info btn-xs edit"><i class="fa fa-edit"></i> Edit</a>
                                                    <a id="delete" href="javascript:void(0)" class="btn btn-danger btn-xs delete" onclick="event.preventDefault(); document.getElementById('banks{{ $loop->iteration }}').submit();">
                                                        <i class="fa fa-trash-o"></i>Delete
                                                    </a>
                                                    <form class="delete" id="banks{{ $loop->iteration }}" action="{{route('admin.bank.destroy',$bank->id)}}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>SN</th>
                                                <th>Bank Name</th>
                                                <th>Short Name</th>
                                                <th>Address</th>
                                                <th>Action</th>
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
            <div class="modal fade" id="bank-show" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> View Bank
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </h4>

                        </div>

                            <div class="modal-body" id="show-modal-body">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>

                    </div>
                </div>
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


    function showData(id){
        $.ajax({
            url: 'bank/' + id,
            type: 'GET',
            success: function(response){
                $("#show-modal-body").append(`
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Bank Name: <span> ${response.name} </span> </label>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Short Name: <span> ${response.short_name} </span> </label>
                        </div>
                    </div>

                    <div class="col-sm-6" style="display:none">
                        <div class="form-group">
                            <label>Payment Method: <span> ${response.payment_method.method} </span> </label>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Address: <span> ${response.address} </span> </label>
                        </div>
                    </div>
                `);
                $('#bank-show').modal('show');
            },
        });
    }

</script>
@endpush
