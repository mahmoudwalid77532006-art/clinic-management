<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        $doctorId = $this->route('doctor')?->id;

        return [
            'user_id' => ['required', 'exists:users,id', Rule::unique('doctors', 'user_id')->ignore($doctorId)],
            'department_id' => ['nullable', 'exists:departments,id'],
            'specialty' => ['required', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'bio' => ['nullable', 'string'],
            'slot_duration_minutes' => ['integer', 'min:1'],
        ];
    }
}
