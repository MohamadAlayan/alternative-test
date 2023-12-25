<?php

namespace App\Http\Requests\Admin\Pages;

use App\Http\Requests\Base\BaseRequest;


class CreatePageRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'unique:pages'],
            'status' => ['required', 'integer'],
            'content' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:pages,id'],
        ];
    }

    public function messages(): array
    {
        return [
        ];
    }
}
