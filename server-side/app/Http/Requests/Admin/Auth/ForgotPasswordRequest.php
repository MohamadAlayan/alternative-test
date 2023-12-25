<?php

namespace App\Http\Requests\admin\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255', 'exists:users,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('rules.email_required'),
            'email.email' => __('rules.email_invalid'),
            'email.max' => __('rules.email_max_255'),
            'email.exists' => __('rules.email_not_exist'),
        ];
    }
}
