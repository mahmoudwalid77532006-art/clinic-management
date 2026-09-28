<?php

namespace App\Http\Requests;

// use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVisitRequest extends FormRequest
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
        $visitId = $this->route('visit')?->id;

        return [
            'appointment_id' => ['required', 'exists:appointments,id', Rule::unique('visits', 'appointment_id')->ignore($visitId)],
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'diagnosis' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}