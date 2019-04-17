<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use App\Http\Services\ValidationService;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = ValidationService::validateUser($request);
        if (!is_string($validator)) {
            AuthService::registerUser($request);
        } else {
            return response()->json(['error' => $validator]);
        }
    }

    public function login(Request $request)
    {
        return AuthService::loginUser($request);
    }

    public function logout()
    {
        AuthService::logoutUser();
    }
}
