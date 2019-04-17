<?php

namespace App\Http\Services;


use App\Movie;
use \Illuminate\Support\Facades\Validator;

class ValidationService
{
    public static function validateInput($data, $rules)
    {
        $validator = Validator::make($data->all(), $rules);

        if ($validator->fails())
        {
            return $validator->errors()->first();
        } else {
            return true;
        }
    }
    public static function validateUser($userData)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'password_confirmation'=>'sometimes|required_with:password',
        ];
        return ValidationService::validateInput($userData, $rules);
    }

    public static function validateGallery($galleryData)
    {
        $rules = [
            'title' => 'required|min:2|max:255',
            'description' => 'max: 1000',
            'user_id' => 'required',
            'images' => 'required|array|min:1',
            'images.*' => ['required','url', 'regex:/[.](jpe?g|png)/'],
        ];
        return ValidationService::validateInput($galleryData, $rules);
    }

    public static function validatePicture($pictureData)
    {
        $rules = [
            'imageUrl' => ['required', 'regex:/[.](jpe?g|png)/'],
            'gallery_id' => 'required'
        ];
        return ValidationService::validateInput($pictureData, $rules);
    }
}