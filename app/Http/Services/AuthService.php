<?php


namespace App\Http\Services;

use App\User;

class AuthService
{
    public function registerUser($userData)
    {
        $newUser = new User();
        $newUser->first_name = $userData->first_name;
        $newUser->last_name = $userData->last_name;
        $newUser->password = bcrypt($userData->password);
        $newUser->email = $userData->email;
        $newUser->save();
        auth()->login($newUser);
    }

    public function loginUser($userData)
    {
        $credentials = $userData->only(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return null;
        }

        return AuthService::respondWithToken($token);
    }

    public static function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user' => AuthService::guard()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public static function guard()
    {
        return \Auth::Guard('api');
    }
}