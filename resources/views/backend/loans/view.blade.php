 @extends('home')
 @section('title','Customer Loan')
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
                        <li class="active">Customer Loan</li>
                    </ul>
                </div>
                <!-- /Page Breadcrumb -->
             
                <!-- Page Body -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="widget">
                                <div class="widget-header bg-info">
                                    <span class="widget-caption" style="font-size: 20px">Customer Loan</span>
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
                                   
                                              
                                        <div class="row" style="margin: 10px 0;margin-top:0px;">
                                           <div class="col-md-12">
                                                <div class="table-toolbar text-right">
                                                    <a href="{{route('customer.loan.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Loan</a>
                                                </div>
                                            </div>
                                        </div>
                                    <table id="example1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                              
                                                <th>SN</th>
                                                <th>ID</th>
                                                <th>Customer Name</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Return Date</th>
                                                <th>Reason</th>
                                                <th>Note</th>
                                                <th>Responsible Person</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($loans as $loan)
                                            <tr>
                                                
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$loan->loanuid}}</td>
                                                <td>{{$loan->customer?$loan->customer->name:''}}</td>
                                                <td>{{$loan->amount}}</td>
                                                <td>{{$loan->loan_date}}</td>
                                                <td>{{$loan->return_date}}</td>
                                                <td>{{ $loan->loan_reason }}</td>
                                                <td>{{$loan->note}}</td>
                                                <td>{{ $loan->takenby }}</td>
                                                 
                                                <td>


                                            <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu"> 
                                                        <li>  <a href="{{route('customer.loan.edit',$loan->id)}}" class="btn btn-info btn-xs edit text-white"><i class="fa fa-edit"></i> Edit</a></li> 

                                                        <li>  <a href="{{route('customer.loan.edit',$loan->id)}}" class="btn btn-info btn-xs edit text-white"><i class="fa fa-edit"></i> Received</a></li>


                                                        <li> <a id="delete" href="{{route('customer.loan.destroy',$loan->id)}}" class="btn btn-danger btn-xs delete text-white"><i class="fa fa-trash-o"></i> Delete</a></li>
                                                         
                                                    </ul> 
                                                </div>

  
                                                  
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfooter>
                                           <tr>
                                              
                                                <th>SN</th>
                                                <th>ID</th>
                                                <th>Customer Name</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Return Date</th>
                                                <th>Reason</th>
                                                <th>Note</th>
                                                <th>Responsible Person</th>
                                                <th>Action</th>
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



 @endsection
