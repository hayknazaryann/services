<?php

namespace App\Http\Requests\Client\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
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
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|max:60|confirmed',
            'password_confirmation'  => 'required|min:8|max:60',
        ];
    }
}
