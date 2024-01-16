<?php

namespace App\Http\Requests;

class FormatCRequest extends CoreRequest
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
                    'id_bayi' => 'required',
                    'penimbangan' => 'nullable',
                    // 'judul' => 'required',
                    'berat_badan' => 'nullable',
                    'ntob' => 'nullable',
                    'asi_eksklusif' => 'nullable:in:Ya,Tidak,Alpa',
                ];
            case 'GET':
                return [
                    'id_bayi' => 'nullable|integer',
                    'tahun' => 'nullable',
                    'bulan' => 'nullable',
                    'tab' => 'nullable',
                    'search' => 'nullable',
                    'start' => 'nullable|integer',
                    'length' => 'nullable|integer',
                ];
            default:
                return [];
        }
    }
    public function messages(): array
    {
        return [
            'id_admin.integer' => 'id_admin harus berupa angka',
            'id_format_a.integer' => 'id_format_a harus berupa angka',
            'nama_bayi.required' => 'nama_bayi tidak boleh kosong',
            'jenis_kelamin.in' => 'jenis_kelamin hanya boleh diisi oleh L atau P',
        ];
    }
}
