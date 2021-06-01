<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    public function product()
    {
    	return $this->belongsTo(Product::class,'product_id');
    }


    public function supplier()
    {
    	return $this->belongsTo(Supplier::class,'supplier_id');
    }


}
