<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shops extends Model
{
    protected $table = "shops";

    public function city(){
        return $this->belongsTo("App\Models\City", "SHOP_CITY_ID", "id");
    }


}
