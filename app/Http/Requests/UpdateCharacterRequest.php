<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCharacterRequest extends FormRequest
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
            'role' => ['sometimes', 'required', 'string', 'max:255'],
            'status' => ['sometimes', 'nullable', 'string', 'max:100'],
            'quote' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'bio' => ['sometimes', 'nullable', 'string'],
            'portrait_url' => ['sometimes', 'nullable', 'url', 'max:2000'],
            'gallery_urls' => ['sometimes', 'nullable', 'array'],
            'gallery_urls.*' => ['url', 'max:2000'],
            'traits' => ['sometimes', 'nullable', 'array'],
            'palette' => ['sometimes', 'nullable', 'array'],
            'location_id' => ['sometimes', 'nullable', 'exists:locations,id'],
            'audio_track_id' => ['sometimes', 'nullable', 'exists:audio_tracks,id'],
        ];
    }
}
