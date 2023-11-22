<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Mengatur nama tabel database yang dituju.
     * 
     * @var string
     */
    protected $table = 'admin';

    /**
     * Atribut atau kolom yang boleh diubah.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_lengkap',
        'email_admin',
        'id_jabatan',
        'foto_profile',
        'jenis_kelamin',
        'alamat',
        'tanggal_lahir',
        'no_telp',
        'email_verified_at',
        'password',
    ];
}