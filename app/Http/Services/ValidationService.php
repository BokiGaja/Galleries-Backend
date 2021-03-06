<?php

namespace App\Http\Services;


use \Illuminate\Support\Facades\Validator;

class ValidationService
{
    public function validateInput($data, $rules)
    {
        $validator = Validator::make($data->all(), $rules);

        if ($validator->fails())
        {
            return $validator->errors()->first();
        } else {
            return true;
        }
    }
    public function validateUser($userData)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'password_confirmation'=>'sometimes|required_with:password',
        ];
        return $this->validateInput($userData, $rules);
    }

    public function validateGallery($galleryData)
    {
        $rules = [
            'title' => 'required|min:2|max:255',
            'description' => 'max: 1000',
            'user_id' => 'required',
            'images' => 'required|array|min:1',
            'images.*' => ['required','url', 'regex:/[.](jpe?g|png)$/'],
        ];
        return $this->validateInput($galleryData, $rules);
    }

    public function validateComment($commentData)
    {
        $rules = [
            'content' => 'required|max:1000',
            'gallery_id' => 'required',
            'user_id' => 'required'
        ];
        return $this->validateInput($commentData, $rules);
    }

}