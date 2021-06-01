<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Validator;
use Auth;


class SizeController extends Controller
{
    public function index()
    {
        $data['sizes'] = Size::where('company_uid',Auth::user()->company_uid)->get();
        return view('backend.sizes.view',$data);
    }
    
    public function create()
    {
         return view('backend.sizes.add');
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

             $sides = New Size();
             $sides->company_uid = Auth::user()->company_uid;
             $sides->user_id = Auth::user()->id;
             $sides->bussiness_type_id = Auth::user()->bussiness_type_id;

             $sides->name = $request->name;
             $sides->description = $request->description;
             $sides->save();

            $notification = array(
                    'message' => 'Successfully Size added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('size.index')->with($notification);

         }



    }

   
    public function show(Size $size)
    {
        //
    }

    
    public function edit(Size $size)
    {
        $data['size'] = Size::find($id);
        return view('backend.sizes.edit',$data);
    }

    
    public function update(Request $request, Side $size,$id)
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

             $size =  Size::find($id);
             $size->company_uid = Auth::user()->company_uid;
             $size->user_id = Auth::user()->id;
             $size->bussiness_type_id = Auth::user()->bussiness_type_id;

             $size->name = $request->name;
             $size->description = $request->description;
             $size->save();

            $notification = array(
                    'message' => 'Successfully Size updated!',
                    'alert-type' => 'success'
            );

            return redirect()->route('size.index')->with($notification);

         }

    }

    public function destroy(Size $size)
    {
         Size::find($id)->delete();

         $notification = array(
                    'message' => 'Successfully Size deleted!',
                    'alert-type' => 'success'
            );

        return redirect()->route('size.index')->with($notification);

    }
}
