<?php

namespace App\Http\Controllers\Backend;

use App\Backend\Reference;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use PDF;

class ReferenceController extends Controller
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
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'name'  => 'required|min:2|max:150',
            //'email' => 'unique:users,email,' . $userId,
            //'email' => 'required|unique:references,email',
            'phone' => 'required|min:6|max:15',
        ]);


        if($validator->fails()){
            return response()->json([
                    'status' => 'errors',
                    'error'=> $validator->getMessageBag()->toArray()
                ]);
        }

        $query          = Reference::query();
        $refcount  = $query->count();
        $refid     = $query->orderBy('id','DESC')->first();

        $ref =  New Reference();

        if($refcount > 0)
        {
            $ref->id_no        = $refid->id_no+1;
        }
        else{
            $ref->id_no = '1001';
        }

        $ref->name                 = $request->name;
        $ref->email                = $request->email ;
        $ref->phone                = $request->phone;
        $ref->address              = $request->address ;
        $ref->note                 = $request->notes;
        $ref->profession           = $request->profession;
        //$ref->nid_no               = $request->nid_no;
        //$ref->birth_date           = $request->birth_date;
        //$ref->anniversary_date     = $request->anniversary_date;
        //$ref->company_name         = $request->company_name;
        //$ref->shipping_address     = $request->shipping_address;
        //$ref->anniversary_date     = $request->anniversary_date;
        $ref->verified             = 1;
        $data = $ref->save();



        //$refs = [];
        //$refs = reference::latest()->get();

        // its also perfect working
        /* $html = "";
            if($suppliers)
            {
                    foreach($suppliers as $sup)
                    {
                        $html .= '<option value="'.$sup->id.'" >'.$sup->name . '</option>';
                    }
            }
        */

        if($data)
        {
            return response()->json([
                'status' => true,
                'data_name'  =>  $request->name,
                'data_id'  =>  $ref->id
                //'data'  => $html
            ]);
        }else{
            return response()->json([
                'status' => false
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Backend\Reference  $ref
     * @return \Illuminate\Http\Response
     */
    public function show(Reference $ref)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Backend\Reference  $ref
     * @return \Illuminate\Http\Response
     */
    public function edit(Reference $ref)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Backend\Reference  $ref
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reference $ref)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Backend\Reference  $ref
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reference $ref)
    {
        //
    }
}
