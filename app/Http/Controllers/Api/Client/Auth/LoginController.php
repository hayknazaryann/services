<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @param AuthService $authService
     */
    public function __construct(
        protected AuthService $authService
    )
    {
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request->validated());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        return $this->authService->logout();
    }
}
