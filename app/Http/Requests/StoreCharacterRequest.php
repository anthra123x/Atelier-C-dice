<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCharacterRequest extends FormRequest
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
            'role' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:100'],
            'quote' => ['nullable', 'string', 'max:1000'],
            'bio' => ['nullable', 'string'],
            'portrait_url' => ['nullable', 'url', 'max:2000'],
            'gallery_urls' => ['nullable', 'array'],
            'gallery_urls.*' => ['url', 'max:2000'],
            'traits' => ['nullable', 'array'],
            'palette' => ['nullable', 'array'],
            'location_id' => ['nullable', 'exists:locations,id'],
            'audio_track_id' => ['nullable', 'exists:audio_tracks,id'],
        ];
    }
}
