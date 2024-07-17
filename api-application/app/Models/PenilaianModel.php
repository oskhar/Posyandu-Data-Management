<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     *
     * @var string
     */
    protected $table = 'penilaian';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "submission_id",
        "admin_id",
        "feedback",
        "peringkat",
    ];
}
