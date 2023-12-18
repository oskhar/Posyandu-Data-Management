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
            'id_admin' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'new_password.required' => 'Dua password harus diisi',
            'confirm_password.required' => 'Dua password harus diisi',
        ];
    }
}
