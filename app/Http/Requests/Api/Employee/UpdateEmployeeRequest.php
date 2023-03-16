<?php

namespace App\Http\Requests\Api\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('employees')->ignore($this->employee)],
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'age' => ['nullable', 'integer'],
            'photo' => ['nullable', 'file', 'image'],
            'phone' => ['nullable', 'string', 'max:16'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'team_id' => ['required', 'integer', 'exists:teams,id'],
        ];
    }
}
