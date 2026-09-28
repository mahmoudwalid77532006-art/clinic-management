<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartmentRequest extends FormRequest
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
        $departmentId = $this->route('department')?->id;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('departments', 'name')->ignore($departmentId)],
            'icon' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
