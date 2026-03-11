<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,mov,avi,webm', 'max:51200'],
            'video_url' => ['nullable', 'url', 'max:2048'],
            'preview_image' => ['nullable', 'image', 'max:5120'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (!$this->hasFile('video_file') && !$this->filled('video_url')) {
                $validator->errors()->add('video_file', __('site.video_source_required'));
            }
        });
    }
}
