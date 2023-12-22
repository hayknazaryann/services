<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use app\Http\Requests\Client\User\ChangePasswordRequest;
use App\Http\Requests\Client\User\PasswordChangeRequest;
use App\Http\Requests\Client\User\UpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        protected UserService $userService
    )
    {
    }

    /**
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function updateProfile(UpdateRequest $request): JsonResponse
    {
        return $this->userService->updateProfile(
            $request->user(),
            $request->validated()
        );
    }

    /**
     * @param PasswordChangeRequest $request
     * @return JsonResponse
     */
    public function changePassword(PasswordChangeRequest $request): JsonResponse
    {
        return $this->userService->changePassword(
            $request->user(),
            $request->validated()
        );
    }

    /**
     * @param Request $request
     * @return UserResource
     */
    public function user(Request $request): UserResource
    {
        return (new UserResource($request->user()));
    }
}
