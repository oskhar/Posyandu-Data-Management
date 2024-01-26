<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatDModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     * 
     * @var string
     */
    protected $table = 'format_d';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_orang_tua',
        'umur',
        'kelompok_dasawisma',
        'tanggal_pendaftaran',
        'umur_kehamilan',
        'hamil_ke',
        'lila',
        'pmt_pemulihan',
        'pil_tambah_darah',
        'vit_a',
        'penimbangan',
        'imunisasi',
        'keterangan',
    ];
}
