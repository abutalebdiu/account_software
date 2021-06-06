 @extends('home')
 @section('title','Add Customer Loan')
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
             <li class="active">Add Customer Loan</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
    
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Add Customer Loan</span>
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
                     <div class="widget-body">
                         <form action="{{route('customer.loan.update',$loan->id)}}" method="post">
                            @csrf
                             <div class="row">



                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Select Customer</label>

                                         <select name="customer_id" class="form-control">
                                             <option value="">Select Customer</option>
                                             @foreach($customers as $customer)
                                             <option {{ $loan->customer_id == $customer->id ? 'selected' : '' }} value="{{ $customer->id }}">{{ $customer->name }}</option>
                                             @endforeach
                                         </select>
                                          
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('customer_id'))?($errors->first('customer_id')):''}}</div>
                                     </div>
                                 </div> 

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Amount</label>
                                         <input name="amount" value="{{ $loan->amount }}" type="text" placeholder="Amount" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('amount'))?($errors->first('amount')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Loan Reason</label>
                                         <input name="loan_reason" type="text" value="{{ $loan->loan_reason }}" placeholder="Loan Reason" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('loan_reason'))?($errors->first('loan_reason')):''}}</div>
                                     </div>
                                 </div>
                                
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Loan Date</label>
                                         <input name="loan_date" type="date"  value="{{ $loan->loan_date }}" placeholder="Loan Date" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('loan_date'))?($errors->first('loan_date')):''}}</div>
                                     </div>
                                 </div>
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Retrun Date</label>
                                         <input name="return_date" type="date"  value="{{ $loan->return_date }}" placeholder="Return Date" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('return_date'))?($errors->first('return_date')):''}}</div>
                                     </div>
                                 </div>
                                 
                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Description</label>
                                         <input name="note" type="text" value="{{ $loan->note }}" placeholder="Note" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('note'))?($errors->first('note')):''}}</div>
                                     </div>
                                 </div>

                                 <div class="col-sm-6">
                                     <div class="form-group">
                                         <label for="">Responsible Person</label>
                                         <input name="takenby" type="text" value="{{$loan->takenby }}" placeholder="Responsible Person" class="form-control">
                                         <div style='color:red; padding: 0 5px;'>{{($errors->has('takenby'))?($errors->first('takenby')):''}}</div>
                                     </div>
                                 </div>


                                 <div class="col-sm-12">
                                     <div class="form-group">
                                         <input class="btn btn-primary" type="submit" value="Submit">
                                         <a href="{{route('customer.loan.index')}}" class="btn btn-info">Back</a>
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
