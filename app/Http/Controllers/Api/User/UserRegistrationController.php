<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Events\AccountRegistrationCall;
use App\Utils\PassportManager;
use App\Utils\Credential;

class UserRegistrationController extends Controller{
    
    protected $store_base_url = "https://ooo/";

    public function __construct(){
        $this->middleware('guest:api');
    }

    public function index(Request $request){
        
        $request->validate([
                'name'=>'bail|required|min:3',
                'email'=>'required|email|unique:users',
                'phone'=>'required|digits_between:10,15|unique:users',
                'password'=>'required|min:8'
        ]);

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        // $userCount = User::selectRaw("COUNT(id) as id")->where("email",$email)->orWhere("phone",$phone)->first();
        // if($userCount->id>0) return response("Email or phone number is already registered.",400);
        
        $password = bcrypt($request->password);
        $ip = $request->ip();
        
        $user = User::create([
            'name'=>$name,
            'email'=>$email,
            'password'=>$password,
            'phone'=>$phone,
            'ip_address'=>$ip,
            'city_id'=>1
        ]);
        
        $slug  = str_slug($name);

        $user->store()->create([
            "name"=>$name,
            "city_id"=>1,
            "slug"=>$slug,
            "url"=>"$this->store_base_url$slug",
            "created_at"=>now()
        ]);

        
        $credential = new Credential;
        $credential->email = $email;
        $credential->password = $request->password;
        
        $token = PassportManager::viaPassword($credential);
        // return response("$token",500);
        if(!$token) return response("Registration falied, try again later",500);
        
        

        // event(new AccountRegistrationCall([$name,$email]));    
         //TODO: SEND VERIFICATION EMAIL
         return response()->json([
            "msg"=>"Welcome $name",
            "code"=>1,
            "data"=>[
            'profile'=>[
                'name'=>$name,
                'email'=>$email,
                'phone'=>$phone,
                'account_type'=>'basic'
            ],
            'clientinfo'=>$token
            ]
        ]);

    }

    
}