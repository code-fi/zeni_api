<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Admin;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller{

    public function __construct(){
        $this->middleware('guest:admin');
    }

    public function index(Request $request){
        $request->validate([
            'username'=>'bail|required|min:3',
            'password'=>'required|min:8'
        ]);

        $getAdmin = Admin::select(['id','name','role','password'])->where('username',$request->username)->first();
        return $getAdmin ? $this->verify_password($getAdmin,$request->password,$request) : response(["message"=>"Invalid username or password."],422);
    }

    private function verify_password(Admin $admin,$password,$request){
        return password_verify($password,$admin->password) ? $this->attempt_login($admin,$request) : response(["message"=>"Invalid username or password."],422);
    }

    private function attempt_login(Admin $admin,$request){
        $token = $admin->name.str_random(45);
        $token = base64_encode($token);
        $expire_date = now()->addDays(7)->toDateTimeString();
        
        $admin->access_tokens()->create([
            "api_token"=>$token,
            "expire"=>$expire_date,
            "access_ip_address"=>$request->ip(),
            "access_user_agent"=>$request->userAgent()
        ]);

        return response()->json([
            "msg"=>"Login Success",
            "code"=>200,
            "data"=>[
                "token"=>$token,
                "expire"=>$expire_date,
                "client_info"=>[
                    "name"=>$admin->name,
                    "role"=>$admin->role
                ]
            ]
        ]);
    }
}