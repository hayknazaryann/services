<?php

namespace App\Services;

use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\UserInterface as UserRepository;
use App\Traits\ApiControllerTrait;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
                return $this->errorResponse('Unauthorized: Invalid credentials', 401);
            }

            $responseData['user'] = new UserResource(request()->user());
            $responseData['token'] = $responseData['user']->createToken('authToken')->plainTextToken;

            return $this->successResponse($responseData, __('Successfully logged in'), 200);
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
            DB::beginTransaction();
            $data['password'] = Hash::make($data['password']);
            $user = $this->userRepository->create($data);
            event(new Registered($user));
            DB::commit();
            return $this->successResponse(
                data: [],
                message: __('Successfully registered. Please check your email for verification.'),
                statusCode: 201
            );
        } catch (\Exception $exception) {
            DB::rollback();
            dd($exception->getMessage());
            Log::error($exception->getMessage());
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

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function sendPasswordResetLink(array $data): JsonResponse
    {
        try {
            $status = Password::broker()->sendResetLink($data);

            return $status === Password::RESET_LINK_SENT
                ? $this->successResponse(
                    [],
                    __("If you've provided registered e-mail, you should get recovery e-mail shortly."),
                    200
                )
                : $this->errorResponse(
                    __("Unable to send password reset link."),
                    400
                );

        } catch (\Exception $exception) {
            return $this->errorResponse(__('Something went wrong !'), 400);
        }
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function resetPassword(array $data): JsonResponse
    {
        try {
            Password::broker()
                ->reset(
                    $data,
                    function ($user, string $password) {
                        $user->forceFill([
                            'password' => Hash::make($password),
                        ])->setRememberToken(Str::random(60));
                        $user->save();
                        event(new PasswordReset($user));
                    }
                );

            return $this->successResponse([], __('Password reset successfully'));
        } catch (\Exception $exception) {
            return $this->errorResponse(__('Something went wrong !'), 400);
        }
    }

    /**
     * @param int $id
     * @param string $hash
     * @return JsonResponse
     */
    public function verifyEmail(int $id, string $hash): JsonResponse
    {
        try {
            $user = $this->userRepository->findOrFail($id);

            if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
                return $this->errorResponse(__('Invalid verification link !'), 401);
            }

            if ($user->hasVerifiedEmail()) {
                return $this->successResponse([], __('Email already verified'), 200);
            }

            $user->markEmailAsVerified();

            return $this->successResponse([], __('Email verified successfully'), 200);
        } catch (\Exception $exception) {
            return $this->errorResponse(__('Something went wrong !'), 400);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function resendVerifyEmail(int $id): JsonResponse
    {
        try {
            $user = $this->userRepository->findOrFail($id);

            if ($user->hasVerifiedEmail()) {
                return $this->successResponse([], __('Email already verified'), 200);
            }

            $user->sendEmailVerificationNotification();
            return $this->successResponse([], __('Verification email has been resent !'), 200);

        } catch (\Exception $exception) {
            return $this->errorResponse(__('Something went wrong !'), 400);
        }
    }
}
