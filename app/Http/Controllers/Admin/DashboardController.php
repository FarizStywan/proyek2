<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penyewa;
use App\Models\Tagihan;
use App\Models\Kamar;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Penyewa
        $totalPenyewa = Penyewa::count();
        $penyewaAktif = Penyewa::where('status', 'Aktif')->count();
        $penyewaNonAktif = Penyewa::where('status', 'Non-Aktif')->count();

        // Data Kamar
        $totalKamar = Kamar::count();
        $kamarTerisi = Kamar::where('status', 'Terisi')->count();
        $kamarTersedia = Kamar::where('status', 'Kosong')->count();

        // Pembayaran
        $totalPendapatan = Tagihan::where('status', 'Lunas')->sum('jumlah');
        $pembayaranTertunda = Tagihan::where('status', 'Menunggu Verifikasi')->get();

        return view('auth.admin.dashboard', compact(
            'totalPenyewa', 'penyewaAktif', 'penyewaNonAktif',
            'totalKamar', 'kamarTerisi', 'kamarTersedia',
            'totalPendapatan', 'pembayaranTertunda'
        ));
    }
}
