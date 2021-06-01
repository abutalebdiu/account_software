<?php

namespace App\Model\Backend\Stock;

use App\User;
use App\Models\BusinessType;
use App\Model\Backend\Stock\Stock;
use App\Model\Backend\Stock\StockType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Backend\Product\ProductVariation;
use App\Model\Backend\Business\BusinessLocation;

class StockTransferHistory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "business_location_id",
        "business_type_id",
        "from_stock_type_id",
        "from_stock_id",
        "from_product_id",
        "from_product_variation_id",
        "transfer_quantity",
        "to_stock_type_id",
        "to_stock_id",
        "to_product_id",
        "to_product_variation_id",
        "receive_quantity",
        "transfer_by",
        "receive_by",
        "receive_at",
        "status",
        "is_active",
        "is_verified",
        "created_by",
    ];

    public function businessLocation()
    {
        return $this->belongsTo(BusinessLocation::class);
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, "created_by");
    }

    public function isActive()
    {
        return $this->is_active == 1;
    }

    public function isVerified()
    {
        return $this->is_verified == 1;
    }




    public function fromStockType()
    {
        return $this->belongsTo(StockType::class, "from_stock_type_id");
    }

    public function toStockType()
    {
        return $this->belongsTo(StockType::class, "to_stock_type_id");
    }

    public function fromStock()
    {
        return $this->belongsTo(Stock::class, "from_stock_id");
    }

    public function toStock()
    {
        return $this->belongsTo(Stock::class, "to_stock_id");
    }




    public function fromProductVariation()
    {
        return $this->belongsTo(ProductVariation::class, "from_product_variation_id");
    }

    public function fromProduct()
    {
        return $this->belongsTo(ProductVariation::class, "from_product_id");
    }

    public function toProductVariation()
    {
        return $this->belongsTo(ProductVariation::class, "to_product_variation_id");
    }

    public function toProduct()
    {
        return $this->belongsTo(ProductVariation::class, "to_product_id");
    }




    public function transferBy()
    {
        return $this->belongsTo(User::class, "transfer_by");
    }

    public function receiveBy()
    {
        return $this->belongsTo(User::class, "receive_by");
    }
}
