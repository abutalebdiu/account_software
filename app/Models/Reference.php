<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Reference extends Model
{
    Protected $table = "references";

    public function author(){
        return $this->belongsTo(User::class,'created_by');
    }

}
