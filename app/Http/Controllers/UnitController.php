<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Validator;
use Auth;
use PDF;
class UnitController extends Controller
{
    public function index()
    {
        $data['units'] = Unit::where('company_uid',Auth::user()->company_uid)
        ->whereNull('deleted_at')->get();
        return view('backend.units.view',$data);
    }
    
    public function create()
    {
       $data['units'] =  Unit::where('company_uid',Auth::user()->company_uid)->whereNull('deleted_at')->get();
         return view('backend.units.add',$data); 
    }

    
    public function store(Request $request)
    {
        
        $validators =  Validator::make($request->all(),[
                'full_name' => 'required',
                'short_name' => 'required',
                'parent_id' => 'required',
                'base_unit_id' => 'required',
                'calculation_value' => 'required|numeric',
        ]);
        //return $request;
        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

            return redirect()->back()->withErrors($validators)->withInput();
        }
        
        else{
                $parentId = 0;
                if($request->parent_id > 0)
                {
                    $parentId =  $this->unitsCheck($request->parent_id);
                    $calculationResult = $parentId->calculation_result * $request->calculation_value;
                    $parent_cal_result = $parentId->calculation_result;
                }
                else{
                    $calculationResult = $request->calculation_value;
                    $parent_cal_result = NULL;
                }
               
             $unit = New Unit();
             $unit->company_uid = Auth::user()->company_uid;
             $unit->user_id = Auth::user()->id;
             $unit->bussiness_type_id = 1;

             $unit->full_name   = $request->full_name;
             $unit->short_name  = $request->short_name;
             $unit->parent_id   = $request->parent_id;
             $unit->parent_cal_result   = $parent_cal_result;
             $unit->calculation_value  = $request->calculation_value;
             $unit->calculation_result  = $calculationResult;
            
             $unit->description     = $request->description;
             $unit->save();
            if($request->base_unit_id > 0)
            {
                $unit->base_unit_id    = $request->base_unit_id;
            }else{
                $unit->base_unit_id    = $unit->id;
            }
            $unit->save();
            $notification = array(
                    'message' => 'Successfully unit added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('unit.index')->with($notification);

         }

    }

    public function unitsCheck($id)
    {
        return Unit::find($id);
    }
   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $data['units'] =  Unit::where('company_uid',Auth::user()->company_uid)->whereNull('deleted_at')->get();
        $data['unit'] = Unit::find($id);
        return view('backend.units.edit',$data);
    }

    
    public function update(Request $request,$id)
    {
        $validators =  Validator::make($request->all(),[
            'full_name' => 'required',
            'short_name' => 'required',
            'parent_id' => 'required',
            'base_unit_id' => 'required',
            'calculation_value' => 'required|numeric',
        ]);
        
        if($validators->fails()){
            $notification = array(
                'message' => 'Someting Error!',
                'alert-type' => 'error'
            );
            return redirect()->back()->withErrors($validators)->withInput();
        }

        else{
                $parentId = 0;
                if($request->parent_id > 0)
                {
                    $parentId =  $this->unitsCheck($request->parent_id);
                    $calculationResult = $parentId->calculation_result * $request->calculation_value;
                    $parent_cal_result = $parentId->calculation_result;
                }
                else{
                    $calculationResult = $request->calculation_value;
                    $parent_cal_result = NULL;
                }
            
                $unit = Unit::find($id);
                $unit->company_uid = Auth::user()->company_uid;
                $unit->user_id = Auth::user()->id;
                $unit->bussiness_type_id = 1;

                $unit->full_name   = $request->full_name;
                $unit->short_name  = $request->short_name;
                $unit->parent_id   = $request->parent_id;
                $unit->parent_cal_result   = $parent_cal_result;
                $unit->calculation_value  = $request->calculation_value;
                $unit->calculation_result  = $calculationResult;
                
                $unit->description     = $request->description;
                $unit->save();
                if($request->base_unit_id > 0)
                {
                    $unit->base_unit_id    = $request->base_unit_id;
                }else{
                    $unit->base_unit_id    = $unit->id;
                }
                $unit->save();
            //------------------------------

            $notification = array(
                    'message' => 'Successfully Unit updated!',
                    'alert-type' => 'success'
            );

            return redirect()->route('unit.index')->with($notification);

         }

    }

    public function destroy($id)
    {
        $unit = Unit::find($id);//->delete();
        $unit->deleted_at = date('Y-m-d h:i:s');
        $unit->save();
         $notification = array(
                    'message' => 'Successfully Unit deleted!',
                    'alert-type' => 'success'
            );

        return redirect()->route('unit.index')->with($notification);

    }


    
    public function unitPdfDownload(Request $request)
    {
        $input = $request->all();
         $allUnitId = [];
         if($request->unit_id == null)
         {
            $data['units'] = Unit::get();
         }
         else{
            if($input['unit_id'] != ''){
                foreach ($input['unit_id'] as $key => $value) {
                    array_push($allUnitId,$input['unit_id'][$key]);
                }
            }
            $data['units'] = Unit::whereIn('id',$allUnitId)->get();
        }
        $pdf = PDF::loadView('backend.units.pdf_download',$data);
        return $pdf->download('Unit List.pdf');
    }

}
