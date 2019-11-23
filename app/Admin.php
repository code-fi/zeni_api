<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable{

    protected $table="admins";
    public $timestamps = false;

    protected $guarded = [];
    protected $hidden = ["password","remember_token"];


    public function access_tokens(){
        return $this->hasMany(AdminAccessToken::class);
    }
}
