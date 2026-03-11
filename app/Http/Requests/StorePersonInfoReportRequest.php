<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonInfoReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'target_person_name' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:4000'],
            'contacts' => ['required', 'string', 'max:255'],
        ];
    }
}
