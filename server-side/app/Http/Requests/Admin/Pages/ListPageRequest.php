<?php

namespace App\Http\Requests\Admin\Pages;


use App\Http\Requests\Base\ListRequest;

class ListPageRequest extends ListRequest
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
