<?php

namespace App\Models;
use App\User;
use App\Models\Category;
use App\Models\Customer;
use App\Model\Backend\Unit\Unit;
use App\Model\Backend\Supplier;
use Illuminate\Database\Eloquent\Model;
use App\Model\Backend\Product\ProductVariation;
use App\Model\Backend\Product\ProductGradeType;
use App\Models\Brand;
use App\Model\Backend\Stock\MainStock;

class Product extends Model
{
    public function author(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function productVariations()
    {
        return $this->hasOne(ProductVariation::class,'product_id','id')->whereNull('deleted_at');
    }

     
    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    
    
    
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    } 


    public function purchaseUnit()
    {
        return $this->belongsTo(Unit::class, "purchase_unit_id");
    }    
    public function group()
    {
        return $this->belongsTo(Group::class, "group_id",'id');
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class, "brand_id",'id');
    }


    public function grades()
    {
        return $this->belongsTo(ProductGradeType::class,'grade_type_id','id');
    }

    public function mainStocks()
    {
        return $this->hasOne(MainStock::class,'product_id','id');
    }
}
