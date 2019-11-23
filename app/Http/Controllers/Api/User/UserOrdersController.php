<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class UserOrdersController extends Controller{
    
    public function __construct(){
        $this->middleware('auth:api');
    }


    public function show(Request $request){
        $orders = $request->user()->store->orders;
        return response()->json(["data"=>$orders]);
    }

    public function getBilling(Request $request,$id){
            Order::select(['customer_name','customer_address','customer_phone','customer_remarks'])
            ->find($id);
            return response()->json(["data"=>$order_biling]);
    }

    public function editBilling(Request $request,$id){
        $request->validate([
            "customer_name"=>"required|string|bail",
            "customer_phone"=>"required|digits:10",
            "customer_address"=>"required|min:10"
        ]);

        Order::find($id)->update($request->all());
        return response("success");
    }

    public function changeStatus(Request $request,$id){
        Order::find($id)->update(["status"=>$request->status]);
        return response("success");
    }

    public function deleteOrder(Request $request){
        Orders::find($request->id)->delete();
        return response("success");
    }
}