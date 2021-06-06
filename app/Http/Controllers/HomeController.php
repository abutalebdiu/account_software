<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Product;
use App\Model\Backend\Stock\MainStock;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['customer1']  = Customer::where('customer_type',1)->count();
        $data['allusers']   = User::count();
        $data['customers']  = Customer::where('customer_type',2)->count();
        $data['suppliers']  = Supplier::count();
        $data['totalproducts']= Product::count();

        $data['supplierLowQtys']= MainStock::join('products','products.id','=','main_stocks.product_id')
                                ->select('products.supplier_id',
                                    'main_stocks.available_stock as available_stock',
                                    DB::raw('COUNT(main_stocks.id) as total')
                                )
                                ->where('main_stocks.available_stock','<',0)
                                ->groupBy('products.supplier_id')
                                ->get();

     
                                            
        return view('backend.dashboard.home',$data);
    }
}
