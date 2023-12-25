<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use ApiControllerTrait;

    /**
     * @param UserInterface $userRepository
     */
    public function __construct(
        protected UserInterface $userRepository
    )
    {
    }

    /**
     * @param User $user
     * @param array $data
     * @return JsonResponse
     */
    public function updateProfile(User $user, array $data): JsonResponse
    {
        try {
            $this->userRepository->update($user, $data);
            return $this->successResponse([], 'Successfully updated');
        } catch (\Exception $exception) {
            return $this->errorResponse(__('Unauthorized'));
        }
    }

    /**
     * @param User $user
     * @param array $data
     * @return JsonResponse
     */
    public function changePassword(User $user, array $data): JsonResponse
    {
        try {
            if (!$this->userRepository->checkPassword($user, $data['password'])) {
                $this->errorResponse('Password is incorrect !', 401);
            }

            $this->userRepository->update($user, [
                'password' => Hash::make($data['new_password']),
            ]);

            return $this->successResponse([], 'Password changed successfully');
        } catch (\Exception $exception) {
            return $this->errorResponse(__('Unauthorized'), 400);
        }

    }
}
