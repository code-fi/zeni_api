<?php

namespace App\Http\Resources;



class ExtProduct extends Product
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $ext = parent::toArray($request);
        return array_merge($ext,['rating'=>$this->rating]);
    }
}
