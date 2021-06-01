<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Auth;
use Validator;
use PDF;
class GroupController extends Controller
{
     
    public function index()
    {
        $data['groupes'] = Group::all();
        return view('backend.groupes.view',$data);
    }
    
    public function create()
    {
         return view('backend.groupes.add');
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

             $group = New Group();
             $group->name = $request->name;
             $group->save();

            $notification = array(
                    'message' => 'Successfully Group added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('group.index')->with($notification);

         }



    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $data['group'] = Group::find($id);
        return view('backend.groupes.edit',$data);
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

             $group =  Group::find($id);
             $group->name = $request->name;
             $group->save();


            $notification = array(
                    'message' => 'Successfully Group Updated!',
                    'alert-type' => 'success'
            );

            return redirect()->route('group.index')->with($notification);

         }

    }

    public function destroy($id)
    {
         Group::find($id)->delete();

         $notification = array(
                    'message' => 'Successfully Group deleted!',
                    'alert-type' => 'success'
            );

        return redirect()->route('group.index')->with($notification);

    }


    public function groupPdfDownload(Request $request)
    {
        $input = $request->all();
         $all_ids = [];
         if($request->brand_id == null)
         {
            $data['groupes'] = Group::get();
         }
         else{
            if($input['group_id'] != ''){
                foreach ($input['group_id'] as $key => $value) {
                    array_push($all_ids,$input['group_id'][$key]);
                }
            }
            $data['groupes'] = Group::whereIn('id',$all_ids)->get();
        }
        $pdf = PDF::loadView('backend.groupes.pdf_download',$data);
        return $pdf->download('Groupes List.pdf');
    }

}
