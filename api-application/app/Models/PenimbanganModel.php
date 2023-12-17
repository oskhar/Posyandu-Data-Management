<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenimbanganModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     * 
     * @var string
     */
    protected $table = 'penimbangan';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_bayi',
        'keterangan',
        'tahun_penimbangan',
        'bulan_penimbangan',
        'berat_badan',
        'ntob',
        'asi_eksklusif',
    ];
}
