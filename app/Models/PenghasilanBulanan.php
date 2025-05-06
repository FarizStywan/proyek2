<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenghasilanBulanan extends Model
{
    use HasFactory;

    protected $table = 'penghasilan_bulanan';

    protected $fillable = ['bulan', 'tahun', 'total_pemasukan', 'total_pengeluaran'];
}
