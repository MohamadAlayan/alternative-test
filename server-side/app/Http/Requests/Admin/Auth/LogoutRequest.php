<?php

namespace App\Http\Requests\admin\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LogoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }
}
