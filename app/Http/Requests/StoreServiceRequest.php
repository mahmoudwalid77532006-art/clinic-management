<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'description' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ];
    }
}
