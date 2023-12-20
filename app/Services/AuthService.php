<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AuthService
{
    use ApiControllerTrait;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        protected UserRepository $userRepository
    )
    {
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function login(array $data): JsonResponse
    {
        try {
            if(!Auth::attempt($data)) {
                return $this->errorResponse('Unauthorized', 401);
            }

            $responseData['user'] = request()->user();
            $responseData['token'] = $responseData['user']->createToken('authToken')->plainTextToken;
            return $this->successResponse($responseData, __('Successfully registered'), 200);
        } catch (\Exception $exception) {
            return $this->errorResponse(__('Unauthorized'), 400);
        }
    }


    /**
     * @param array $data
     * @return JsonResponse
     */
    public function register(array $data): JsonResponse
    {
        try {
            $data['password'] = Hash::make($data['password']);
            $responseData['user'] = $this->userRepository->create($data);
            $responseData['token'] = $this->userRepository->createToken($responseData['user'], 'authToken');
            return $this->successResponse($responseData, __('Successfully registered'), 201);
        } catch (\Exception $exception) {
            return $this->errorResponse(__('Unauthorized'), 400);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            request()->user()->tokens()->delete();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return $this->successResponse([], __('Successfully logged out'), 200);
        } catch (\Exception $exception) {
            return $this->errorResponse(__('Unauthorized'), 400);
        }


    }

}
