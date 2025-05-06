<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tagihan;
use Carbon\Carbon;

class PenyewaDashboardController extends Controller
{
    public function index()
    {
        $penyewa = Auth::user()->load('kamar');

        // Ambil harga kamar saat ini
        $hargaKamar = $penyewa->kamar->harga ?? 0;

        // Ambil tagihan bulan ini
        $tagihan = Tagihan::where('penyewa_id', $penyewa->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->latest()
            ->first();

        // Logika tagihan dan pembayaran
        if (!$tagihan) {
            // Belum ada tagihan bulan ini
            $totalTagihan = $hargaKamar;
            $totalPembayaran = 0;
            $status_pembayaran = 'Belum Ada Tagihan';
        } elseif ($tagihan->status === 'Lunas') {
            // Tagihan sudah lunas
            $totalTagihan = 0;
            $totalPembayaran = $hargaKamar;
            $status_pembayaran = 'Lunas';
        } else {
            // Tagihan ada dan belum lunas
            $totalTagihan = $hargaKamar;
            $totalPembayaran = 0;
            $status_pembayaran = $tagihan->status;
        }

        // Hitung progres pembayaran
        $paymentProgress = 0;
        if ($totalTagihan > 0) {
            $paymentProgress = ($totalPembayaran / $totalTagihan) * 100;
        }

        return view('auth.penyewa.dashboard', compact(
            'tagihan',
            'status_pembayaran',
            'totalTagihan',
            'penyewa',
            'paymentProgress'
        ));
    }
}
