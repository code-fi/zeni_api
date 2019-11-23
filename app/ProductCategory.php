<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model{
    //
    protected $table= "product_categories";
    protected $guarded = ['id'];
    protected $hidden = ['parent_id'];
    public $timestamps = false;

    public function products(){
        return $this->hasMany('App\Product','category_id','id')->select(['id','name','price','rating'])
        ->where('status','verified');
    }
}
