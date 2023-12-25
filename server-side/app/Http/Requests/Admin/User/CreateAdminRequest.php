<?php

namespace App\Http\Requests\Admin\User;

use App\Enums\UserStatus;
use App\Http\Requests\Base\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CreateAdminRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'country_code' => ['required', 'string', 'numeric', 'max:4'],
            'phone_number' => ['required', 'string', 'numeric', 'max:20'],
            'password' => ['required', 'string', 'max:1024', Password::min(10)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
            'password_confirmation' => ['required', 'same:password'],
            'status' => ['required', Rule::in(UserStatus::values())],
            'role_id' => ['required', 'exists:roles,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('rules.first_name_required'),
            'first_name.string' => __('rules.first_name_string'),
            'first_name.max' => __('rules.first_name_max'),
            'last_name.required' => __('rules.last_name_required'),
            'last_name.string' => __('rules.last_name_string'),
            'last_name.max' => __('rules.last_name_max'),
            'email.required' => __('rules.email_required'),
            'email.string' => __('rules.email_string'),
            'email.email' => __('rules.email_email'),
            'email.max' => __('rules.email_max_255'),
            'email.unique' => __('rules.email_unique'),
            'country_code.required' => __('rules.country_code_required'),
            'country_code.string' => __('rules.country_code_string'),
            'country_code.max' => __('rules.country_code_max'),
            'phone_number.required' => __('rules.phone_number_required'),
            'phone_number.string' => __('rules.phone_number_string'),
            'phone_number.max' => __('rules.phone_number_max'),
            'phone_number.numeric' => __('rules.phone_number_numeric'),
            'password.required' => __('rules.password_required'),
            'password.string' => __('rules.password_string'),
            'password.max' => __('rules.password_max_255'),
            'password.min' => __('rules.password_min'),
            'password.letters' => __('rules.password_letters'),
            'password.mixedCase' => __('rules.password_mixed_case'),
            'password.numbers' => __('rules.password_numbers'),
            'password.symbols' => __('rules.password_symbols'),
            'confirm_password.required' => __('rules.confirm_password_required'),
            'confirm_password.same' => __('rules.confirm_password_same'),
            'status.required' => __('rules.status_required'),
            'role_id.required' => __('rules.role_id_required'),
            'role_id.exists' => __('rules.role_id_exists'),
            'image.image' => __('rules.image_image'),
            'image.mimes' => __('rules.image_mimes'),
            'image.max' => __('rules.image_max'),
        ];
    }
}
