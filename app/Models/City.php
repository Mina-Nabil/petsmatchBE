<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;
    public $table = "cities";

    public function country(){
        return $this->belongsTo("App\Models\Country", "CITY_CNTR_ID", "id");
    }
}
