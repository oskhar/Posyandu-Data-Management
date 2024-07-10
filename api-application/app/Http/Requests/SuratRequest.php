<?php

namespace App\Http\Requests;

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
            case 'POST':
                return [
                    "penanda_tangan" => "required|string",
                    "tanggal_surat" => "required|date",
                    "nomor_telepon" => "required|string",
                    "ditugaskan" => "required|array",
                    "kalimat_pembuka" => "string",
                    "isi_surat" => "string",
                    "kalimat_penutup" => "string"
                ];
            default:
                return [];
        }
    }
}
