<?php

namespace App\Http\Requests;

class ResetPasswordRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'token' => 'required',
            'password_a' => 'required',
            'password_b' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'password_a.required' => 'Dua password harus diisi',
            'password_b.required' => 'Dua password harus diisi',
        ];
    }
}
