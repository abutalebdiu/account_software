<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use Illuminate\Http\Request;
use Validator;
use Auth;

class BusinessTypeController extends Controller
{
   public function index()
    {
        $data['businesstypes'] = BusinessType::all();
        return view('backend.businesstype.view',$data);
    }
    
    public function create()
    {
         return view('backend.businesstype.add');
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

             $businesstype = New BusinessType();
             $businesstype->business_name = $request->name;
             $businesstype->save();

            $notification = array(
                    'message' => 'Successfully business name added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('businesstype.index')->with($notification);

         }



    }

   
    public function show(BusinessType $businesstype)
    {
        //
    }

    
    public function edit(BusinessType $businesstype,$id)
    {
        $data['businesstype'] = BusinessType::find($id);
        return view('backend.businesstype.edit',$data);
    }

    
    public function update(Request $request, BusinessType $businesstype,$id)
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

             $businesstype =  BusinessType::find($id);
             $businesstype->business_name = $request->name;
             $businesstype->save();

            $notification = array(
                    'message' => 'Successfully business name added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('businesstype.index')->with($notification);

         }

    }

    public function destroy(BusinessType $businesstype,$id)
    {
        BusinessType::find($id)->delete();

        $notification = array(
            'message' => 'Successfully business type deleted!',
            'alert-type' => 'success'
        );

        return redirect()->route('businesstype.index')->with($notification);

    }
}
