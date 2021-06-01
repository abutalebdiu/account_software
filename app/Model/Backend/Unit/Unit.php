<?php

namespace App\Model\Backend\Unit;

use Illuminate\Database\Eloquent\Model;
use App\Model\Backend\Unit\Unit;
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
