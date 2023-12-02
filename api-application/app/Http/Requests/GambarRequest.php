<?php

namespace App\Http\Requests;

class GambarRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->getMethod()) {
            case 'POST': // Untuk membuat (store)
                return [
                    'id_admin' => 'required|integer',
                    'gambar' => 'required',
                ];
            case 'DELETE':
                return [
                    "id_gambar" => "required|integer",
                ];
            case 'GET':
                return [
                    'id_gambar' => 'nullable|integer',
                    'start' => 'nullable|integer',
                    'length' => 'nullable|integer'
                ];
            default:
                return [];
        }
    }
    public function messages(): array
    {
        return [
            'id_admin.integer' => 'id_admin harus berupa angka',
            'id_gambar.integer' => 'id_gambar harus berupa angka',
            'id_admin.required' => 'id_admin harus diisi',
            'id_gambar.required' => 'id_gambar harus diisi',
        ];
    }
}
