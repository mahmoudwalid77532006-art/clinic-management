<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
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
        $patientId = $this->route('patient')?->id;

        return [
            'user_id' => ['required', 'exists:users,id', Rule::unique('patients', 'user_id')->ignore($patientId)],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'address' => ['required', 'string'],
            'gender' => ['required', 'in:male,female'],
        ];
    }
}
