<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    
    use HasApiTokens;
    
    protected $table="users";
    protected $guarded = [];

    protected $hidden = ["password","post_limit","next_post_date","last_active","joined","location","phone","ip_address","city_id","remember_token"];
    
    const CREATED_AT = "joined";
    const UPDATED_AT = "last_active";


    public function products(){
        return $this->hasManyThrough('App\Product','App\Store');
    }

    public function city(){
        return $this->belongsTo('App\City','city_id','id');
    }

    public function store(){
        return $this->hasOne('App\Store','user_id','id');
    }
}
