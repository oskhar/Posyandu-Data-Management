<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukTagModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     *
     * @var string
     */
    protected $table = 'produk_tag';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "produk_id",
        "tag_id",
    ];
}
