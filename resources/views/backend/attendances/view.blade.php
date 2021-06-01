 @extends('home')
 @section('title','Attendance List')
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
             <li class="active">Attendance</li>
         </ul>
     </div>
     <!-- /Page Breadcrumb -->
 
     <!-- Page Body -->
     <div class="page-body">
         <div class="row">
             <div class="col-xs-12 col-md-12">
                 <div class="widget">
                     <div class="widget-header bg-info">
                         <span class="widget-caption" style="font-size: 20px">Attendance List</span>
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
                                     <th>Stuff Name</th>
                                     <th>Attenance Type</th>
                                     <th>Date</th>
                                     <th>Time</th>
                                     <th>Action</th>
                                 </tr>
                             </thead>
                             <tbody>
                                @foreach($attendances as $attendance)
                                 <tr>
                                    
                                     <td>{{$loop->iteration}}</td>
                                     <td>{{$attendance->user?$attendance->user->name:''  }}</td>
                                     <td>
                                         
                                         @if($attendance->type==1)
                                         
                                         Entry
                                         
                                         @else
                                         
                                         
                                         Exit
                                         
                                         @endif
                                     
                                     
                                     </td>
                                     <td> {{ Date('d-m-Y', strtotime($attendance->date_time)) }}</td>
                                     <td> {{ Date('h:i:s A', strtotime($attendance->date_time)) }}</td>
                                     <td>
                                         <a href="{{route('attendance.edit',$attendance->id)}}" class="btn btn-info btn-xs edit"><i class="fa fa-edit"></i> Edit</a>
                                         <a id="delete" href="{{route('attendance.destroy',$attendance->id)}}" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i> Delete</a>
                                     </td>
                                 </tr>
                                 @endforeach
                             </tbody>
                             <tfooter>
                                <tr>
                                     <th>Sl.No</th>
                                     <th>Stuff Name</th>
                                     <th>Attenance Type</th>
                                     <th>Date</th>
                                     <th>Time</th>
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


        </script>

    @endpush
 @endsection
