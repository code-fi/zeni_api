<?php

namespace App\Events;
// use App\SimpleProductAnalytic;
// use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ProductViewedCall
{
     use Dispatchable;//, //SerializesModels;

     public $product_analytic;

     public function __construct($data){
         $this->product_analytic = $data;
     }
}