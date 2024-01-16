<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayiModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     * 
     * @var string
     */
    protected $table = 'bayi';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_orang_tua',
        'nama',
        'nik',
        'anak_ke',
        'jenis_kelamin',
        'tanggal_lahir',
        'tanggal_meninggal',
        'berat_lahir',
        'panjang_lahir',
        'memiliki_kms',
        'memiliki_kia',
        'imd',
    ];
}
