<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCanvasNodeRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'pos_x' => ['sometimes', 'numeric'],
            'pos_y' => ['sometimes', 'numeric'],
            'width' => ['sometimes', 'nullable', 'integer', 'min:100', 'max:1200'],
            'height' => ['sometimes', 'nullable', 'integer', 'min:60', 'max:1200'],
            'is_pinned' => ['sometimes', 'boolean'],
            'data' => ['sometimes', 'array'],
        ];
    }
}
