<?php

namespace App\Model\Backend\Sale;

use Illuminate\Database\Eloquent\Model;
use App\Model\Backend\Product\Product;

class SaleReturnDetail extends Model
{
    

	public function product()
	{
		return $this->belongsTo(Product::class,'product_id');
	}

}
