<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\Auth\ForgotPasswordRequest;
use App\Http\Requests\admin\Auth\LoginRequest;
use App\Http\Requests\admin\Auth\LogoutRequest;
use App\Http\Requests\admin\Auth\ResetPasswordRequest;
use App\Services\Admin\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login function
     *
     * @param LoginRequest $loginRequest
     * @throws Exception
     * @return JsonResponse
     */
    public function login(LoginRequest $loginRequest)
    {
        return $this->authService->login([
            'email' => $loginRequest->input('email'),
            'password' => $loginRequest->input('password'),
            'remember_me' => $loginRequest->input('remember_me'),
            'captcha_token' => $loginRequest->input('captcha_token')
        ]);
    }

    /**
     * Forgot password function
     *
     * @param ForgotPasswordRequest $forgotPasswordRequest
     * @throws Exception
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $forgotPasswordRequest): JsonResponse
    {
        return $this->authService->forgotPassword([
            'email' => $forgotPasswordRequest->input('email'),
            'captcha_token' => $forgotPasswordRequest->input('captcha_token')
        ]);
    }

    /**
     * Reset password function
     *
     * @param ResetPasswordRequest $resetPasswordRequest
     * @throws Exception
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $resetPasswordRequest): JsonResponse
    {
        return $this->authService->resetPassword([
            'token' => $resetPasswordRequest->input('token'),
            'email' => $resetPasswordRequest->input('email'),
            'password' => $resetPasswordRequest->input('password'),
            'password_confirmation' => $resetPasswordRequest->input('password_confirmation')
        ]);
    }

    /**
     *  Logout function
     *
     * @param LogoutRequest $logoutRequest
     * @throws Exception
     * @return JsonResponse
     */
    public function logout(LogoutRequest $logoutRequest)
    {
        return $this->authService->logout($logoutRequest);
    }

    /**
     * Logout all function
     *
     * @param LogoutRequest $logoutRequest
     * @throws Exception
     * @return JsonResponse
     */
    public function logoutAll(LogoutRequest $logoutRequest)
    {
        return $this->authService->logoutFromAllDevices($logoutRequest);
    }
}
