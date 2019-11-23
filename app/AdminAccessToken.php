<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class AdminAccessToken extends Model{
    protected $table = "admin_access_token";
    protected $guarded = ["id","admin_id"];

    public $timestamps = false;
    protected $hidden = ["id"];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}