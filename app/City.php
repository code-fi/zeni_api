<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model{
    protected $table="cities";
    protected $hidden = ["region_id"];
    protected $fillable = ['name'];
    public $timestamps = false;

    public function region (){
        return $this->belongsTo('App\Region','region_id','id');
    }

    public function stores(){
        return $this->hasMany('App\Store','App\User','city_id','user_id','id','id')->select(['id','name']);
    }
}
