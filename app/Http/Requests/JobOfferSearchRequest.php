<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobOfferSearchRequest extends FormRequest
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
            'perPage' => ['nullable', 'numeric'],
            'page' => ['nullable', 'numeric'],
            'isSpan' => ['nullable', 'boolean'],
            'isPublished' => ['nullable', 'boolean']
        ];
    }

    public function getPagedRequest(): array
    {
        return [
            'perPage' => $this->perPage ?? 5,
            'page' => $this->page ?? 1,
            'isSpan' => $this->isSpan ?? null,
            'isPublished' => $this->isPublished ?? null
        ];
    }
}
