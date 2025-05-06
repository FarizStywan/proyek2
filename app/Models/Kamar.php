<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';

    protected $fillable = [
        'nomor_kamar',
        'fasilitas',
        'harga',
        'status',
    ];

    // Di model Kamar.php
public function penyewa()
{
    return $this->hasMany(Penyewa::class, 'nomor_kamar', 'nomor');
}

}
