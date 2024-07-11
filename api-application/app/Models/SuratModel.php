<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class SuratModel extends Model
{
    use HasFactory;

    /**
     * Mengatur nama tabel database yang dituju.
     *
     * @var string
     */
    protected $table = 'surat';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "admin_id",
        "penanda_tangan",
        "tanggal_surat",
        "nomor",
        "kalimat_pembuka",
        "isi_surat",
        "kalimat_penutup",
    ];

    public function penugasan()
    {
        return $this->belongsToMany(PenugasanModel::class);
    }
}
