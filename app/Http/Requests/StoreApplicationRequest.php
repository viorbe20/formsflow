<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'organization' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'statement' => ['required', 'string'],
            'request_text' => ['required', 'string'],
        ];
    }
}
