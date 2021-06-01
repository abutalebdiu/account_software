<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Auth;
use Validator;
use PDF;

use App\Model\Backend\Customer\Customer as BackendCustomer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['customers'] = Customer::where('customer_type',2)->get();
        return view('backend.customers.view',$data);
    }  


    public function walkindex()
    {
        $data['customers'] = Customer::where('customer_type',1)->get();
        return view('backend.customers.walkview',$data);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        return view('backend.customers.add');
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
            //'email' => 'required|unique:customers,email',
            'phone' => 'required|min:6|max:15',
        ]);


        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customercount  = Customer::where('customer_type',2)->count();
        $customerid     = Customer::orderBy('id','DESC')->where('customer_type',2)->first();

        $customer =  New customer();

        if($customercount>0)
        {
            $customer->id_no        = $customerid->id_no+1;
        }
        else{
            $customer->id_no = '1001';
        }

        $customer->name         = $request->name;
        $customer->email        = $request->email ;
        $customer->phone        = $request->phone;
        $customer->phone_2      = $request->phone_2;
        $customer->address      = $request->address ;
        $customer->notes        = $request->notes;
        $customer->previous_due = $request->previous_due;
        $customer->previous_due_date = $request->previous_due_date;
        $customer->customer_type  = $request->customer_type;
        $customer->verified     =  1;
        $customer->is_admin     =  Auth::user()->id;
        $customer->save();

        $notification = array(
                    'message' => 'Successfully customer added!',
                    'alert-type' => 'success'
        );

        return redirect()->route('customer.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['customer'] = Customer::find($id);
        return view('backend.customers.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['customer'] = Customer::find($id);
        return view('backend.customers.edit',$data);
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
        $customer =   Customer::find($id);
        $customer->name         = $request->name;
        $customer->email        = $request->email ;
        $customer->phone        = $request->phone;
        $customer->phone_2      = $request->phone_2;
        $customer->address      = $request->address ;
        $customer->notes        = $request->notes;
        $customer->previous_due = $request->previous_due;
        $customer->previous_due_date = $request->previous_due_date;
        $customer->customer_type  = $request->customer_type;
        $customer->save();


        $notification = array(
                    'message' => 'Successfully Customer Update!',
                    'alert-type' => 'success'
            );

        return redirect()->route('customer.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer =   Customer::find($id);
        $customer->deleted_at = date('Y-m-d');
        $customer->save();
        //$customer->delete();
        $notification = array(
                    'message' => 'Successfully Customer Deleted!',
                    'alert-type' => 'success'
            );
        return redirect()->route('customer.index')->with($notification);
    }



    public function customerexport(Request $request)
    {
        $input = $request->all();
        $allcustomer = [];
        if($request->customerid == null)
        {
            $data['allcustomers'] = Customer::where('customer_type',2)->get();
            $data['totaldue'] = Customer::sum('previous_due')->where('customer_type',2);
        }
        else{
            if($input['customerid'] != ''){
                foreach ($input['customerid'] as $key => $value) {
                    array_push($allcustomer,$input['customerid'][$key]);
                }
            }

            $data['allcustomers'] = Customer::whereIn('id',$allcustomer)->get();
            $data['totaldue'] = Customer::whereIn('id',$allcustomer)->sum('previous_due');
        }
        //return view('backend.customers.pdfexport',$data);
        $pdf = PDF::loadView('backend.customers.pdfexport',$data);
        return $pdf->download('Customer.pdf');
    }








   


    //customer sale reports
    public function saleReport()
    {
        $data['customers'] = BackendCustomer::where('customer_type',2)->get();
        return view('backend.customers.sale_report',$data);
        /*
            $data =   SaleFinal::join('sale_details','sale_details.sale_final_id','=','sale_finals.id')
                ->select(
                DB::raw('SUM(CASE
                WHEN  sale_finals.discount_type = "percentageValue"
                    THEN sale_finals.discount_value *  (sale_details.quantity * sale_details.unit_price) / 100
                WHEN sale_finals.discount_type = "fixedValue"
                    THEN sale_finals.discount_value
                END) as subTotaldiscountAmount'),
                DB::raw('sum(sale_details.quantity*sale_details.unit_price) as subTotalAmount')
                )
                ->whereNull('sale_finals.deleted_at')
                ->whereNull('sale_details.deleted_at')
                ->where('sale_finals.customer_id',$this->id)
                ->where('sale_details.customer_id',$this->id)
                ->get();
        */
    }

    /**Customer Sale Reports */
    public function customerSaleReportexport(Request $request)
    {
        $input = $request->all();
        $allcustomer = [];
        if($request->customerid == null)
        {
            $data['allcustomers']   = Customer::where('customer_type',2)->get();
            $data['totaldue']       = Customer::sum('previous_due')->where('customer_type',2);
        }
        else{
            if($input['customerid'] != ''){
                foreach ($input['customerid'] as $key => $value) {
                    array_push($allcustomer,$input['customerid'][$key]);
                }
            }
            $data['customers'] = BackendCustomer::whereIn('id',$allcustomer)->get();
        }
        $pdf = PDF::loadView('backend.customers.sale_report_pdfexport',$data);
        return $pdf->download('Customer.pdf');
    }


    public function createCustomerByAjax(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'name'  => 'required|min:2|max:150',
            'customer_type'  => 'required',
            //'email' => 'unique:users,email,' . $userId,
            //'email' => 'required|unique:customers,email',
            'phone' => 'required|min:6|max:15',
        ]);


        if($validator->fails()){
            return response()->json([
                    'status' => 'errors',
                    'error'=> $validator->getMessageBag()->toArray()
                ]);
        }

        $query          = Customer::query();
        $customercount  = $query->count();
        $customerid     = $query->orderBy('id','DESC')->first();

        $customer =  New customer();

        if($customercount > 0)
        {
            $customer->id_no        = $customerid->id_no+1;
        }
        else{
            $customer->id_no = '1001';
        }

        $customer->name                 = $request->name;
        $customer->email                = $request->email ;
        $customer->phone                = $request->phone;
        $customer->address              = $request->address ;
        $customer->notes                = $request->notes;
        $customer->previous_due         = $request->previous_due;
        $customer->previous_due_date    = $request->previous_due_date;
        $customer->customer_type        = $request->customer_type; 
        //$customer->nid_no               = $request->nid_no;
        //$customer->birth_date           = $request->birth_date;
        //$customer->anniversary_date     = $request->anniversary_date;
        //$customer->company_name         = $request->company_name;
        //$customer->shipping_address     = $request->shipping_address;
        //$customer->anniversary_date     = $request->anniversary_date;
        $customer->verified             = 1;
        $customer->is_admin             = Auth::user()->id;
        $data = $customer->save();



        //$customers = [];
        //$customers = customer::latest()->get();

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
                'data_id'  =>  $customer->id
                //'data'  => $html
            ]);
        }else{
            return response()->json([
                'status' => false
            ]);
        }
    }


}
