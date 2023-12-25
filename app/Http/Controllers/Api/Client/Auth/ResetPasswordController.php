<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\ResetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    /**
     * @param ResetPasswordRequest $request
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function __invoke(ResetPasswordRequest $request, AuthService $authService): JsonResponse
    {
        return $authService->resetPassword($request->validated());
    }
}
