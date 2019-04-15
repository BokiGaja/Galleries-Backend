<?php

namespace App\Http\Services;


use App\Movie;
use \Illuminate\Support\Facades\Validator;

class ValidationService
{
    public static function validateUser($userData)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'password_confirmation'=>'sometimes|required_with:password',
        ];
        $validator = Validator::make($userData->all(), $rules);

        if ($validator->fails())
        {
            return $validator->errors()->first();
        } else {
            return true;
        }
    }
}