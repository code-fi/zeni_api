<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $table = "products";
    protected $hidden = ["added_on","expires_on","user_id","category_id","description","extras","slug","status"];
    protected $guarded = [];

    protected $casts= [
        "extras"=>"array"
    ];
    
    public $timestamps = false;


    public function images(){
        return $this->hasMany('App\ProductImage','product_id','id');
    }

    public function category(){
        return $this->belongsTo('App\ProductCategory','category_id','id')->select(['id','name']);
    }

    public function orders(){
        return $this->hasMany('App\Order',"product_id","id");
    }
    public function reviews(){
        return $this->hasMany('App\Review','product_id','id');
    }

    public function shop(){
        return $this->belongsTo('App\Store','store_id','id')->select(['id','name']);
    }

    public function defaultImage(){
        return $this->images()->where('default',1);
    }

    public function sponsorship(){
        return $this->hasOne('App\Sponsorship','product_id','id');
    }

    public function simple_analytics(){
        return $this->hasOne('App\SimpleProductAnalytic');
    }
    // public function reviewsCount(){
    //     return $this->reviews()->selectRaw('product_id, count(*) as reviews');
    // }
}
