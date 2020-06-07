<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    protected $table = "breeds";
    public $timestamps = false;
    
    public function animal(){
        return $this->belongsTo("App\Models\Animal", "BRED_ANML_ID", "id");
    }
}
