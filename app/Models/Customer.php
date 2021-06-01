<?php

namespace App\Models;
use App\User;
use App\Model\Backend\Sale\SaleDetail;
use App\Model\Backend\Sale\SaleFinal;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';


    public function author(){
        return $this->belongsTo(User::class,'is_admin');
    }


    public function totalSaleFinals()
    {
        return $this->hasMany(SaleFinal::class,'customer_id','id')->whereNull('deleted_at');
    }
    public function totalSaleDetails()
    {
        return $this->hasMany(SaleDetail::class,'customer_id','id')->whereNull('deleted_at');
    }

}
