<?php

namespace App\Events;

// use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ProductAddedCall
{
     use Dispatchable;// SerializesModels;

     public $data;

     public function __construct($data){
         $this->data = $data;
     }
}