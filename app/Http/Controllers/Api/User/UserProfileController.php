<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;

class UserProfileController extends Controller{

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function show(Request $request){
        
    }

    public function edit(Request $request){
        
        $request->validate([
            'name'=>'bail|required',
            'email'=>'required|email|unique:users,email,'.$request->id,
            'phone'=>'required|digits_between:10,15|unique:users,phone,'.$request->phone,
            'location'=>'nullable|min:15|max:500'
        ]);
        
        $request->user()->update($request->validated());
        response("Profile updated successfully", 200);
    }

    public function sync(Request $request){
        return new UserResource($request->user());
    }
    
    public function logout(Request $request){
        $user = $request->user();
        $now =  now();
        $user->update(['last_active'=>$now]);
        $user->token()->delete();
        return response($now->toDateTimeString(),202);
   }
}