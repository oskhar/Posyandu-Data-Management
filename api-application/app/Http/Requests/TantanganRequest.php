<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class TantanganRequest extends CoreRequest
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
                ];
            case 'POST':
                return [
                    "judul" => "required|string",
                    "gambar" => "string",
                    "deskripsi" => "required|string",
                    "tanggal_mulai" => "required|date",
                    "tanggal_selesai" => "required|date",
                ];
            case 'PUT':
                return [
                    "judul" => "required|string",
                    "gambar" => "string",
                    "deskripsi" => "required|string",
                    "tanggal_mulai" => "required|date",
                    "tanggal_selesai" => "required|date",
                ];
            default:
                return [];
        }
    }
}
