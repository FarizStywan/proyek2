<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;

class VerifikasiPembayaranController extends Controller
{
    public function index()
    {
        $pembayaranTertunda = Tagihan::where('status', 'Menunggu Verifikasi')->get();
        return view('auth.admin.verifikasi.index', compact('pembayaranTertunda'));
    }

    public function verifikasi(Request $request, $id)
    {
        $tagihan = Tagihan::findOrFail($id);
        
        // Update status pembayaran menjadi "Lunas"
        $tagihan->update(['status' => 'Lunas']);
    
        // Tambahkan pemasukan otomatis
        PemasukanPengeluaran::create([
            'jenis' => 'Pemasukan',
            'deskripsi' => 'Pembayaran sewa dari ' . $tagihan->penyewa->nama,
            'jumlah' => $tagihan->jumlah,
            'tanggal' => now(),
        ]);
    
        return redirect()->route('admin.verifikasi.index')->with('success', 'Pembayaran berhasil diverifikasi & pemasukan otomatis ditambahkan!');
    }
    
}
