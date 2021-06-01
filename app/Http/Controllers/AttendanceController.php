<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\User;
use Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $data['attendances'] = Attendance::latest()->get();
          return view('backend.attendances.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['users'] = User::all();
         return view('backend.attendances.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validators =  Validator::make($request->all(),[
             'user_id' => 'required',
             'date_time' => 'required',
             'type' => 'required',
        ]);

        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $attendance = New Attendance();
             $attendance->user_id   = $request->user_id;
             $attendance->date_time = $request->date_time;
             $attendance->type      = $request->type;
             $attendance->status    = 1;
             $attendance->save();

            $notification = array(
                    'message' => 'Successfully attendance added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('attendance.index')->with($notification);

         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance,$id)
    {
       $data['attendance'] =  Attendance::find($id);
       

       
       $data['users'] = User::all();
       
       return view('backend.attendances.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance,$id)
    {
         $validators =  Validator::make($request->all(),[
             'user_id' => 'required',
             'date_time' => 'required',
             'type' => 'required',
        ]);

        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $attendance =  Attendance::find($id);
             $attendance->user_id   = $request->user_id;
             $attendance->date_time = $request->date_time;
             $attendance->type      = $request->type;
             $attendance->status    = 1;
             $attendance->save();

            $notification = array(
                    'message' => 'Successfully attendance Updated!',
                    'alert-type' => 'success'
            );

            return redirect()->route('attendance.index')->with($notification);

         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        $attendance =  Attendance::find($id)->delete();

        $notification = array(
                    'message' => 'Successfully attendance Deleted!',
                    'alert-type' => 'success'
        );

        return redirect()->route('attendance.index')->with($notification);
          
    }
    
    
    
    public function reports()
    {
          $data['attendances'] = Attendance::latest()->get();
          return view('backend.attendances.reports',$data);
    }

    
    
    
    
    
}
