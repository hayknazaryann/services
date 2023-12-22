<?php

namespace App\Http\Requests\Client\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'phone_code' => 'nullable',
            'phone_number' => 'nullable',
            'address' => 'nullable|string',
            'specialization' => 'nullable|string',
            'about' => 'nullable|string',
            'avatar' => 'nullable',
            'birthdate' => 'nullable',
        ];
    }
}
