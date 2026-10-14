<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCanvasNodeRequest extends FormRequest
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
            'type' => ['required', 'string', 'in:character,location,note,audio,board,media'],
            'title' => ['required', 'string', 'max:255'],
            'pos_x' => ['nullable', 'numeric'],
            'pos_y' => ['nullable', 'numeric'],
            'width' => ['nullable', 'integer', 'min:100', 'max:1200'],
            'height' => ['nullable', 'integer', 'min:60', 'max:1200'],
            'is_pinned' => ['nullable', 'boolean'],
            'data' => ['nullable', 'array'],
        ];
    }
}
