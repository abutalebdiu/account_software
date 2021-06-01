<?php

namespace App\Http\Controllers\Backend\ReceivedPurchaseProduct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Backend\Supplier;
use DB;
use Validator;
use Auth;
use App\Model\Backend\Stock\MainStock;
use App\Model\Backend\Purchase\PurchaseFinal;
use App\Model\Backend\Purchase\PurchaseDetail;
use App\Model\Backend\PurchaseProductReceiveHistory\PurchaseProductReceiveHistory;
class ReceivedPurchaseProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.receive_purchase_product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['suppliers'] = Supplier::get();
        return view('backend.receive_purchase_product.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');
        $validator = Validator::make($input,[
            'supplier_id' => 'required',
            'chalan_no' => 'nullable|max:150',
            'reference_no' => 'nullable|max:150',
            'invoice_no' => 'required|max:150',
            'received_from' => 'required|max:150',
            //'business_location_id' => 'required',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $chalan_no          = $request->chalan_no;
        $reference_no       = $request->reference_no;
        $invoice_no         = $request->invoice_no;
        $supplier_id        = $request->supplier_id;
        $purchase_final_id  = $request->purchase_final_id;
        $purchaseFnl = PurchaseFinal::where('id',$purchase_final_id)
                                    ->whereNull('deleted_at')
                                    ->first();
        $supplier_id = $request->supplier_id;
        $business_location_id = 1;// $request->business_location_id;
        // Start transaction!
        DB::beginTransaction();
        try
        {
            foreach ($request->receiving_quantity as $key => $received_quantity) 
            {
                if(!$received_quantity || $received_quantity == 0)continue;
                $this->insertReceivingPurchaseProduct($purchaseFnl,$received_quantity,$key , $request);
            }
            DB::commit();
            session(['receiveProductPurchaseCart' => []]);
            return redirect()->route('admin.purchase.index')->with([
                'alert-type' => 'success',
                'message' => 'Receiving Purchase Product Successful!'
            ]);
            //return redirect()->route('admin.purchase.index')->with('success','Receiving Purchase Product Successful!');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            if($e->getMessage())
            {
                $message = $e->getMessage();//"Something went wrong! Please Try again";
            }
            return Redirect()->back()
                ->with('error',$message);
        }
    }


    public function insertReceivingPurchaseProduct($purchaseFnl,$received_quantity,$key , $request)
    {
        $receive = new PurchaseProductReceiveHistory();
        $receive->purchase_final_id         = $purchaseFnl?$purchaseFnl->id:NULL;
        $receive->business_location_id      = $purchaseFnl?$purchaseFnl->business_location_id:NULL;
        $receive->business_type_id          = $purchaseFnl?$purchaseFnl->business_type_id:NULL;
        $receive->reference_no              = $purchaseFnl?$purchaseFnl->reference_no:NULL;
        $receive->invoice_no                = $request->invoice_no;
        $receive->chalan_no                 = $purchaseFnl?$purchaseFnl->chalan_no:NULL;

        $receive->supplier_id               = $request->supplier_id;

        //$receive->purchase_detail_id        = $request->purchase_detail_id[$key];
        $receive->product_variation_id      = $request->product_variation_id[$key];
        $receive->product_id                = $request->product_id[$key];
        $receive->received_quantity         = $received_quantity;
        $receive->received_by               = Auth::user()->id;
        $receive->received_at               = date('Y-m-d h:i:s');
        $receive->received_from             = $request->received_from;
        $receive->received_invo_cln_ref_no  = $request->received_invo_cln_ref_no;
        $receive->receiving_period          = 2;//1 = instant , 2== litter
        $receive->save();

        $this->insertStockOfThisProductByPruchaseDetailsId($receive->purchase_final_id,$request->product_variation_id[$key],$received_quantity);

        return $receive;
    }

  
    public function insertStockOfThisProductByPruchaseDetailsId($purchase_final_id,$product_variation_id,$received_quantity)
    {
        $purchase = PurchaseDetail::where('product_variation_id',$product_variation_id)
                                    ->where('purchase_final_id',$purchase_final_id)
                                    ->whereNull('deleted_at')
                                    ->first();
        if($purchase)
        {
            increasingStockPurchase_HH($purchase->stock_type_id,$purchase->stock_id,
                                $purchase->product_id,$purchase->product_variation_id,
                                $received_quantity,$purchase->business_location_id,
                                $purchase->default_purchase_unit_id
                            ); 
        }
        return 1;
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
