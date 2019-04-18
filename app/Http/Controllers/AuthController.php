<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use App\Http\Services\ValidationService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(ValidationService $validationService, AuthService $authService)
    {
        $this->validationService = $validationService;
        $this->authService = $authService;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = $this->validationService->validateUser($request);
        if (!is_string($validator)) {
            $registeredUser = $this->authService->registerUser($request);
            return response()->json($registeredUser, 200);
        }

        return response()->json(['error' => $validator], 400);
    }

    public function login(Request $request)
    {
        $loggedUser = $this->authService->loginUser($request);
        if ($loggedUser) {
            return $loggedUser;
        }

        return response()->json(['error' => 'Wrong credentials'], 400);
    }

    public function logout()
    {
        auth('api')->logout();
    }
}
