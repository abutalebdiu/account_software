<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Category extends Model
{
    public function author(){
        return $this->belongsTo(User::class,'user_id');
    }
}
