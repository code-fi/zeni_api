<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetail as ProductDetailResource;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ExtProduct as ExtProductResource;

use App\Events\ProductAddedCall;
use App\Events\ProductViewedCall;
use App\Events\ProcessProductImagesCall;



use Illuminate\Http\Request;

class ProductController extends Controller{
    

    public function detail(Request $request,$id){
        $product_detail  = 
        Product::select([
            'id',
            'description',
            'extras',
            'slug',
            'category_id',
            'store_id'
            ])->find($id);
            return new ProductDetailResource($product_detail);
        // event(new ProductViewedCall($product_detail->simple_analytic));
    }


    public function getSimilar(Request $request,$id,$category_id){
        $similar = $this->similar_by_category($id,$category_id)->get();
        
        if($similar->count()>0){
            $similar->load('defaultImage');
            return ExtProductResource::collection($similar);
        }
        
        return $this->get_random_products($id);
    }

    public function get(Request $request,$action){

        switch ($action) {
            case 'sponsored':
            return $this->get_sponsored_products();
            case 'top':
            return $this->get_top_products();
            case 'new':
            return $this->get_new_products();
            case 'all':
            return response()->json($this->get_products());
        }
    }

    public function load_market_components(){
        $banners = $this->get_banners();
        $product_listings = $this->get_products();

        return [
            'data'=>[
                'banners'=>$banners,
                'product_listings'=>$product_listings
            ]

        ];
    }

    public function get_products_by_category(Request $request){
        $products = $this->verified_product()
        ->where("category_id",$request->category_id)
        ->whereBetween("price",[
            $request->priceMin,
            $request->priceMax
        ])
        ->paginate();

        return ExtProductResource::collection($products);
    }

    private function get_products(){

             return [
                        ["title"=>"Sponsored","data"=>$this->get_sponsored_products()],
                        ["title"=>"Fresh","data"=>$this->get_new_products()]
                    ];

    }

    private function get_banners(){
        return Banner::limit(5)->inRandomOrder()->get();
    }

    private function get_random_products($except_id){
        $product = $this->verified_product()
        ->where("id","!=",$except_id)
        ->inRandomOrder()
        ->limit(5)->get();

        if($product->count()>0)$product->load('defaultImage');
        
        return ExtProductResource::collection($product);
    }


    private function get_sponsored_products(){
        $products = $this->verified_product()->whereHas('sponsorship',function($query){
            $query->whereDate('ending_date','>',today());
        })->inRandomOrder()->get();
        
        if($products->count() > 0){
            $products->load('defaultImage');
        }

        return ExtProductResource::collection($products);
    }


    private function get_top_products(){
        $products = $this->verified_product()->whereHas('simple_analytics',function($query){
            $query->orderBy('likes','desc');
        })->orderBy('rating')->simplePaginate(10);
        
        if($products->count()>0){
            $products->load('defaultImage');
        }
        return  ExtProductResource::collection($products);
    }


    private function get_new_products(){
        $products = $this->verified_product()->limit(25)->get();

        if($products->count()>0){
            $products->load('defaultImage');
        }
        return  ExtProductResource::collection($products);

    }


    protected function verified_product(){
        return Product::with('shop')->where('status','verified');
    }

    protected function similar_by_category($id,$category_id){
        return $this->verified_product()->where([
            ["category_id","=",$category_id],
            ["id","!=",$id]
        ])->inRandomOrder()->limit(5);
    }

    public function create_product_order(Request $request){
        $request->validate([
            "customer.customer_name"=>"required|string|bail",
            "customer.customer_phone"=>"required|digits:10",
            "customer.customer_address"=>"required|min:10"
        ]);

        $product = Product::find($request->id);
        if($product){
            $expires_on = now()->addHours(12)->toDateTimeString();
            $uuid = str_random(15);
            $price = $request->price_per_item;
            $amount = $request->amount;
            $quantity = $request->quantity;

            $value = array_merge([
                "uuid"=>$uuid,
                "price_per_item"=>$price,
                "amount"=>$amount,
                "quantity"=>$quantity,
                "expires_on"=>$expires_on,
                "payment_method"=>2
            ],$request->customer);
            $order = $product->orders()->create($value);
            
            return response()->json(["data"=>[
                "uuid"=>$uuid,
                "id"=>$order->id
            ]]);
        }
    }
    public function store(Request $request){    
        // $request->validate([
        //     'name'=>'bail|required|min:4|max:100|unique:products',
        //     'price'=>'required|numeric',
        //     'description'=>'required|min:100|max:1000',
        //     // 'images'=>'required|array|min:1|max:3',
        //     // 'images.*'=>'mimes:jpeg,png|max:5120',
        //     'category_id'=>'required|exists:product_categories,id'
        // ]);

        /////////////////////////////////////////////////////////////////////////////////////////////
        
        // $user = $request->user();
        
        // $name = $request->name;
        // $price = $request->price;
        // $slug = str_slug($name, '-');
        // $extra = json_encode([
        //     "sizes"=>$request->sizes||"any",
        //     "colors"=>$request->colors||"any",
        //     "mma"=>$request->target
        // ]);
        /////////////////////////////////////////////////////////////////////////////////////////////
        
        // $product = $user->products->create([
        //     'name'=>$name,
        //     'price'=>$price,
        //     'extras'=>$extra,
        //     'description'=>$request->description,
        //     'slug'=>$slug,
        //     'category_id'=>$request->category_id,
        //     'added_on'=>now()
        // ]);

        ///////////////////////////////////////////////////////////////////////////////////////////////
        // event(new ProcessProductImagesCall($product->id,$request->images));
        // //////////////////////////////////////////////////////////////////////////////////////////////
        
        // /////////////////////////////////////////////////////////////////////////////////////////////
        // event(new ProductAddedCall([
        //     $user->email,
        //     'product'=>[
        //         'name'=>$name,
        //         'price'=>$price,
        //         'status_url'=>config("url")."/myproduct/$slug",
        //         'slug'=>$slug
        //         ]
        // ]));
        return response("4444",422);
        ////////////////////////////////////////////////////////////////////////////////////////////

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function edit(Product $product)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $name = $request->name;
        $request->validate([
            'name'=>'bail|required|min:4|max:100|unique:products,name,'.$name,
            'price'=>'required|numeric',
            'extras'=>'nullable|max:1000',
            'description'=>'required|min:100|max:1000',
            'category_id'=>'required|exists:product_categories,id'
        ]);

        $temp_slug = str_slug($name, '-');
        $old_slug = $request->slug;

        $slug = $old_slug !== $temp_slug ? $temp_slug : $old_slug;
        
        $product = $request->all();
        $product['slug'] = $slug;

        Product::find($request->id)->update($product);

        return response("Product updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
