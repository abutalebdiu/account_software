<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Validator;
use Auth;


class ColorController extends Controller
{
    public function index()
    {
        $data['colors'] = Color::where('company_uid',Auth::user()->company_uid)->get();
        return view('backend.colors.view',$data);
    }
    
    public function create()
    {
         return view('backend.colors.add');
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

             $color = New Color();
             $color->company_uid = companyId_HH();
             $color->user_id = Auth::user()->id;
             $color->bussiness_type_id = businessTypeId_HH();

             $color->name = $request->name;
             $color->description = $request->description;
             $color->save();

            $notification = array(
                    'message' => 'Successfully color attribute added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('color.index')->with($notification);

         }



    }

   
    public function show(Color $color)
    {
        //
    }

    
    public function edit(Color $color,$id)
    {
        $data['color'] = Color::find($id);
        return view('backend.colors.edit',$data);
    }

    
    public function update(Request $request, Color $color,$id)
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

             $color =  Color::find($id);
             $color->company_uid = Auth::user()->company_uid;
             $color->user_id = Auth::user()->id;
             $color->bussiness_type_id = Auth::user()->bussiness_type_id;

             $color->name = $request->name;
             $color->description = $request->description;
             $color->save();

            $notification = array(
                    'message' => 'Successfully color added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('color.index')->with($notification);

         }

    }

    public function destroy(Color $color,$id)
    {
         Color::find($id)->delete();

         $notification = array(
                    'message' => 'Successfully Brand deleted!',
                    'alert-type' => 'success'
            );

        return redirect()->route('color.index')->with($notification);

    }
}
