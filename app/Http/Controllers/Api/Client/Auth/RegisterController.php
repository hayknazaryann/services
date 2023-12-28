<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request, AuthService $authService): JsonResponse
    {
        return $authService->register($request->validated());
    }
}
