<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vets extends Model
{
    protected $table = "vets";

    public function city(){
        return $this->belongsTo("App\Models\City", "VETS_CITY_ID", "id");
    }


}
