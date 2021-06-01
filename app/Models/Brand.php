<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Brand extends Model
{
    public function author(){
        return $this->belongsTo(User::class,'user_id');
    }
}
