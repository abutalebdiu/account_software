<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function index()
    {
        $data['brands'] = Brand::where('company_uid',Auth::user()->company_uid)->get();
        return view('backend.brands.view',$data);
    }
    
    public function create()
    {
         return view('backend.brands.add');
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

             $brands = New Brand();
             $brands->company_uid = Auth::user()->company_uid;
             $brands->user_id = Auth::user()->id;
             $brands->bussiness_type_id = Auth::user()->bussiness_type_id;
             $brands->name = $request->name;
             $brands->description = $request->description;
             $brands->save();

            $notification = array(
                    'message' => 'Successfully Brand added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('brand.index')->with($notification);

         }



    }

   
    public function show(Brand $brand)
    {
        //
    }

    
    public function edit(Brand $brand)
    {
        $data['brand'] = Brand::find($id);
        return view('backend.brands.edit',$data);
    }

    
    public function update(Request $request, Brand $brand,$id)
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

             $brands =  Brand::find($id);
             $brands->company_uid = Auth::user()->company_uid;
             $brands->user_id = Auth::user()->id;
             $brands->bussiness_type_id = Auth::user()->bussiness_type_id;
             $brands->name = $request->name;
             $brands->description = $request->description;
             $brands->save();

            $notification = array(
                    'message' => 'Successfully Brand added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('brand.index')->with($notification);

         }

    }

    public function destroy(Brand $brand)
    {
         Brand::find($id)->delete();

         $notification = array(
                    'message' => 'Successfully Brand deleted!',
                    'alert-type' => 'success'
            );

        return redirect()->route('brand.index')->with($notification);

    }
}
