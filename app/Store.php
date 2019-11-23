<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model{

    protected $table ="stores";
    protected $hidden = ["user_id","description","created_at","url"];
    protected $guarded = [];
    public $timestamps = false;

    public function owner(){
        return $this->belongsTo('App\User','user_id','id')->select(['id','name','phone']);
    }

    public function products(){
        return $this->hasMany('App\Product','store_id','id');
    }

    public function orders(){
        return $this->hasManyThrough('App\Order','App\Product','store_id','product_id','id','id')
        ->select(["products.name as product_name","orders.placed_on","orders.status","orders.amount","orders.id"])
        ->where("orders.status","<>","unapproved")
        ->orderByRaw("orders.status = 'pending' desc, orders.status <> 'delivered' desc, orders.placed_on asc");
    }
}
