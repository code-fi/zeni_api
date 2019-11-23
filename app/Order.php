<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    protected $table="orders";
    protected $hidden = ["customer_remarks","product_id","payment_method"];
    protected $guarded = [];
    public $timestamps = false;

    public function product(){
        return $this->belongsTo('App\Product','product_id','id')->select(["id","name"]);
    }

    // public function customer(){
    //     return $this->hasOne('App\Customer','customer_id','id');
    // }
}
