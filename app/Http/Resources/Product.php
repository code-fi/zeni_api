<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image_url = count($this->defaultImage)>0 ? $this->defaultImage[0]['path'] :"";
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'publisher'=>$this->shop->name,
            'price'=>$this->price,
            'image_url'=>$image_url
        ];
    }
}
