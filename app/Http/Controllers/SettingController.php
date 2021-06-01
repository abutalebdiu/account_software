<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Validator;
use Auth;

class SettingController extends Controller
{
    public function index()
    {
        $data['settings'] = Setting::where('company_uid',Auth::user()->company_uid)->get();
        return view('backend.settings.view',$data);
    }
    
    public function create()
    {
         return view('backend.settings.add');
    }

    
    public function store(Request $request)
    {

        $validators =  Validator::make($request->all(),[
                'shopname' => 'required',
        ]);

        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $setting = New Setting();
             $setting->company_uid = Auth::user()->company_uid;
             $setting->user_id = Auth::user()->id;
             $setting->bussiness_type_id = Auth::user()->bussiness_type_id;

             $setting->shopname = $request->shopname;
             $setting->address  = $request->address;
             $setting->phone    = $request->phone;
             $setting->vat_status= $request->vat_status;
             $setting->description = $request->description;
             $setting->vat_registration = $request->vat_registration;
             $setting->print_format = $request->print_format;
             $setting->logo = $request->logo;
             $setting->invoice_logo = $request->invoice_logo;
             $setting->footer_text = $request->footer_text;


            $setting->save();

            $notification = array(
                    'message' => 'Successfully setting added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('setting.index')->with($notification);

         }



    }

   
    public function show(Setting $setting)
    {
        //
    }

    
    public function edit(Setting $setting,$id)
    {
        $data['setting'] = Setting::find($id);
        return view('backend.settings.edit',$data);
    }

    
    public function update(Request $request, Setting $setting,$id)
    {
         $validators =  Validator::make($request->all(),[
                'shopname' => 'required',
        ]);
        
        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $setting =  Setting::find($id);
             $setting->company_uid = Auth::user()->company_uid;
             $setting->user_id = Auth::user()->id;
             $setting->bussiness_type_id = Auth::user()->bussiness_type_id;

             $setting->shopname = $request->shopname;
             $setting->address  = $request->address;
             $setting->phone    = $request->phone;
             $setting->vat_status= $request->vat_status;
             $setting->description = $request->description;
             $setting->vat_registration = $request->vat_registration;
             $setting->print_format = $request->print_format;
             $setting->logo = $request->logo;
             $setting->invoice_logo = $request->invoice_logo;
             $setting->footer_text = $request->footer_text;


             $setting->save();

             $notification = array(
                    'message' => 'Successfully setting updated!',
                    'alert-type' => 'success'
             );

            return redirect()->route('setting.index')->with($notification);

         }

    }

    public function destroy(Setting $setting)
    {
         Setting::find($id)->delete();

         $notification = array(
                    'message' => 'Successfully Setting deleted!',
                    'alert-type' => 'success'
            );

        return redirect()->route('setting.index')->with($notification);

    }
}
