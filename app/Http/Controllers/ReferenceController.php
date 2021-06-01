<?php

namespace App\Http\Controllers;
use App\Models\Reference;
use Illuminate\Http\Request;
use DB;
use Validator;

class ReferenceController extends Controller
{
    
    public function index()
    {
        $data['references'] = Reference::latest()->get();
        return view('backend.references.view',$data);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('backend.references.add');
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
             'name' => 'required',
             'mobile' => 'required',
             'address' => 'required',
        ]);

        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $reference          = New Reference();
             $reference->name	 = $request->name	;
             $reference->email   = $request->email;
             $reference->password= bcrypt($request->password);
             $reference->gender  = $request->gender;
             $reference->phone   = $request->mobile;
             $reference->phone_2 = $request->phone_2;
             $reference->profession= $request->profession;
             $reference->address = $request->address;
             $reference->note    = $request->note;
             $reference->blood_group= $request->blood_group;
             $reference->religion= $request->religion;
             $reference->id_no   = $request->id_no;
             $reference->save();

            $notification = array(
                    'message' => 'Successfully Mistri added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('reference.index')->with($notification);

         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Reference $reference)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Reference $reference,$id)
    {
       $data['reference'] = Reference::find($id);
   
       return view('backend.references.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reference $reference,$id)
    {
         $validators =  Validator::make($request->all(),[
             'name' => 'required',
             'mobile' => 'required',
             'address' => 'required',
        ]);

        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $reference          = Reference::find($id);
             $reference->name	 = $request->name	;
             $reference->email   = $request->email;
             $reference->password= bcrypt('123456789');
             $reference->gender  = $request->gender;
             $reference->phone   = $request->mobile;
             $reference->phone_2 = $request->phone_2;
             $reference->profession= $request->profession;
             $reference->address = $request->address;
             $reference->note    = $request->note;
             $reference->blood_group= $request->blood_group;
             $reference->religion= $request->religion;
             $reference->id_no   = $request->id_no;
             $reference->save();

            $notification = array(
                    'message' => 'Successfully Mistri Updated!',
                    'alert-type' => 'success'
            );

            return redirect()->route('reference.index')->with($notification);

         }
    }

   
    public function destroy(Reference $reference)
    {
        $reference =  Reference::find($id)->delete();

        $notification = array(
                    'message' => 'Successfully reference Deleted!',
                    'alert-type' => 'success'
        );

        return redirect()->route('reference.index')->with($notification);
          
    }
    
    
    
    
}
