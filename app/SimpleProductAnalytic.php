<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class SimpleProductAnalytic extends Model{

    protected $table="simple_product_analytics";
    protected $hidden=['id','product_id','created_at'];
    protected $guarded = ['id','product_id'];


    public function product(){
        return $this->belongsTo('App\Product');
    }
}
