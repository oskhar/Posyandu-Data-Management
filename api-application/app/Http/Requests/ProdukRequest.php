<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ProdukRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->getMethod()) {
            case 'GET':
                return [
                    "search" => "nullable|string",
                    "length" => "required|integer",
                    "tag" => "array",
                    "sort" => "in:terbaru,terlama,a-z,z-a,termahal,termurah"
                ];
            case 'POST':
                return [
                    "nomor_telepon" => "string",
                    "nama" => [
                        "required",
                        "string",
                        Rule::unique('produk', 'nama')
                    ],
                    "deskripsi" => "string|required",
                    "overview" => "string|required",
                    "tags" => "array|nullable",
                    "harga" => "integer|required",
                    "gambar" => "string|required",
                    "sedang_dijual" => "boolean|nullable",
                    "pin" => "boolean|nullable",
                ];
            case 'PUT':
                return [
                    "nomor_telepon" => "string",
                    "nama" => [
                        "required",
                        "string",
                        Rule::unique('produk', 'nama')->ignore($this->route('id'))
                    ],
                    "deskripsi" => "string|required",
                    "overview" => "string|required",
                    "tags" => "array|nullable",
                    "harga" => "integer|required",
                    "gambar" => "string|required",
                    "sedang_dijual" => "boolean|nullable",
                    "pin" => "boolean|nullable",
                ];
            default:
                return [];
        }
    }
    public function messages(): array
    {
        return [
            'nomor.unique' => 'Nomor ini sudah ditambahkan sebelumnya',
        ];
    }
}
