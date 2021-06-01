<?php

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\Http\Request;
use Auth;
use Validator;

class WeightController extends Controller
{
    public function index()
    {
        $data['weights'] = Weight::where('company_uid',Auth::user()->company_uid)->get();
        return view('backend.weight.view',$data);
    }
    
    public function create()
    {
         return view('backend.weight.add');
    }

    
    public function store(Request $request)
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

             $weight = New Weight();
             $weight->company_uid = Auth::user()->company_uid;
             $weight->user_id = Auth::user()->id;
             $weight->bussiness_type_id = Auth::user()->bussiness_type_id;
             $weight->name = $request->name;
             $weight->description = $request->description;
             $weight->save();

            $notification = array(
                    'message' => 'Successfully weight added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('weight.index')->with($notification);

         }



    }

   
    public function show(Weight $weight)
    {
        //
    }

    
    public function edit(Weight $weight)
    {
        $data['weight'] = Weight::find($id);
        return view('backend.weight.edit',$data);
    }

    
    public function update(Request $request, Weight $weight,$id)
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

             $weight =  Weight::find($id);
             $weight->company_uid = Auth::user()->company_uid;
             $weight->user_id = Auth::user()->id;
             $weight->bussiness_type_id = Auth::user()->bussiness_type_id;
             $weight->name = $request->name;
             $weight->description = $request->description;
             $weight->save();

            $notification = array(
                    'message' => 'Successfully weight updated!',
                    'alert-type' => 'success'
            );

            return redirect()->route('weight.index')->with($notification);

         }

    }

    public function destroy(Weight $weight)
    {
         Weight::find($id)->delete();

         $notification = array(
                    'message' => 'Successfully Weight deleted!',
                    'alert-type' => 'success'
            );

        return redirect()->route('weight.index')->with($notification);

    }
}
