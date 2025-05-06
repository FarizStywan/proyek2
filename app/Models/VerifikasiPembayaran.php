<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiPembayaran extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_pembayaran';

    protected $fillable = ['tagihan_id', 'admin_id', 'status', 'catatan'];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
