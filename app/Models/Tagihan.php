<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'penyewa_id', 
        'jumlah', 
        'sisa_tagihan', 
        'status', 
        'metode_pembayaran',
        'midtrans_order_id', // Kolom ini digunakan untuk callback
        'jatuh_tempo'
    ];

    // Relasi ke Penyewa
    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class);
    }

    // Relasi ke Pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'tagihan_id');
    }

    // Relasi opsional ke Verifikasi
    public function verifikasi()
    {
        return $this->hasOne(VerifikasiPembayaran::class);
    }
}