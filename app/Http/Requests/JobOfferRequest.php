<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobOfferRequest extends FormRequest
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
            'title' => ['bail', 'required', 'max:200'],
            'description' => ['bail', 'required'],
            'email' => ['bail', 'required', 'email']
//            'validUntil' => ['bail', 'required', 'after:tomorrow']
        ];
    }
}
