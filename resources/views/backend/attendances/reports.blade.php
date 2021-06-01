 @extends('home')
 @section('title','Attendance Report')
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
             <li class="active">Brands</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
 
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Attendance Report</span>
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
                      
                         <form action="" method="get">                   
                            <div class="row" style="margin: 30px 0;margin-top:0px;">
                                <div class="col-md-6">
                                    <div class="table-toolbar text-right">
                                        <button class="btn btn-primary pull-left" name="pdf"> <i class="fa fa-download"></i> PDF</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-toolbar text-right">
                                       <a href="{{route('attendance.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>  Take Attendances</a>
                                    </div>
                                </div>
                            </div>

                         <table id="example1" class="table table-bordered table-striped table-hover">
                             <thead>
                                 <tr>
                                     <th>Sl.No</th>
                                     <th>Date</th>
                                     <th>Entry</th>
                                     <th>Exit</th>
                                 </tr>
                             </thead>
                             <tbody>

                                <tr>
                                    <td>01</td>
                                    <td> 01-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>

                                <tr>
                                    <td>01</td>
                                    <td> 02-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>

                                <tr>
                                    <td>01</td>
                                    <td> 01-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>

                                <tr>
                                    <td>01</td>
                                    <td> 03-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>

                                <tr>
                                    <td>01</td>
                                    <td> 04-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>

                                <tr>
                                    <td>01</td>
                                    <td> 05-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>

                                 <tr>
                                    <td>01</td>
                                    <td> 06-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>

                                <tr>
                                    <td>01</td>
                                    <td> 07-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>

                                <tr>
                                    <td>01</td>
                                    <td> 08-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>

                                <tr>
                                    <td>01</td>
                                    <td> 09-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>

                                <tr>
                                    <td>01</td>
                                    <td> 10-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>

                                <tr>
                                    <td>01</td>
                                    <td> 11-05-2021 </td>
                                    <td> 9.00 AM </td>
                                    <td> 6.00 PM </td>
                                </tr>
                               
                             </tbody>
                             <tfooter>
                                  <tr>
                                     <th>Sl.No</th>
                                     <th>Date</th>
                                     <th>Entry</th>
                                     <th>Exit</th>
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
