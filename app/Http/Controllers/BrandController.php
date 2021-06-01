<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Auth;
use Validator;
use PDF;
class BrandController extends Controller
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
             $brands->company_uid = companyId_HH();
             $brands->user_id = Auth::user()->id;
             $brands->bussiness_type_id = businessTypeId_HH();
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

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $data['brand'] = Brand::find($id);
        return view('backend.brands.edit',$data);
    }

    
    public function update(Request $request,$id)
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
             $brands->bussiness_type_id = 1;
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

    public function destroy($id)
    {
         Brand::find($id)->delete();

         $notification = array(
                    'message' => 'Successfully Brand deleted!',
                    'alert-type' => 'success'
            );

        return redirect()->route('brand.index')->with($notification);

    }


    public function brandPdfDownload(Request $request)
    {
        $input = $request->all();
         $all_ids = [];
         if($request->brand_id == null)
         {
            $data['brands'] = Brand::get();
         }
         else{
            if($input['brand_id'] != ''){
                foreach ($input['brand_id'] as $key => $value) {
                    array_push($all_ids,$input['brand_id'][$key]);
                }
            }
            $data['brands'] = Brand::whereIn('id',$all_ids)->get();
        }
        $pdf = PDF::loadView('backend.brands.pdf_download',$data);
        return $pdf->download('Brand List.pdf');
    }

}
