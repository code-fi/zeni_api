<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleProduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $d = $this->defaultImage;
        $path = count($d)>0 ? $d[0]['path'] : "";
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'status'=>$this->status,
            'price'=>$this->price,
            'image_url'=>$path
        ];
    }
}
// 2774 chickering road pensacola fl 32514