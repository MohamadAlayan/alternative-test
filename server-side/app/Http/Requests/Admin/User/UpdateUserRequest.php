<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\Base\BaseRequest;

class UpdateUserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            // Define your validation rules here
        ];
    }

    public function messages(): array
    {
        return [
            // Define your custom validation messages here
        ];
    }
}
