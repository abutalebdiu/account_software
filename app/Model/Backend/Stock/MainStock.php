<?php

namespace App\Model\Backend\Stock;
use App\Model\Backend\Supplier;
use Illuminate\Database\Eloquent\Model;
use App\Model\Product\Product;
use App\Model\Backend\Product\ProductVariation;
class MainStock extends Model
{

    public function productVariations()
    {
        return $this->belongsTo(ProductVariation::class,'product_variation_id','id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    
    public function suppliers($supplier_id)
    {
        $data = Supplier::findOrFail($supplier_id);
        return $data?$data->name:NULL;
    }

}
