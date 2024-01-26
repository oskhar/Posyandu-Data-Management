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
                    'id_orang_tua' => 'nullable',
                    'nama_ayah' => 'nullable',
                    'nik_ayah' => 'nullable',
                    'nama_ibu' => 'nullable',
                    'nik_ibu' => 'nullable',
                    'tanggal_meninggal_ibu' => 'nullable',
                    'no_telp' => 'nullable',
                    'rt_rw' => 'nullable',
                    'tempat_tinggal' => 'nullable',
                    'umur' => 'nullable',
                    'tahapan_ks' => 'nullable',
                    'kelompok_dasawisma' => 'nullable',
                    'lila' => 'nullable',
                    'jumlah_anak_hidup' => 'nullable',
                    'jumlah_anak_meninggal' => 'nullable',
                    'imunisasi' => 'nullable',
                    'jenis_kontrasepsi' => 'nullable',
                    'tanggal_penggantian' => 'nullable',
                    'penggantian_jenis_kontrasepsi' => 'nullable',
                    'keterangan' => 'nullable',
                ];
            case 'PUT':
                return [
                    "id_format_c" => "required|integer",
                    'ganti_id_ortu' => 'nullable',
                    'nama_ayah' => 'nullable',
                    'nik_ayah' => 'nullable',
                    'nama_ibu' => 'nullable',
                    'nik_ibu' => 'nullable',
                    'tanggal_meninggal_ibu' => 'nullable',
                    'no_telp' => 'nullable',
                    'rt_rw' => 'nullable',
                    'tempat_tinggal' => 'nullable',
                    'umur' => 'nullable',
                    'tahapan_ks' => 'nullable',
                    'kelompok_dasawisma' => 'nullable',
                    'lila' => 'nullable',
                    'jumlah_anak_hidup' => 'nullable',
                    'jumlah_anak_meninggal' => 'nullable',
                    'imunisasi' => 'nullable',
                    'jenis_kontrasepsi' => 'nullable',
                    'tanggal_penggantian' => 'nullable',
                    'penggantian_jenis_kontrasepsi' => 'nullable',
                    'keterangan' => 'nullable',
                ];
            case 'GET':
                return [
                    'id_format_c' => 'nullable|integer',
                    'tahun' => 'nullable',
                    'bulan' => 'nullable',
                    'tab' => 'nullable',
                    'search' => 'nullable',
                    'start' => 'nullable|integer',
                    'length' => 'nullable|integer',
                ];
            case 'DELETE':
                return [
                    "id_format_c" => "required|integer",
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
