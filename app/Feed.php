<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model{
    protected $table ="blog_post";
    protected $hidden = ["id"];
    protected $guarded = ['id'];
    public $timestamps = false;
}
