<?php

namespace App\Http\Controllers;

use App\Models\Brunch;
use Illuminate\Http\Request;
use Validator;
use Auth;

class BrunchController extends Controller
{
    public function index()
    {
        $data['brunches'] = Brunch::where('company_uid',Auth::user()->company_uid)->get();
        return view('backend.brunches.view',$data);
    }
    
    public function create()
    {
         return view('backend.brunches.add');
    }

    
    public function store(Request $request)
    {

        $validators =  Validator::make($request->all(),[
                'name' => 'required',
                'shopname' => 'required',
        ]);

        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $Brunchs = New Brunch();
             $Brunchs->company_uid = companyId_HH();
             $Brunchs->user_id = Auth::user()->id;
             $Brunchs->bussiness_type_id = businessTypeId_HH();

             $Brunchs->name = $request->name;
             $Brunchs->shopname = $request->shopname;
             $Brunchs->description = $request->description;
             $Brunchs->email = $request->email;
             $Brunchs->phone = $request->phone;
             $Brunchs->address = $request->address;
             $Brunchs->zip_code = $request->zip_code;
             $Brunchs->commission_status = $request->commission_status;
             $Brunchs->commission_type = $request->commission_type;
             $Brunchs->commission_rate = $request->commission_rate;
             $Brunchs->status = 1;
             $Brunchs->save();

            $notification = array(
                    'message' => 'Successfully Brunch added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('brunch.index')->with($notification);

         }



    }

   
    public function show(Brunch $Brunch)
    {
        //
    }

    
    public function edit(Brunch $Brunch)
    {
        $data['brunch'] = Brunch::find($id);
        return view('backend.brunches.edit',$data);
    }

    
    public function update(Request $request, Brunch $Brunch,$id)
    {
         $validators =  Validator::make($request->all(),[
                'name' => 'required',
        ]);
        
        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $Brunchs =  Brunch::find($id);
             $Brunchs->name = $request->name;
             $Brunchs->shopname = $request->shopname;
             $Brunchs->description = $request->description;
             $Brunchs->email = $request->email;
             $Brunchs->phone = $request->phone;
             $Brunchs->address = $request->address;
             $Brunchs->zip_code = $request->zip_code;
             $Brunchs->commission_status = $request->commission_status;
             $Brunchs->commission_type = $request->commission_type;
             $Brunchs->commission_rate = $request->commission_rate;
             $Brunchs->status = 1;
             $Brunchs->save();

            $notification = array(
                    'message' => 'Successfully Brunch updated!',
                    'alert-type' => 'success'
            );

            return redirect()->route('brunch.index')->with($notification);

         }

    }

    public function destroy(Brunch $brunch,$id)
    {
         Brunch::find($id)->delete();

         $notification = array(
                    'message' => 'Successfully Brunch deleted!',
                    'alert-type' => 'success'
            );

        return redirect()->route('brunch.index')->with($notification);

    }
}
