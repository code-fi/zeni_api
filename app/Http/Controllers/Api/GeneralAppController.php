<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Feed;
use App\Region;
use App\Http\Resources\Feed as FeedResource;
use App\Http\Resources\CitiesByRegion;;
use App\Http\Controllers\Controller;

class GeneralAppController extends Controller{

    public function getFeeds(){
        $feed =  Feed::orderBy('published_on','desc')->paginate();
        return FeedResource::collection($feed);
    }

    public function getCities(Request $request,$name){
        $region  = Region::select("id")->where("name","like","%$name%")->first();
    
        return ($region->has('cities')) ? CitiesByRegion::collection($region->cities) :  response("No city found",404);
    }
}