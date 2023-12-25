<?php

namespace App\Http\Requests\Admin\Pages;

use App\Enums\UserStatus;
use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdatePageRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:pages,id'],
            'uuid' => ['required', 'exists:pages,uuid'],

        ];
    }

    public function messages(): array
    {
        return [
        ];
    }
}
