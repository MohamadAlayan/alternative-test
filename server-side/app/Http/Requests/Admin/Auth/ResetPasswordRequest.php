<?php

namespace App\Http\Requests\admin\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'exists:users,email'],
            'password' => ['required', 'string', 'max:1024', Password::min(10)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'token.required' => __('rules.token_required'),
            'token.string' => __('rules.token_invalid'),
            'token.max' => __('rules.token_max_255'),
            'email.required' => __('rules.email_required'),
            'email.email' => __('rules.email_invalid'),
            'email.max' => __('rules.email_max_255'),
            'email.exists' => __('rules.email_not_exist'),
            'password.required' => __('rules.password_required'),
            'password.string' => __('rules.password_invalid'),
            'password.max' => __('rules.password_max_255'),

        ];
    }
}
