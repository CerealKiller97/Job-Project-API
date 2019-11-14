<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['bail', 'required', 'email'],
            'password' => ['bail', 'required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/']
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'Password must contain 1 uppercase, 1 lowercase 1 number and must be at least 8 characters long.'
        ];
    }
}
