<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = "user_types";
    public $timestamps = false;

    public function users(){
        return $this->hasMany("App\Models\Users", 'USER_TYPE_ID', 'id');
    }
}
