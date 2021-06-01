<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Damage;
use PDF;
use App\Model\Backend\Payment\AccountPaymentHistory;
use App\Model\Backend\Payment\AccountPaymentHistoryDetail;
use Validator;
use App\Models\Product;
use App\Model\Backend\Purchase\PurchaseFinal;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['suppliers'] = Supplier::orderBy('uid','ASC')->get();
        return view('backend.suppliers.view',$data); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('backend.suppliers.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        $validator = Validator::make($request->all(), [
            'uid'         => 'required|unique:suppliers',
            'phone'       => 'required',
            'name'        => 'required',
            'previous_due'=> 'required',
            'address'     => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{

            $supplier =  New Supplier();
            $supplier->uid    = $request->uid;
            $supplier->name   = $request->name;
            $supplier->phone  =$request->phone;
            $supplier->email  =$request->email ;
            $supplier->contract_person   =$request->contract_person ;
            $supplier->previous_due   =$request->previous_due ;
            $supplier->address=$request->address ;
            $supplier->description   =$request->description ;
            $supplier->code_sequence  =$request->code_sequence ;
    
            $supplier->save();
        }

         $notification = array(
                    'message' => 'Successfully Supplier added!',
                    'alert-type' => 'success'
            );

        return redirect()->route('supplier.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['supplier'] = Supplier::find($id);
        return view('backend.suppliers.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['supplier'] = Supplier::find($id);
        return view('backend.suppliers.edit',$data);
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
        
          $validator = Validator::make($request->all(), [
            'uid'         => 'required',
            'phone'       => 'required',
            'name'        => 'required',
            'previous_due'=> 'required',
            'address'     => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        else{
            
            $supplier =   Supplier::find($id);
            $supplier->uid = $request->uid;
            $supplier->name = $request->name;
            $supplier->phone  =$request->phone;
            $supplier->email   =$request->email ;
            $supplier->contract_person   =$request->contract_person ;
            $supplier->previous_due   =$request->previous_due ;
            $supplier->address   =$request->address ;
            $supplier->description   =$request->description ;
            $supplier->code_sequence =$request->code_sequence ;
    
            $supplier->save();
        
        }


         $notification = array(
                    'message' => 'Successfully Supplier added!',
                    'alert-type' => 'success'
            );

        return redirect()->route('supplier.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
        
        
        $findproduct  = Product::where('supplier_id',$id)->count();
        
        $findpurchase = PurchaseFinal::where('supplier_id',$id)->count();
        
        
        if($findproduct>0  || $findpurchase>0 )
        {
            
             $notification = array(
                    'message' => 'Sorry! You can not delete this supplier',
                    'alert-type' => 'error'
            );

        return redirect()->route('supplier.index')->with($notification);
            
        }
        else{
            $data = Supplier::find($id)->delete();
              
              
            $notification = array(
                    'message' => 'Successfully Supplier Deleted!',
                    'alert-type' => 'success'
            );

             return redirect()->route('supplier.index')->with($notification);
              
        }
        
        
        
        
    }


    /**supplier list export */
    public function supplierListExport(Request $request)
    {
        $input = $request->all();
        $allSuppliers = [];
        if($request->supplier_id == null)
        {
            $data['suppliers'] = Supplier::orderBy('uid','ASC')->get();
        }
        else{
           if($input['supplier_id'] != ''){
               foreach ($input['supplier_id'] as $key => $value) {
                   array_push($allSuppliers,$input['supplier_id'][$key]);
               }
           }
           $data['suppliers'] = Supplier::whereIn('id',$allSuppliers)->orderBy('uid','ASC')->get();
       }
       $pdf = PDF::loadView('backend.suppliers.supplier_list_pdfexport',$data);
       return $pdf->download('supplier list.pdf');
    }


    public function supplierPurchaseReport(Request $request)
    {
        $data['suppliers'] = Supplier::all();
        return view('backend.suppliers.purchase_report',$data); 
    }
    public function supplierPurchaseReportexport(Request $request)
    {
        $input = $request->all();
        $allSuppliers = [];
        if($request->supplier_id == null)
        {
            $data['suppliers'] = Supplier::orderBy('uid','ASC')->get();
        }
        else{
           if($input['supplier_id'] != ''){
               foreach ($input['supplier_id'] as $key => $value) {
                   array_push($allSuppliers,$input['supplier_id'][$key]);
               }
           }
           $data['suppliers'] = Supplier::whereIn('id',$allSuppliers)->orderBy('uid','ASC')->get();
       }
       $pdf = PDF::loadView('backend.suppliers.purchase_report_pdfexport',$data);
       return $pdf->download('supplier list.pdf');
    }
    
    
    
    
    
    
    
    
    /*for demand order */
    
    public function demandorder()
    {
        return view('backend.suppliers.demandorder');
    }
    
    
    
    
     /*for demand order */
    
    public function damage($id)
    {
        $data['damages'] = Damage::where('supplier_id',$id)->get();
        return view('backend.suppliers.damage',$data);
       
    }
    
    
    
    
    
     
     /*for demand order */
    
    public function paymenthistory($id)
    {
        
        $data['payments']     =   AccountPaymentHistory::where('client_supplier_id',$id)
                                        ->where('module_id',1)
                                        ->whereNull('deleted_at')
                                        ->orderBy('id','DESC')
                                        ->get();
        
        return view('backend.suppliers.paymenthistory',$data);
    }
    
    
    
 









  
}
