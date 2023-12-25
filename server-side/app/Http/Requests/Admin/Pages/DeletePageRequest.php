<?php

namespace App\Http\Requests\Admin\Pages;

use App\Enums\UserStatus;
use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class DeletePageRequest extends BaseRequest {
    public function rules(): array {
        return [];
    }

    public function messages(): array {
        return [
        ];
    }
}
