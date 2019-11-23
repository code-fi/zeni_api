<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;

use App\User;
use App\UserPasswordReset;
use App\Events\PasswordResetCall;
use Carbon\Carbon;

class UserPasswordResetController extends Controller{

    public function index(Request $request){
        $user = User::select(['id','name','email'])
                ->where('email',$request->email)
                ->first();
        return $user ? $this->attemptPassowrdReset($user) : response("Email address is a not registered", 402);
    }

    protected function attemptPasswordReset(User $user){
        $token = UserPasswordReset::select('token')->where('user_id',$user->id)->first();

        if(!$token){
            $token = str_random(20);
            $expire_time = Carbon::now()->addHours(24);
            
            $user->passwordReset->create([
                'token'=>$token,
                'expires_at'=>$expire_time
            ]);
        }
        event(new PasswordResetCall($user,$token));
        return response("Check your email to continue.");
    }

    public function getConfirmationPage(Request $request){
    
        if($request->has('token')){
            $token = $request->token;
            $user_id = UserPasswordReset::select('user_id')->where('token',$token)->first();
            return $user_id ? view('',['token'=>$token]) : view('',['message'=>'Token has expired','state'=>0]);
        }else{
            return abort(404,"Missing token");
        }
    }

    public function submitPasswordReset(Request $request){
        $request->validate([
            'password'=>'required|min:8|confirmed'
        ]);

        $reset_request = UserPasswordReset::select('user_id')->where('token',$request->token)->first();
        $hashed_password = bcrypt($request->password);

        User::find($reset_request)->update(['password'=>$hashed_password,'token'=>null]);

        return view('',['message'=>'Password changed successfully!','state'=>1]);
    }

    
}