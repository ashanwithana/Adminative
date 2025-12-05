<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('edit users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'unique:users,email,' . $userId],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone,' . $userId],
            'password' => ['sometimes', 'string', 'min:8'],
            'role' => ['sometimes', 'string', 'exists:roles,name'],
            'is_active' => ['boolean'],
        ];
    }
}
