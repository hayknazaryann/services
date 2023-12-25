<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\ForgotPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
{
    /**
     * @param ForgotPasswordRequest $request
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function __invoke(ForgotPasswordRequest $request, AuthService $authService): JsonResponse
    {
        return $authService->sendPasswordResetLink($request->validated());
    }
}
