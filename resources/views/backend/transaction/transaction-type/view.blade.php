@extends('home')
@section('title','Transaction Type')
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
                        <span class="widget-caption" style="font-size: 20px">Transaction Type</span>
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
                    <div class="widget-body" style="background-color: #fff;">
                        <div class="table-toolbar">
                            <form action="{{route('admin.transaction-type.store')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div style="display: flex;">
                                        <input name="name" value="{{old('name')}}" type="text" placeholder="Name"
                                            class="form-control" id="name">
                                        <button class="btn btn-primary float-right" type="submit">ADD</button>
                                    </div>
                                    <div style='color:red; padding: 0 5px;'>
                                        {{($errors->has('name'))?($errors->first('name')):''}}</div>
                                </div>
                            </form>
                        </div>
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactionTypes as $transactionType)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$transactionType->name}}</td>
                                    <td>
                                        @if ($transactionType->isActive())
                                        <span class="badge rounded-pill bg-success">Active</span>
                                        @else
                                        <span class="badge rounded-pill bg-success">Not active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('admin.transaction-type.edit',$transactionType->id)}}"
                                            class="btn btn-info btn-xs edit"><i class="fa fa-edit"></i> Edit</a>
                                        <form id="delete-form"
                                            action="{{route('admin.transaction-type.destroy',$transactionType->id)}}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-xs" type="submit">
                                                <i class="fa fa-trash-o"></i>Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SN</th>
                                    <th>Name</th>
                                    <th>Active</th>
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
<!-- /Page Content -->
@endsection