<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class BannerController extends Controller{


    public function get(Request $request){
        $banners  = Banner::limit(5)->get();

        return response()->json(['data'=>$banners]);
    }
}