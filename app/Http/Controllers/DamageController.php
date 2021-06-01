<?php

namespace App\Http\Controllers;

use App\Models\Damage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use Validator;



class DamageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $query = Damage::query();

        if($request->supplier_id)
        {
            $data['supplier_id'] = $request->supplier_id;
            $query = $query->where('supplier_id',$request->supplier_id);
        }

        $data['damages'] = $query->latest()->get();
        $data['suppliers'] = Supplier::get();
        return view('backend.damages.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['suppliers'] = Supplier::get();
        return view('backend.damages.add',$data);
    }


    public function findsupplierproduct(Request $request)
    {
        $output = "<option value=''>Select Product </option>";

        $supplier_id  = $request->supplier_id;

        $findproduct  = Product::where('supplier_id',$supplier_id)->get();

        foreach ($findproduct as $value) {
            $output .= "<option value=$value->id> $value->name </option>";
        }

        return ($output);
    }









    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validators =  Validator::make($request->all(),[
                'supplier_id' => 'required',
                'product_id' => 'required',
                'price' => 'required',
                'quantity' => 'required',
                'total_price' => 'required',
        ]);

        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $damage = New Damage();
             $damage->supplier_id = $request->supplier_id;
             $damage->product_id = $request->product_id;
             $damage->price = $request->price;
             $damage->quantity = $request->quantity;
             $damage->total_price = $request->total_price;
             $damage->status = 1;
             $damage->save();

            $notification = array(
                    'message' => 'Successfully damage added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('damage.index')->with($notification);

         }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Damage  $damage
     * @return \Illuminate\Http\Response
     */
    public function show(Damage $damage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Damage  $damage
     * @return \Illuminate\Http\Response
     */
    public function edit(Damage $damage,$id)
    {
        $data['suppliers'] = Supplier::get();
        $data['damage']    = Damage::find($id);
        $data['products']  = Product::where('supplier_id',$data['damage']->supplier_id)->get();
        return view('backend.damages.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Damage  $damage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Damage $damage,$id)
    {
        $validators =  Validator::make($request->all(),[
                'supplier_id' => 'required',
                'product_id' => 'required',
                'price' => 'required',
                'quantity' => 'required',
                'total_price' => 'required',
        ]);

        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $damage = Damage::find($id);
             $damage->supplier_id = $request->supplier_id;
             $damage->product_id  = $request->product_id;
             $damage->price       = $request->price;
             $damage->quantity    = $request->quantity;
             $damage->total_price = $request->total_price;
             $damage->status     = 1;
             $damage->save();

            $notification = array(
                    'message' => 'Successfully damage added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('damage.index')->with($notification);

         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Damage  $damage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Damage $damage)
    {
        //
    }
}
