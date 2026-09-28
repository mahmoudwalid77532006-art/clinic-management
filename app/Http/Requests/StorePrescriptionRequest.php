<?php

namespace App\Http\Requests;

// use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePrescriptionRequest extends FormRequest
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
        'visit_id' => ['required', 'exists:visits,id'],
        'medication_name' => ['required', 'string', 'max:255'],
        'dosage' => ['required', 'string', 'max:255'],
        'frequency' => ['required', 'string', 'max:255'],
        'duration' => ['required', 'string', 'max:255'],
        'instructions' => ['nullable', 'string'],
    ];
}
}