<?php

namespace App\Http\Requests;

class AdminRequest extends CoreRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->getMethod()) {
            case 'POST':
                return [
                    'nama_lengkap' => 'required',
                    'email_admin' => 'required',
                    'id_jabatan' => 'required',
                ];
            case 'PUT':
                return [
                    'id_admin' => 'required',
                    'nama_lengkap' => 'nullable',
                    'email_admin' => 'nullable',
                    'password' => 'nullable',
                    'id_jabatan' => 'nullable',
                    'foto_profile' => 'nullable',
                    'jenis_kelamin' => 'nullable',
                    'alamat' => 'nullable',
                    'tanggal_lahir' => 'nullable',
                    'no_telp' => 'nullable',
                    'email_verified_at' => 'nullable',
                ];
            case 'DELETE':
                return [
                    "id_admin" => "required|integer",
                ];
            case 'GET':
                return [
                    'id_admin' => 'nullable|integer',
                    'search' => 'nullable'
                ];
            default:
                return [];
        }
    }
    public function messages(): array
    {
        return [
            'id_programmers.integer' => 'id_programmer harus berupa angka',
            'id_projects.integer' => 'id_projects harus berupa angka',
        ];
    }
}
