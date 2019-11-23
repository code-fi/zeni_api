<?php

namespace App\Events;

// use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ProcessProductImagesCall
{
     use Dispatchable;

     public $product_id;
     public $images;

     public function __construct($product_id,$images){
         $this->images = $images;
         $this->product_id = $product_id;
     }
}