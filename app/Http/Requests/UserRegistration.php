<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistration extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'bail|required|min:6',
            'email'=>'required|email|unique:users',
            'phone'=>'required|digits_between:10,15|unique:users',
            'password'=>'required|min:8'
        ];
    }

    public function messages(){
        return [
                'name.required'=>'Name is required',
                'name.min'=>'Name should be atleast 6 letters',
                'email.required'=>'Email address is required',
                'email.email'=>'Provide a valid email address',
                'email.unique'=>'Email address is already registered',
                'phone.required'=>'Phone number is required',
                'phone.unique'=>'Phone number is already registered',
                'phone.digits_between'=>'Phone number must be a valid Ghana number'
        ];
    }
}
