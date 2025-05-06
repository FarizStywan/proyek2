<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Penyewa extends Authenticatable
{
    use HasFactory;

    protected $table = 'penyewa';

    protected $fillable = [
        'nama', 'email', 'no_hp', 'password', 'nomor_kamar', 'tanggal_mulai', 'foto_profil', 'status'
    ];

    protected $hidden = ['password'];

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }
    public function kamar()
    {
        return $this->belongsTo(\App\Models\Kamar::class, 'nomor_kamar', 'nomor_kamar');
    }

}
