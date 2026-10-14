<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'sector' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:30'],
            'map_x' => ['required', 'numeric'],
            'map_y' => ['required', 'numeric'],
            'status' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'intel' => ['nullable', 'string'],
            'threat_level' => ['nullable', 'integer', 'min:1', 'max:5'],
            'key_contacts' => ['nullable', 'array'],
            'image_url' => ['nullable', 'url', 'max:2000'],
        ];
    }
}
