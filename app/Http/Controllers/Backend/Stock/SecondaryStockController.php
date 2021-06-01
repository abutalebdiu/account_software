<?php

namespace App\Http\Controllers\Backend\Stock;

use App\Http\Controllers\Controller;
use App\Model\Backend\Stock\PrimaryStock;
use Illuminate\Http\Request;
use App\Model\Backend\Stock\SecondaryStock;
use App\Model\Backend\Stock\Stock;
use PDF;
class SecondaryStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) // have to work
    {
        $data['stockTypies'] = Stock::whereNull('deleted_at')->where('stock_type_id', 3)->get();
        if ($request->stock_id) {
            $stock_id[] = $request->stock_id;
        } else {
            $stock_id = Stock::whereNull('deleted_at')->where('stock_type_id', 3)->get()->pluck("id")->all();
        }
        $data['stock_id'] = $stock_id[0];
        $data['stocks'] =  SecondaryStock::whereNull('deleted_at')
            ->whereIn('stock_id', $stock_id)
            ->where('stock_type_id', 3)
            ->latest()
            ->get();
        //->where('company_id',1)
        //->where('stock_type_id',1)
        //->where('stock_type_id',1)
        return view('backend.stock.secondary_stock.index', $data);
    }


    
    

    public function seconday_stock_pdf_list(Request $request)
    {
        $input = $request->all();
        $allStockId = [];
        if($request->stock_id == null)
        {
           $data['stocks'] = SecondaryStock::where('status',1)->whereNull('deleted_at')->get();;
        }
        else{
           if($input['stock_id'] != ''){
               foreach ($input['stock_id'] as $key => $value) {
                   array_push($allStockId,$input['stock_id'][$key]);
               }
           }
           $data['stocks'] = SecondaryStock::whereIn('id',$allStockId)->get();
       }
       $pdf = PDF::loadView('backend.stock.secondary_stock.pdf_export',$data);
       return $pdf->download('Godwon Stock List.pdf');
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
        //
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
