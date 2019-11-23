<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Feed extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        $dateTime = \Carbon\Carbon::parse($this->published_on)->diffForHumans();
        return [
        "url"=>$this->url,
        "title"=>$this->title,
        "image_url"=>$this->image_url,
        "published_on"=>$dateTime,
        "category"=>$this->category,
        "post_type"=>$this->post_type,
        ];
    }
}
