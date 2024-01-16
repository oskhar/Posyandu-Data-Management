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
        'tahapan_ks',
        'kelompok_dasawisma',
        'ukuran_lila',
        'jumlah_anak_hidup',
        'jumlah_anak_meinggal',
        'imunisasi',
        'jenis_kontrasepsi',
        'tanggal_penggantian',
        'penggantian_jenis_kontrasepsi',
        'keterangan',
    ];
}
