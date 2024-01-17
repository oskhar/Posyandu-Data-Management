<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatCModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     * 
     * @var string
     */
    protected $table = 'format_c';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_orang_tua',
        'umur',
        'tahapan_ks',
        'kelompok_dasawisma',
        'lila',
        'jumlah_anak_hidup',
        'jumlah_anak_meninggal',
        'imunisasi',
        'jenis_kontrasepsi',
        'tanggal_penggantian',
        'penggantian_jenis_kontrasepsi',
    ];
}
