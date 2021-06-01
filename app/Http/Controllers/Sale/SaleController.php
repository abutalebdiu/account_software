<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Backend\Sale\Sale_final;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['sales'] = Sale_final::latest()->get();
        return view('backend.sale.view',$data);
        dd($data['customers']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['products']   = Product::latest()->get();
        $data['categories'] = Category::latest()->get();
         $data['customers']  = Customer::whereNull('deleted_at')->get(); 
        
        return view('backend.sale.create',$data);
    }

    
    public function createPos()
    {
        $data['products']   = Product::latest()->get();
        $data['categories'] = Category::latest()->get();


        $data['customers']  = Customer::get(); 
        

        return view('backend.sale_pos.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
