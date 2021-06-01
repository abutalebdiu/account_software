<?php

namespace App\Http\Controllers\Backend\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Backend\Payment\AccountPaymentHistory;
use App\Model\Backend\Payment\AccountPaymentHistoryDetail;

class AccountPaymentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function paymentAccountReport()
    {
        $data['payments']     =   AccountPaymentHistory::whereNull('deleted_at')->latest()->get();
        return view('backend.account.report_cash_flow.report',$data);
    }


    public function paymentAccountCashFlow()
    {
        $data['payments']     =   AccountPaymentHistory::whereNull('deleted_at')->latest()->get();
        return view('backend.account.report_cash_flow.cash_flow',$data);
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
