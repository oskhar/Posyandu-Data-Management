<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class SuratRequest extends CoreRequest
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
                    "penanda_tangan" => "required|string",
                    "jabatan_penanda_tangan" => "required|string",
                    "tanggal_surat" => "required|date",
                    "nomor" => [
                        "required",
                        "string",
                        Rule::unique('surat', 'nomor') // Validasi unique
                    ],
                    "ditugaskan" => "required|array",
                    "kalimat_pembuka" => "string",
                    "isi_surat" => "string",
                    "kalimat_penutup" => "string"
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
