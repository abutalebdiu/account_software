<?php

namespace App\Model\Backend\Transaction;

use App\User;
use App\Models\BusinessType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Backend\Business\BusinessLocation;

class TransactionType extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "business_location_id",
        "business_type_id",
        "name",
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
    public function transactionCategories()
    {
        return $this->hasMany(TransactionCategory::class);
    }
}
