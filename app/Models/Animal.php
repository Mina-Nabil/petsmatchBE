<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    protected $table = "animals";
    public $timestamps = false;
    
    public function breeds(){
        return $this->hasMany("App\Models\Breed", "BRED_ANML_ID", "id");
    }
}
