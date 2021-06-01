<?php

namespace App\Model\Backend\Transaction;

use App\User;
use App\Models\BusinessType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Backend\Business\BusinessLocation;

class TransactionFinal extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "business_location_id",
        "business_type_id",
        "transaction_type_id",
        "transaction_category_id",
        "reference_no",
        "transaction_date",
        "others_cost",
        "discount_type",
        "discount_value",
        "discount_amount",
        "transaction_note",
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


    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }
    public function transactionCategory()
    {
        return $this->belongsTo(TransactionCategory::class);
    }
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    public function transactionAmount()
    {
        return $this->hasMany(TransactionDetail::class)->whereNull('deleted_at')->sum('sub_total');
    }
}
