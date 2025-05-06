<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemasukanPengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pemasukan_pengeluaran';

    protected $fillable = ['jenis', 'deskripsi', 'jumlah', 'tanggal'];
}
