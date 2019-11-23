<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $analytic = $this->simple_analytics;
        $views = 0;
        $likes = 0;

        if($analytic){
            $views = $analytic->views;
            $likes = $analytic->likes;
        }
        

        return [
            'id'=>$this->id,
            'description'=>$this->description,
            'slug'=>$this->slug,
            'extra'=>$this->extras,
            'views'=>$views,
            'likes'=>$likes,
            'images'=>$this->extract_images(),
            'image_count'=>$this->images->count(),
            'publisher'=>$this->shop,
            'category'=>$this->category
        ];
    }

    protected function extract_images(){
        $images = [];
        foreach ($this->images as $key => $value) {
            array_push($images,$value['path']);
        }
        return $images;
    }
}
