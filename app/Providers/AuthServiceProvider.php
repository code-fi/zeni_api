<?php

namespace App\Providers;

// use App\User;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(){
        $this->registerPolicies();

        // Auth::viaRequest('token',function(Request $request){
            
        //     $token = $request->bearerToken();
        //     if(!empty($token)){
        //         return User::where('token',$token)->whereDate('token_expire_date','>',now());
        //     }
                
        // });
        //
        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
