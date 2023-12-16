<?php

namespace App\Http\Requests;

class ForgetPasswordRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email_admin' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'email_admin.required' => 'Email harus diisi',
        ];
    }
}
