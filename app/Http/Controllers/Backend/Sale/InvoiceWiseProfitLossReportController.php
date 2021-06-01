<?php

namespace App\Http\Controllers\Backend\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Backend\Sale\SaleFinal;
use App\Model\Backend\Sale\SaleDetail;
class InvoiceWiseProfitLossReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function invoiceWiseProfitLoss(Request $request)
    {
        $data['saleFinal'] = SaleFinal::findOrfail($request->id);
        return view('backend.sale_pos.profit_loss.profit_loss_modal',$data);
    }


    public function quotationInvoiceWiseProfitLoss(Request $request)
    {
        $data['saleFinal'] = SaleFinal::findOrfail($request->id);
        return view('backend.quotation.profit_loss_modal',$data);
    }



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
