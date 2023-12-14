<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTuaModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     * 
     * @var string
     */
    protected $table = 'orang_tua';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_ayah',
        'nama_ibu',
        'rt_rw',
        'tanggal_lahir_ibu',
        'tanggal_meninggal_ibu',
        'wus_pus',
        'tahapan_ks',
        'memiliki_kms',
        'memiliki_kia',
    ];

}
