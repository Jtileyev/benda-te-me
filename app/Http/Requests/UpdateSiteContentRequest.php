<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:255'],
            'locale' => ['required', 'in:en,ru'],
            'value' => ['required', 'string', 'max:20000'],
        ];
    }
}
