<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Model\Backend\Product\ProductVariation;
use App\Model\Backend\Product\Product;
use App\Model\Backend\Unit\Unit;

use App\Model\Backend\Sale\SaleDetail;
use App\Model\Backend\Sale\SaleWarrantyGuarantee;
use App\Model\Backend\Sale\SaleReturnDetail;

use App\Model\Backend\Customer\Customer;
use DB;
use App\User;
use App\Models\Damage;
use App\Model\Backend\Purchase\PurchaseFinal;
use App\Model\Backend\Purchase\PurchaseDetail;
use App\Model\Backend\Purchase\PurchaseFinalAdditionalNote;
use App\Model\Backend\Purchase\PurchaseShippingAddress;

use App\Model\Backend\Payment\AccountPaymentHistory;
use App\Model\Backend\Payment\AccountPaymentHistoryDetail;
use App\Backend\Reference;

class ReportController extends Controller
{
    


	public function dailysummery(Request $request)
	{


		$purchasequery = AccountPaymentHistory::query();
		$salesequery = AccountPaymentHistory::query();
		$damagequery   = Damage::query();

		if($request->date_search)
		{
			$data['date_search']  = $request->date_search;
			$purchasequery        = $purchasequery->whereDate('created_at',Date('Y-m-d',strtotime($request->date_search)));
			$salesequery 	      = $salesequery->whereDate('created_at',Date('Y-m-d',strtotime($request->date_search)));
			$damagequery          = $damagequery->whereDate('created_at',Date('Y-m-d',strtotime($request->date_search)));
		}	
		else{
			$data['date_search']= Date('Y-m-d');
			$purchasequery 		= $purchasequery->whereDate('created_at',Date('Y-m-d'));
			$salesequery 		= $salesequery->whereDate('created_at',Date('Y-m-d'));
			$damagequery   		= $damagequery->whereDate('created_at',Date('Y-m-d'));
		}



		//		purchases history 
		$data['purchases'] 	= $purchasequery->where('module_id',1)
	                                        ->whereNull('deleted_at')
	                                        ->orderBy('id','DESC')
	                                        ->get();

	    //		Sales history 
	    $data['sales'] 		= $salesequery->where('module_id',2)
	                                        ->whereNull('deleted_at')
	                                        ->orderBy('id','DESC')
	                                        ->get();

	    //		damage history 
		$data['damages']  = $damagequery->orderBy('id','DESC')
                                           ->get();

	 
 

		return view('backend.reports.dailysummery',$data);
	}






	public function purchase_sales_report()
	{


		return view('backend.reports.purchase_sales_report');
	}














}
