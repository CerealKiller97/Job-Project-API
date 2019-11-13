<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'perPage' => ['nullable', 'numeric'],
            'page' => ['nullable', 'numeric'],
            'name' => ['nullable', 'max:255']
        ];
    }

    /**
     * @return array
     */
    public function getPagedRequest(): array
    {
        return [
            'page' => intval($this->page ?? 1),
            'perPage' => intval($this->perPage ?? 50),
            'name' => $this->name ?? null
        ];
    }
}
