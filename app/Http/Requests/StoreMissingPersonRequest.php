<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMissingPersonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'last_seen_place' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:4000'],
            'contacts' => ['required', 'string', 'max:255'],
        ];
    }
}
