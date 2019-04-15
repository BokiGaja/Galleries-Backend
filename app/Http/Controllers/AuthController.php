<?php

namespace App\Http\Controllers;

use App\Http\Services\ValidationService;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request$request)
    {
        $validator = ValidationService::validateUser($request);
        if (!is_string($validator))
        {
            $newUser = new User();
            $newUser->first_name = $request->first_name;
            $newUser->last_name = $request->last_name;
            $newUser->password = bcrypt($request->password);
            $newUser->email = $request->email;
            $newUser->save();
        } else {
            return response()->json(['error' => $validator]);
        }
    }
}
