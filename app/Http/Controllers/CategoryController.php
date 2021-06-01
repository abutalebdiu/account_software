<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Validator;
use Auth;
use PDF;
class CategoryController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::where('company_uid',Auth::user()->company_uid)->get();
        return view('backend.categories.view',$data);
    }
    
    public function create()
    {
         return view('backend.categories.add');
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

             $category = New Category();
             $category->company_uid = companyId_HH();
             $category->user_id     = Auth::user()->id;
             $category->bussiness_type_id = businessTypeId_HH();
             $category->name        = $request->name;
             $category->description = $request->description;
             $category->save();

            $notification = array(
                    'message' => 'Successfully Brand added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('category.index')->with($notification);

         }



    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $data['category'] = Category::find($id);
        return view('backend.categories.edit',$data);
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

             $category =  Category::find($id);
             $category->company_uid = Auth::user()->company_uid;
             $category->user_id     = Auth::user()->id;
             $category->bussiness_type_id = 1;
             $category->name        = $request->name;
             $category->description = $request->description;
             $category->save();

            $notification = array(
                    'message' => 'Successfully Brand added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('category.index')->with($notification);

         }

    }

    public function destroy($id)
    {
         Category::find($id)->delete();

         $notification = array(
                    'message' => 'Successfully Brand deleted!',
                    'alert-type' => 'success'
            );

        return redirect()->route('category.index')->with($notification);

    }


    public function categoryPdfDownload(Request $request)
    {
        $input = $request->all();
         $all_ids = [];
         if($request->cat_id == null)
         {
            $data['categories'] = Category::get();
         }
         else{
            if($input['cat_id'] != ''){
                foreach ($input['cat_id'] as $key => $value) {
                    array_push($all_ids,$input['cat_id'][$key]);
                }
            }
            $data['categories'] = Category::whereIn('id',$all_ids)->get();
        }
        $pdf = PDF::loadView('backend.categories.pdf_download',$data);
        return $pdf->download('Category List.pdf');
    }

}
