<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function parentUnitName()
    {
        if($this->parent_id > 0)
        {
            $unit = Unit::find($this->parent_id);
            return $unit?$unit->short_name:NULL;
        }else{
            return $this->short_name;
        }
    }
}
