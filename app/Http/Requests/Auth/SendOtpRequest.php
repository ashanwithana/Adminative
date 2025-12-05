<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendOtpRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identifier' => ['required', 'string'],
            'type' => ['sometimes', 'in:login,registration,password_reset'],
            'channel' => ['sometimes', 'in:email,sms'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Determine if identifier is email or phone
        $identifier = $this->input('identifier');
        $channel = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'sms';

        $this->merge([
            'channel' => $this->input('channel', $channel),
            'type' => $this->input('type', 'login'),
        ]);
    }
}
