<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model{
    protected $table ="regions";
    protected $hidden = ["id"];
    protected $fillable = ['name'];
    public $timestamps = false;

    public function cities(){
        return $this->hasMany('App\City','region_id','id')->select("name");
    }
}
