<?php

namespace App\Http\Requests\Client\User;

use App\Rules\PhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'first_name' => 'required|alpha|min:2|max:255',
            'last_name' => 'required|alpha|min:2|max:255',
            'phone' => ['nullable', 'unique:user_profiles,phone,' . $this->request->get('id'), new PhoneNumberRule()],
            'address' => 'nullable|string|min:2|max:255',
            'specialization' => 'nullable|string|min:2|max:255',
            'about' => 'nullable|string',
            'avatar' => 'nullable',
            'birthdate' => 'nullable|date',
        ];
    }
}
