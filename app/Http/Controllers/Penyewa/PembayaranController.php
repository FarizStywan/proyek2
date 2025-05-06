<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use Midtrans\Snap;
use Midtrans\Config;

class PembayaranController extends Controller
{
    // Menampilkan halaman pembayaran
    public function showForm()
    {
        // Ambil tagihan yang belum lunas
        $tagihan = Tagihan::where('penyewa_id', auth()->id())
                          ->where('status', 'Belum Lunas')
                          ->first();

        // Jika tidak ada tagihan, kembalikan ke halaman sebelumnya dengan pesan
        if (!$tagihan) {
            return redirect()->back()->with('error', 'Tidak ada tagihan yang harus dibayar.');
        }

        // Ambil kamar berdasarkan nomor kamar penyewa untuk harga kamar
        $kamar = $tagihan->penyewa->kamar; // Relasi dengan kamar untuk ambil harga

        // Harga kamar
        $harga_kamar = $kamar ? $kamar->harga : 0;

        return view('auth.penyewa.bayar', [
            'jumlah' => $tagihan->jumlah,
            'tagihan_id' => $tagihan->id,
            'harga_kamar' => $harga_kamar
        ]);
    }

    // Memproses pembayaran dengan Midtrans
    public function processPayment(Request $request)
    {
        // Validasi request
        $request->validate([
            'tagihan_id' => 'required|exists:tagihan,id'
        ]);

        // Ambil tagihan berdasarkan ID & pastikan milik penyewa yang login
        $tagihan = Tagihan::where('id', $request->tagihan_id)
                          ->where('penyewa_id', auth()->id())
                          ->where('status', 'Belum Lunas')
                          ->firstOrFail();

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Membuat data transaksi Midtrans
        $transaction = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . uniqid(),
                'gross_amount' => (int) $tagihan->jumlah, // Pastikan format angka sesuai
            ],
            'customer_details' => [
                'email' => auth()->user()->email,
                'first_name' => auth()->user()->nama,
            ],
        ];

        try {
            // Generate Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($transaction);
            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal membuat pembayaran: ' . $e->getMessage()], 500);
        }
    }
}