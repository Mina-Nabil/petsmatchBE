<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $table = "trainers";
    public $timestamps = false;

    public function user(){
        return $this->belongsTo("App\Models\User", "TRNR_USER_ID", 'id');
    }

}
