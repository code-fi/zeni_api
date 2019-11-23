<?php

namespace App\Utils;


use GuzzleHttp\Client;

use Laravel\Passport\Client as PassportClient;

use Exception;


class PassportManager{
	public static function viaPassword(Credential $credential){
		try{
			
			$url = url('oauth/token');
			$http = new Client();
			$local_client = PassportClient::find(2);
            
            $response = $http->post($url,[
			'form_params' => [
			'grant_type'=>'password',
			'client_id'=>$local_client->id,
			'client_secret'=>$local_client->secret,
			'username'=>$credential->email,
			'password'=>$credential->password,
			'scope'=>'*'
			]
			]);
			
			return json_decode((string) $response->getBody(), true);
		}
		catch(Exception $e){return null;}
	}
}
