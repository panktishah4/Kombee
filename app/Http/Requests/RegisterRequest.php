<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'first_name'        => 'required|alpha_num|max:50',
            'last_name'         => 'required|alpha_num|max:50',
            'email'             => 'required|email',
            'contact_number'    => 'required|numeric|digits:10',
            'postcode'          => 'required|numeric',
            'gender_id'        => 'required',
            'hobbies'           => 'required',
            // 'hobbies.*'         => 'exists:hobbies,id',
            'roles'             => 'required',
            // 'roles.*'        => 'exists:roles,id',
            'state_id'          => 'required',
            'city_id'           => 'required',
            'password'          => 'required',
            'file_path.*'           => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.regex' => 'Firstname must contain only alphanumeric characters.',
            'last_name.regex' => 'Lastname must contain only alphanumeric characters.',
            'file_path.*.mimes' => 'Only jpg, jpeg, png, pdf files are allowed.',
            'file_path.*.max' => 'Each file must not exceed 2MB.',
        ];
    }
}
