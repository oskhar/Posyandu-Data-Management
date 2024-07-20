<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     *
     * @var string
     */
    protected $table = 'produk';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "admin_id",
        "nomor_telepon",
        "nama",
        "deskripsi",
        "overview",
        "harga",
        "gambar",
        "sedang_dijual",
        "pin",
    ];

    public function tags()
    {
        return $this->belongsToMany(TagModel::class, 'produk_tag', 'produk_id', 'tag_id');
    }
}
