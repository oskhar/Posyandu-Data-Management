<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeritaRequest extends CoreRequest
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
                    "id_admin" => "required|integer",
                    "judul" => "required|string|unique:berita",
                    "deskripsi" => "nullable|string",
                    "gambar" => "nullable",
                    "tanggal_pelaksanaan" => "required"
                ];
            case 'PUT': // Untuk membuat (store)
                return [
                    "id_berita" => "required|integer",
                    "judul" => "nullable|string",
                    "deskripsi" => "nullable|string",
                    "gambar" => "nullable",
                    "tanggal_pelaksanaan" => "required"
                ];
            case 'DELETE':
                return [
                    "id_berita" => "required|integer",
                ];
            case 'GET':
                return [
                    'id_berita' => 'nullable|integer',
                    'search' => 'nullable',
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
            'id_berita.integer' => 'id_berita harus berupa angka',
            'judul.unique' => 'Judul pernah dipakai sebelumnya, coba judul yang lain',
            'judul.required' => 'Judul tidak boleh kosong',
        ];
    }
}
