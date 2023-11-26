<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosyanduModel extends Model
{
    use HasFactory;
    use HasFactory;
    /**
     * Mengatur nama tabel database yang dituju.
     * 
     * @var string
     */
    protected $table = 'edukasi';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_posyandu',
        'kecamatan',
        'kelurahan',
        'penyampaian_ketua',
        'gambar_gedung',
        'visi',
        'misi',
    ];
}
