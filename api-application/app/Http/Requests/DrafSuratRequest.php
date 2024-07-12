<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class DrafSuratRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $suratId = $this->route('id'); // Mendapatkan ID surat dari route parameter

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
                    "kalimat_pembuka" => "nullable|string",
                    "isi_surat" => "nullable|string",
                    "kalimat_penutup" => "nullable|string"
                ];
            case 'PUT':
                return [
                    "penanda_tangan" => "required|string",
                    "jabatan_penanda_tangan" => "required|string",
                    "tanggal_surat" => "required|date",
                    "nomor" => [
                        "required",
                        "string",
                        Rule::unique('surat', 'nomor')->ignore($suratId) // Validasi unique dengan pengecualian
                    ],
                    "ditugaskan" => "required|array",
                    "kalimat_pembuka" => "nullable|string",
                    "isi_surat" => "nullable|string",
                    "kalimat_penutup" => "nullable|string"
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
