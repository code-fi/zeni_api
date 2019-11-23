<?php

namespace App\Http\Controllers\Api\User;


use Illuminate\Http\Request;


use App\Http\Controllers\Controller;
use App\Utils\PassportManager;
use App\Utils\Credential;
use App\User;






class UserLoginController extends Controller{
	
	public function __construct(){
		$this->middleware('guest:api');
	}
	
	/**
	 * 
	 * Authenticate User
	 * @param Request $request
	 * @return mixed;
	 *  
	 * */	

	public function index(Request $request){
		
		$request->validate([
		"phone"=>'required|digits:10',
		"password"=>'required|min:8'
		]);
		

		$user = User::select(['id','name','email','phone','password','account_type'])
					->where('phone',$request->phone)
					->first();

		return $user ? $this->verifyPassword($user,$request->password) : response("Invalid phone number or password",422);
		
	}
	
	private function verifyPassword(User $user, $password){	
		return password_verify($password,"$user->password") ? $this->attemptLogin($user,$password) : response()->json("Invalid phone number or password",422);
	}
	
	
	private function attemptLogin(User $user,$password){
		
		$credential = new Credential;
		$credential->email = $user->email;
		$credential->password = $password;
			
		$token = PassportManager::viaPassword($credential);
		
		if($token == null) return response("Server error, please try again later",500);
		
		
		$name = $user->name;
		
		
		return response()->json([
		"msg"=>"Welcome $name",
		"code"=>1,
		"data"=>[
		'profile'=>[
		'name'=>$name,
		'email'=>$user->email,
        'phone'=>$user->phone,
        'account_type'=>$user->account_type
		],
		'clientinfo'=>$token
		]
		]);
		
	}
	
	
}

