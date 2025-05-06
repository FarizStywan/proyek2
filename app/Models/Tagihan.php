<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'penyewa_id', 'jumlah', 'sisa_tagihan', 'status', 'metode_pembayaran', 'midtrans_order_id', 'jatuh_tempo'
    ];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class);
    }

    public function verifikasi()
    {
        return $this->hasOne(VerifikasiPembayaran::class);
    }
}
