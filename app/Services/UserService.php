<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;
use App\Traits\ApiControllerTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
            DB::beginTransaction();
            $this->userRepository->updateProfile($user, $data);
            DB::commit();
            return $this->successResponse(
                data: [],
                message: __('Successfully updated')
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Profile update error: ' . $exception->getMessage());
            return $this->errorResponse(
                message: __('Something went wrong !')
            );
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
                $this->errorResponse(
                    message: __('Password is incorrect !'),
                    statusCode: 401
                );
            }

            $this->userRepository->update($user, [
                'password' => Hash::make($data['new_password']),
            ]);

            return $this->successResponse([], 'Password changed successfully');
        } catch (\Exception $exception) {
            Log::error('Change password error: ' . $exception->getMessage());
            return $this->errorResponse(
                message: __('Something went wrong !')
            );
        }

    }
}
