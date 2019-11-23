<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model{

    protected $table = "sponsored_products";
    public $timestamps = false;
    protected $hidden = ['id','product_id'];
    protected $guarded = ['id','product_id'];

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
