<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCanvasConnectionRequest extends FormRequest
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
            'source_node_id' => ['required', 'exists:canvas_nodes,id'],
            'target_node_id' => ['required', 'different:source_node_id', 'exists:canvas_nodes,id'],
            'label' => ['nullable', 'string', 'max:100'],
            'badge_icon' => ['nullable', 'string', 'max:50'],
            'curvature' => ['nullable', 'string', 'in:curved,straight,step'],
            'color' => ['nullable', 'string', 'max:30'],
        ];
    }
}
