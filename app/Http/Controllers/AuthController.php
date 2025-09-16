<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService)
    {
        
    }

    public function login(LoginUserRequest $request)
    {
        $user = $this->authService->login($request->validated());
        $token = $user->createAuthToken();

        return (new ApiResponse())->success('login successful', [
            'access_token' => $token?->plainTextToken,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return (new ApiResponse())->success('logout successful');
    }
}
