<?php

namespace App\Model\Backend\Stock;

use App\Model\Backend\Stock\Stock;
use App\Model\Backend\Product\Product;
use Illuminate\Database\Eloquent\Model;
use App\Model\Backend\Product\ProductVariation;

class PrimaryStock extends Model
{
    public function productVariations()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function stocks()
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }
    public function stockType()
    {
        return $this->belongsTo(StockType::class, 'stock_type_id', 'id');
    }
}
