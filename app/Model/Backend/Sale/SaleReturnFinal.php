<?php

namespace App\Model\Backend\Sale;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Backend\Sale\SaleFinal;
use App\User;

class SaleReturnFinal extends Model
{

	public function customer()
	{
		return $this->belongsTo(Customer::class,'customer_id');
	}

	public function createdBy()
	{
		return $this->belongsTo(User::class,'created_by');
	}




	public function salereturndetail()
	{
		return $this->hasMany(SaleReturnDetail::class,'sale_return_final_id');
	}




}
