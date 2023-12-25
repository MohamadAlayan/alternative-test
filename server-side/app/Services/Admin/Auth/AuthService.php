<?php

namespace App\Services\Admin\Auth;

use App\Enums\HttpCode;
use App\Enums\UserStatus;
use App\Helpers\AppHelper;
use App\Http\Requests\admin\Auth\LogoutRequest;
use App\Http\Response;
use App\Mail\PasswordResetMail;
use App\Models\User\User;
use App\Repositories\PasswordReset\PasswordResetRepository;
use App\Repositories\User\UserRepository;
use App\Services\Base\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService extends BaseService
{
    public $repository = UserRepository::class;

    private UserRepository $userRepository;
    private PasswordResetRepository $passwordResetRepository;

    private int $passwordResetTokenExpiryTime; // in minutes

    public function __construct(UserRepository $userRepository, PasswordResetRepository $passwordResetRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->passwordResetRepository = $passwordResetRepository;
        $this->passwordResetTokenExpiryTime = config('auth.passwords.users.expire');
    }

    /**
     * Login function
     * @param array $data
     * @return JsonResponse
     * @throws Exception
     */
    public function login(array $data): JsonResponse
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        if (Auth::attempt($credentials)) {
            /** @var User $authUser */
            $authUser = Auth::user();

            // Check if user type is admin
            if (!$authUser->isAdmin()) {
                return Response::error(__('messages.account_not_allowed'), null, HttpCode::UNAUTHORIZED->value);
            }

            // Check user status
            if ($authUser->status === UserStatus::DELETED->value) {
                return Response::error(__('messages.account_deleted'), null, HttpCode::UNAUTHORIZED->value);
            } else if ($authUser->status === UserStatus::SUSPENDED->value) {
                return Response::error(__('messages.account_suspended'), null, HttpCode::UNAUTHORIZED->value);
            }

            // Check if user is verified
            if (!$authUser->verified) {
                return Response::error(__('messages.account_not_verified'), null, HttpCode::UNAUTHORIZED->value);
            }

            if ($data['remember_me'] === true) {
                $token = $authUser->createToken($authUser->email . now(), ['remember'])->plainTextToken;
            } else {
                $token = $authUser->createToken($authUser->email . now())->plainTextToken;
            }

            return Response::success(__('messages.user_successfully_login'), [
                'user' => $authUser,
                'token' => $token
            ]);
        }

        return Response::error(__('messages.invalid_credentials'), null, HttpCode::UNAUTHORIZED->value);
    }

    /**
     * Logout function
     * @param LogoutRequest $logoutRequest
     * @return JsonResponse
     * @throws Exception
     */
    public function logout(LogoutRequest $logoutRequest): JsonResponse
    {
        // Check if user type is admin
        if (!$logoutRequest->user()->isAdmin()) {
            return Response::error(__('messages.not_allowed_to_perform_action'), null, HttpCode::UNAUTHORIZED->value);
        }

        // Revoke the token that was used to authenticate the current request
        if ($logoutRequest->user()->currentAccessToken()->delete()) {
            return Response::success(__('messages.logout_successfully'));
        }

        return Response::error(__('messages.logout_failed'), null, HttpCode::BAD_REQUEST->value);
    }

    /**
     * Logout the user from all devices
     * @param LogoutRequest $logoutRequest
     * @return JsonResponse
     * @throws Exception
     */
    public function logoutFromAllDevices(LogoutRequest $logoutRequest): JsonResponse
    {
        // Check if user type is admin
        if (!auth()->user()->isAdmin()) {
            return Response::error(__('messages.not_allowed_to_perform_action'), null, HttpCode::UNAUTHORIZED->value);
        }

        // Revoke the token that was used to authenticate the current request
        if (auth()->user()->tokens()->delete()) {
            return Response::success(__('messages.logout_successfully'));
        }

        return Response::error(__('messages.logout_failed'), null, HttpCode::BAD_REQUEST->value);
    }

    /**
     * Forgot password function
     * @param array $data
     * @return JsonResponse
     * @throws Exception
     */
    public function forgotPassword(array $data): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->where(['email' => $data['email']])->first();
        if ($user && $user->isAdmin()) {
            $email = $user->email;
            // check if password reset data exists and not expired
            $passwordResetData = $this->passwordResetRepository->getByEmail($email);
            if ($passwordResetData && Carbon::parse($passwordResetData->created_at)->addMinutes($this->passwordResetTokenExpiryTime)->isPast()) {
                // delete old password reset data
                $this->passwordResetRepository->deleteByEmail($email);
                // create new password reset data
                $passwordResetData = $this->passwordResetRepository->create([
                    'email' => $email,
                    'token' => AppHelper::getRandomMixedCode(6),
                    'created_at' => Carbon::now()
                ]);
            } else if ($passwordResetData && !Carbon::parse($passwordResetData->created_at)->addMinutes($this->passwordResetTokenExpiryTime)->isPast()) {
                $passwordResetData = $this->passwordResetRepository->updateById([
                    'email' => $email,
                    'token' => $passwordResetData->token,
                ], $passwordResetData->id);
            } else {
                // create new password reset data
                $passwordResetData = $this->passwordResetRepository->create([
                    'email' => $email,
                    'token' => AppHelper::getRandomMixedCode(6),
                    'created_at' => Carbon::now()
                ]);
            }

            if ($data) {
                Mail::to($email)->send(new PasswordResetMail($user->full_name, $passwordResetData->email, $passwordResetData->token, $this->passwordResetTokenExpiryTime));
                return Response::success(__('messages.reset_password_email_sent_successfully'));
            }
        }
        // email not found
        return Response::error(__('messages.email_not_found'), null, HttpCode::BAD_REQUEST->value);
    }

    /**
     * Reset admin password function
     * @param array $data
     * @return JsonResponse
     * @throws Exception
     */
    public function resetPassword(array $data): JsonResponse
    {
        $passwordReset = $this->passwordResetRepository->getByTokenAndEmail($data['token'], $data['email']);
        if ($passwordReset && $passwordReset->created_at >= Carbon::now()->subMinutes($this->passwordResetTokenExpiryTime)) {
            $user = $this->userRepository->where(['email' => $data['email']])->first();
            if ($user && $user->isAdmin()) {
                $user->password = Hash::make($data['password']);
                $user->save();

                // delete password reset data
                $this->passwordResetRepository->deleteByEmail($data['email']);

                // log user out from all devices
                $user->tokens()->delete();

                // TODO send email to user that password has been changed

                return Response::success(__('messages.reset_password_successfully'));
            }
        }
        return Response::error(__('messages.invalid_token'), null, HttpCode::BAD_REQUEST->value);
    }
}
