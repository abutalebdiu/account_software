<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Backend\Supplier;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use Auth;
use Validator;
class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function supplierCreateByAjax(Request $request)
    {
        $supplier  = new Supplier();
        $supplier->name  = $request->name;
        $supplier->contract_person  = $request->contract_person;
        $supplier->phone  = $request->phone;
        $supplier->email  = $request->email;
        $supplier->previous_due  = $request->previous_due?$request->previous_due:00.00;
        $supplier->address  = $request->address;
        $supplier->description  = $request->description;
        $save = $supplier->save();
        $suppliers = [];
        $suppliers = Supplier::latest()->get();

        // its also perfect working
        /* $html = "";
        if($suppliers)
        {
                foreach($suppliers as $sup)
                {
                    $html .= '<option value="'.$sup->id.'" >'.$sup->name . '</option>';
                }
        } */
        if($save)
        {
            return response()->json([
                'status' => 'success',
                'data'  =>  $suppliers
                //'data'  => $html
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function categoryCreateByAjax(Request $request)
    {
        $category  = new Category();
        $category->name  = $request->name;
        $category->company_uid  = companyId_HH();
        $category->user_id  = Auth::user()->id;
        $category->bussiness_type_id  = businessTypeId_HH();
        $category->description  = $request->description;
        $save = $category->save();
        $categories = [];
        $categories = Category::latest()->get();

        // its also perfect working
        /* $html = "";
        if($categories)
        {
                foreach($categories as $sup)
                {
                    $html .= '<option value="'.$sup->id.'" >'.$sup->name . '</option>';
                }
        } */
        if($save)
        {
            return response()->json([
                'status' => 'success',
                'data'  =>  $categories
                //'data'  => $html
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }


    public function breandCreateByAjax(Request $request)
    {
        $brand  = new Brand();
        $brand->name  = $request->name;
        $brand->description  =  $request->description;
        $brand->company_uid  = companyId_HH();
        $brand->user_id  = Auth::user()->id;
        $brand->bussiness_type_id  = businessTypeId_HH();
        $save = $brand->save();

        $brands = [];
        $brands = Brand::latest()->get();

        // its also perfect working
        /* $html = "";
        if($suppliers)
        {
                foreach($suppliers as $sup)
                {
                    $html .= '<option value="'.$sup->id.'" >'.$sup->name . '</option>';
                }
        } */
        if($save)
        {
            return response()->json([
                'status' => 'success',
                'data'  =>  $brands
                //'data'  => $html
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function unitCreateByAjax(Request $request)
    {
        /*  $validators =  Validator::make($request->all(),[
            'name' => 'required|max:3',
            'description' => 'required',
        ]); */

        /* if($validators->fails()){ */
            /*  $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                ); */
            /*    return response()->json([
                    'status' => 'errors',
                    'data'  =>  $validators
                    //'data'  => $html
                ]);
            return redirect()->back()->withErrors($validators)->withInput();
        } */

        $unit  = new Unit();
        $unit->full_name  = $request->name;
        $unit->short_name  = $request->name;
        $unit->description  =  $request->description;
        $unit->company_uid  = companyId_HH();
        $unit->user_id  = Auth::user()->id;
        $unit->bussiness_type_id  = businessTypeId_HH();
        $save = $unit->save();

        $units = [];
        $units = Unit::latest()->get();

        // its also perfect working
        /* $html = "";
        if($suppliers)
        {
                foreach($suppliers as $sup)
                {
                    $html .= '<option value="'.$sup->id.'" >'.$sup->name . '</option>';
                }
        } */
        if($save)
        {
            return response()->json([
                'status' => 'success',
                'data'  =>  $units
                //'data'  => $html
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }



    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
