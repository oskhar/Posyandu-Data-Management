<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EdukasiRequest extends CoreRequest
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
                    "judul" => "required|string",
                    "materi" => "nullable",
                    "gambar" => "nullable",
                ];
            case 'PUT': // Untuk membuat (store)
                return [
                    "id_edukasi" => "required|integer",
                    "judul" => "required|string",
                    "materi" => "nullable",
                    "gambar" => "nullable",
                ];
            case 'DELETE':
                return [
                    "id_edukasi" => "required|integer",
                ];
            case 'GET':
                return [
                    'id_edukasi' => 'nullable|integer',
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
