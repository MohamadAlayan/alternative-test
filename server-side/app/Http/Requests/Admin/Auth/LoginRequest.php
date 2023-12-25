<?php

namespace App\Http\Requests\admin\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255', 'exists:users,email'],
            'password' => ['required', 'string', 'max:255'],
            'remember_me' => ['nullable', 'boolean'],
            'captcha_token' => ['nullable', 'string', 'max:1024'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('rules.email_required'),
            'email.email' => __('rules.email_invalid'),
            'email.max' => __('rules.email_max_255'),
            'email.exists' => __('rules.email_not_exist'),
            'password.required' => __('rules.password_required'),
            'password.string' => __('rules.password_invalid'),
            'password.max' => __('rules.password_max_255'),
            'remember_me.boolean' => __('rules.remember_me_invalid'),
            'captcha_token.string' => __('rules.captcha_token_invalid'),
            'captcha_token.max' => __('rules.captcha_token_max'),
        ];
    }

}
