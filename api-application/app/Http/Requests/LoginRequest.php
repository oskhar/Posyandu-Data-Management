<?php

namespace App\Http\Requests;

class LoginRequest extends CoreRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email_admin' => 'required|string',
            'password' => 'required|string'
        ];
    }
}
