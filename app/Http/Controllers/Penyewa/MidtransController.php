<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tagihan;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function bayarSewa(Request $request)
    {
        // Ambil tagihan penyewa
        $tagihan = Tagihan::where('penyewa_id', auth()->id())->where('status', 'Belum Lunas')->first();

        if (!$tagihan) {
            return redirect()->back()->with('error', 'Tidak ada tagihan yang harus dibayar.');
        }

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data pembayaran
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . time(),
                'gross_amount' => $tagihan->jumlah,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->nama,
                'email' => auth()->user()->email,
            ],
        ];

        // Generate Snap Token
        $snapToken = Snap::getSnapToken($params);

        return view('auth.penyewa.bayar', compact('snapToken', 'tagihan'));
    }
    public function callback(Request $request)
{
    $orderId = $request->order_id;
    $status = $request->transaction_status;

    // Cari tagihan berdasarkan order_id
    $tagihan = Tagihan::where('midtrans_order_id', $orderId)->first();

    if (!$tagihan) {
        return response()->json(['message' => 'Tagihan tidak ditemukan'], 404);
    }

    // Update status berdasarkan response Midtrans
    if ($status == 'settlement') {
        $tagihan->status = 'Menunggu Verifikasi';
    } elseif ($status == 'pending') {
        $tagihan->status = 'Belum Lunas';
    } elseif ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
        $tagihan->status = 'Belum Lunas';
    }

    $tagihan->save();
    return response()->json(['message' => 'Status pembayaran diperbarui'], 200);
}

}