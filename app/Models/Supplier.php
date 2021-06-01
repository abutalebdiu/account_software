<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Model\Backend\Purchase\PurchaseFinal;
use App\Model\Backend\Purchase\PurchaseDetail;
use App\Model\Backend\Payment\AccountPaymentHistory;
use App\Model\Backend\Payment\AccountPaymentHistoryDetail;
use DB;
class Supplier extends Model
{
    Protected $table = 'suppliers';

    public function author()
    {
        return $this->belongsTo(User::class,'is_admin');
    }



    public function totalOrderInvoice()
    {
        return PurchaseFinal::whereNull('deleted_at')
                        ->where('supplier_id',$this->id)
                        ->count();
    }

    public function totalOrderQuantity()
    {
        return PurchaseDetail::whereNull('deleted_at')
                        ->where('supplier_id',$this->id)
                        ->count();
    }

    public function totalPurchaseFinals()
    {
        return $this->hasMany(PurchaseFinal::class,'supplier_id','id')->whereNull('deleted_at');
    }
    public function totalPurchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class,'supplier_id','id')->whereNull('deleted_at');
    }

    /***********Payment history************/
    public function paymentAmount()
    {

       $data = AccountPaymentHistory::whereNull('deleted_at')
                   //'deleted_at','payment_type_id','payment_amount','module_id','client_supplier_id',
                   ->select(
                   DB::raw('SUM(CASE
                   WHEN payment_type_id = 1
                       THEN payment_amount
                   END) as income'),
                   DB::raw('SUM(CASE
                   WHEN payment_type_id = 2
                       THEN payment_amount
                   END) as expense')
                   )
                   ->where('module_id',module_HH()['purchase'])
                   ->where('client_supplier_id',$this->id)
                   ->get();
       $totalIncome    = $data->sum('income');
       $totalExpenese  = $data->sum('expense');
       return number_format($totalExpenese - $totalIncome,2,'.','') ;
    }
/*********** Payment history************/

}
