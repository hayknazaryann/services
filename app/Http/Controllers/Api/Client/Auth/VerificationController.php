<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\VerifyEmailRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerificationController extends Controller
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
     * @return JsonResponse
     */
    public function verify(Request $request): JsonResponse
    {
        return $this->authService->verifyEmail(
            $request->route('id'), $request->route('hash')
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function resend(Request $request): JsonResponse
    {
        return $this->authService->resendVerifyEmail($request->input('id'));
    }
}
