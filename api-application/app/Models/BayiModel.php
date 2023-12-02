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
        'jenis_kelamin',
        'berat_lahir',
        'tanggal_lahir',
        'tanggal_meninggal',
    ];
}
