<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'USER_NAME', 'USER_MOBN', 'USER_PASS', 'USER_FLNM', 'USER_CITY_ID', 'USER_BRDT', 'USER_TYPE_ID', 'USER_IMGE', 'USER_HOME_LATT', 'USER_HOME_LONG', 'USER_CHAT_TOKN', 'USER_PUSH_TOKN'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'USER_BRDT' => 'datetime',
    ];

    protected $table = "users";

    public function city(){
        return $this->belongsTo('App\Models\City', "USER_CITY_ID", 'id');
    }

    public function type(){
        return $this->belongsTo('App\Models\UserType', "USER_USTP_ID", 'id');
    }

    public function trainer(){
        return $this->hasOne("App\Models\Trainer", "TRNR_USER_ID", "id");
    }
}
