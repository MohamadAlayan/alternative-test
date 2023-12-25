<?php

namespace App\Http\Requests\Base;

class ListRequest extends BaseRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'page' => 'required|integer',
            'per_page' => 'required|integer',
            'sort_by' => 'nullable|string',
            'is_descending' => 'nullable|bool',
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'page' => $this->input('page', 1),
            'per_page' => $this->input('per_page', 10)
        ]);
    }

}
