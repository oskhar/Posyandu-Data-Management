<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     *
     * @var string
     */
    protected $table = 'tag';

    /**
     * Mengatur status aktif timestamps.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "tag",
    ];
}
