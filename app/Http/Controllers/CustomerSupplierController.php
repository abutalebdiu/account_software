<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class CustomerSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] = User::whereIn('role', [3,4])->get();
        return view('backend.customer_supplier.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.customer_supplier.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'mobile' => 'required|unique:users,mobile',
            'role' => 'required',
        ]);
        
        $data = new User;
        
        $data->name = $request->name;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->role = $request->role;
        $data->save();
        
        $notification = array(
            'message' => 'Successfully data inserted!',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.supplier.index')->with($notification);
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
        $data['data'] = User::find($id);
        return view('backend.customer_supplier.edit',$data);
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
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'mobile' => 'required',
            'role' => 'required|unique:users,mobile,'.$id,
        ]);
        
        $data = User::find($id);
        
        $data->name = $request->name;
        $data->email = $request->email;
        $data->mobile = $request->mobile;
        $data->role = $request->role;
        $data->save();
        
        $notification = array(
            'message' => 'Successfully data updated!',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.supplier.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
        
        $notification = array(
            'message' => 'Successfully data deleted!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
