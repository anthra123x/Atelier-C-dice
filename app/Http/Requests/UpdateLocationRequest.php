<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'code' => ['sometimes', 'nullable', 'string', 'max:50'],
            'sector' => ['sometimes', 'required', 'string', 'max:255'],
            'icon' => ['sometimes', 'nullable', 'string', 'max:50'],
            'color' => ['sometimes', 'nullable', 'string', 'max:30'],
            'map_x' => ['sometimes', 'numeric'],
            'map_y' => ['sometimes', 'numeric'],
            'status' => ['sometimes', 'nullable', 'string', 'max:100'],
            'description' => ['sometimes', 'required', 'string'],
            'intel' => ['sometimes', 'nullable', 'string'],
            'threat_level' => ['sometimes', 'nullable', 'integer', 'min:1', 'max:5'],
            'key_contacts' => ['sometimes', 'nullable', 'array'],
            'image_url' => ['sometimes', 'nullable', 'url', 'max:2000'],
        ];
    }
}
