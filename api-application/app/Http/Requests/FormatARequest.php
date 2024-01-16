<?php

namespace App\Http\Requests;

class FormatARequest extends CoreRequest
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
                    'id_orang_tua' => 'nullable|integer',
                    'nik_ayah' => 'nullable',
                    'nik_ibu' => 'nullable',
                    'no_telp' => 'nullable',
                    'nik_bayi' => 'nullable',
                    'anak_ke' => 'nullable',
                    'tinggi_lahir' => 'nullable',
                    'imd' => 'nullable',
                    'tempat_tinggal' => 'nullable',
                    'id_bayi' => 'nullable|integer',
                    'nama_ayah' => 'nullable|string',
                    'nama_ibu' => 'nullable|string',
                    'nama_bayi' => 'nullable|string',
                    'jenis_kelamin' => 'nullable|string|in:L,P',
                    'tanggal_lahir' => 'nullable',
                    'tanggal_meninggal_bayi' => 'nullable',
                    'tanggal_meninggal_ibu' => 'nullable',
                    'keterangan' => 'nullable',
                    'berat_lahir' => 'nullable',
                    'rt_rw' => 'nullable',
                    'memiliki_kms' => 'nullable|boolean',
                    'memiliki_kia' => 'nullable|boolean',
                ];
            case 'PUT':
                return [
                    "id_format_a" => "required|integer",
                    'nik_ayah' => 'nullable',
                    'nik_ibu' => 'nullable',
                    'no_telp' => 'nullable',
                    'nik_bayi' => 'nullable',
                    'anak_ke' => 'nullable',
                    'tinggi_lahir' => 'nullable',
                    'imd' => 'nullable',
                    'tempat_tinggal' => 'nullable',
                    'id_bayi' => 'nullable|integer',
                    'nama_ayah' => 'nullable|string',
                    'nama_ibu' => 'nullable|string',
                    'nama_bayi' => 'nullable|string',
                    'jenis_kelamin' => 'nullable|string|in:L,P',
                    'tanggal_lahir' => 'nullable',
                    'tanggal_meninggal_bayi' => 'nullable',
                    'tanggal_meninggal_ibu' => 'nullable',
                    'keterangan' => 'nullable',
                    'berat_lahir' => 'nullable',
                    'rt_rw' => 'nullable',
                    'memiliki_kms' => 'nullable|boolean',
                    'memiliki_kia' => 'nullable|boolean',
                ];
            case 'DELETE':
                return [
                    "id_format_a" => "required|integer",
                ];
            case 'GET':
                return [
                    'id_format_a' => 'nullable|integer',
                    'tahun' => 'nullable',
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
            'id_format_a.integer' => 'id_format_a harus berupa angka',
            'nama_bayi.required' => 'nama_bayi tidak boleh kosong',
            'jenis_kelamin.in' => 'jenis_kelamin hanya boleh diisi oleh L atau P',
        ];
    }
}
