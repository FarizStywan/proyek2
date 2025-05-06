<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = ['penyewa_id', 'kategori', 'deskripsi', 'foto', 'status', 'tanggapan'];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class);
    }
}
