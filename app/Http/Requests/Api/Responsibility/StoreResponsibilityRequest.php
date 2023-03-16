<?php

namespace App\Http\Requests\Api\Responsibility;

use Illuminate\Foundation\Http\FormRequest;

class StoreResponsibilityRequest extends FormRequest
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
            'role_id' => ['required', 'integer', 'exists:roles,id']
        ];
    }
}
