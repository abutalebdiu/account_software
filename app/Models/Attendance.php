<?php

namespace App\Models;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    
    Protected $table = "attendance";
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    
}
