<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    
    protected $fillable = [
        'tagihan_id',
        'order_id',
        'transaction_id',
        'payment_type',
        'status',
        'jumlah',
    ];

    // Relasi ke Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    }
}