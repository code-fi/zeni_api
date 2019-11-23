<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model{
    protected $table="reviews";
    protected $hidden=['id','product_id'];
    protected $guarded = [];
}
