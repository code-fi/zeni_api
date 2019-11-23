<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\SimpleProduct;
use App\Http\Resources\ProductDetail as ProductDetailResource;
use Illuminate\Http\Request;

class UserProductsController extends Controller{
    
    protected $any_color = "Comes in different colours";
    protected $any_size = "Comes in different colors";

    public function __construct(){
        $this->middleware('auth:api');
    }


    public function show(Request $request){
            $products = $request->user()->products;
        if($products) $products->load("defaultImage");
        return SimpleProduct::collection($products);
    }

    public function get(Request $request,$id){
        $product = $request->user()->products()
            ->select(['id','description','extras','slug','category_id','store_id'])->find($id);
            return new ProductDetailResource($product);
    }

    public function edit(Request $request,$id){
        $request->validate([
            'name'=>'bail|required|min:4|max:100|unique:products,name,'.$request->name,
            'price'=>'required|numeric',
            'localDes'=>'required|min:100|max:1000',
            'category_id'=>'required|exists:product_categories,id'
        ]);
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'bail|required|min:4|max:100|unique:products',
            'price'=>'required|numeric',
            'localDes'=>'required|min:60|max:1000',
            'category_id'=>'required|exists:product_categories,id'
        ]);

        $user = $request->user();
        
        $name = $request->name;
        $price = $request->price;
        $slug = str_slug($name, '-');

        $extra = json_encode([
            "sizes"=>$request->sizes??$this->any_size,
            "colors"=>$request->colors??$this->any_color,
            "mma"=>"This products is made for $request->target"
        ]);

        $product = $user->store->products()->create([
            'name'=>$name,
            'price'=>$price,
            'extras'=>$extra,
            'description'=>$request->localDes,
            'slug'=>$slug,
            'category_id'=>$request->category_id,
            'added_on'=>now()
        ]);

        return response()->json(["data"=>$product->id]);
    }

    public function upload(Request $request,$product_id){
        $images = (Array) $request->images;
        
        // foreach ($images as $key => $image) {
            
        // }  
        
        return response()->json($images,400);
    }
}