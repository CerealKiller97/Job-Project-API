<?php

namespace App\Http\Requests;

use App\Rules\HashedRoleRule;
use Hashids\HashidsInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @throws BindingResolutionException
     */
    public function rules(): array
    {
        return [
            'name'  => ['bail', 'required', 'regex:/^[A-Z][a-z]+(\s[A-Z][a-z]+)+$/'],
            'email' => ['bail', 'required', 'email', 'unique:users'],
            'password' => ['bail', 'required', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/'],
            'role_id' => ['bail', 'required', new HashedRoleRule($this->container->make(HashidsInterface::class))]
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'Password must contain 1 uppercase, 1 lowercase 1 number and must be at least 8 characters long.'
        ];
    }
}
