<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TantanganModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     *
     * @var string
     */
    protected $table = 'tantangan';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "judul",
        "gambar",
        "deskripsi",
        "tanggal_mulai",
        "tanggal_selesai",
    ];
}
