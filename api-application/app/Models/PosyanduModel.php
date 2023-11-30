<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosyanduModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     * 
     * @var string
     */
    protected $table = 'posyandu';

    /**
     * Menentukan primary key (default = id)
     * 
     */
    protected $primaryKey = 'nama_posyandu';
    protected $keyType = 'string';


    /**
     * Mengindikasi apakah model memiliki timestamp.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_posyandu',
        'kota',
        'kecamatan',
        'kelurahan',
        'rt_rw',
        'penyampaian_ketua',
        'gambar_gedung',
        'visi',
        'misi',
    ];
}
