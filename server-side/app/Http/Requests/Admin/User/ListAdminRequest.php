<?php

namespace App\Http\Requests\Admin\User;


use App\Http\Requests\Base\ListRequest;

class ListAdminRequest extends ListRequest
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
