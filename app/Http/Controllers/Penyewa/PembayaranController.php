<?php

namespace App\Http\Controllers\Penyewa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    // Menampilkan form pembayaran
    public function showForm()
    {
        $penyewaId = Auth::id();

        $tagihan = Tagihan::where('penyewa_id', $penyewaId)
                          ->where('status', 'Belum Lunas')
                          ->first();

        if (!$tagihan) {
            return redirect()->back()->with('error', 'Tidak ada tagihan yang harus dibayar.');
        }

        $harga_kamar = $tagihan->jumlah ?? 0;

        return view('auth.penyewa.bayar', [
            'jumlah' => $tagihan->jumlah,
            'tagihan_id' => $tagihan->id,
            'harga_kamar' => $harga_kamar
        ]);
    }

    // Proses Midtrans dan kirim ke view Snap
    public function processPayment(Request $request)
    {
        $request->validate([
            'tagihan_id' => 'required|exists:tagihan,id'
        ]);

        try {
            $tagihan = Tagihan::where('id', $request->tagihan_id)
                              ->where('penyewa_id', Auth::id())
                              ->where('status', 'Belum Lunas')
                              ->firstOrFail();

            // Pastikan jumlah valid
            if ($tagihan->jumlah <= 0) {
                return response()->json(['error' => 'Jumlah tagihan tidak valid'], 400);
            }

            $orderId = 'ORDER-' . now()->format('YmdHis') . '-' . Str::random(5);

            // Simpan order_id ke pembayaran
            $pembayaran = Pembayaran::create([
                'tagihan_id' => $tagihan->id,
                'order_id' => $orderId,
                'jumlah' => $tagihan->jumlah,
                'status' => 'pending',
            ]);

            // Konfigurasi Midtrans
            \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
            \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            // Data transaksi Midtrans
            $transaction = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int)$tagihan->jumlah,
                ],
                'customer_details' => [
                    'email' => Auth::user()->email,
                    'first_name' => Auth::user()->nama,
                ]
            ];

            // Ambil Snap Token
            $snapToken = Snap::getSnapToken($transaction);

            return response()->json([
                'snap_token' => $snapToken
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal proses pembayaran: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    // Terima notifikasi dari Midtrans (via webhook)
    public function handleCallback(Request $request)
    {
        try {
            $notif = new Notification();
            $orderId = $notif->order_id;
            $transactionStatus = $notif->transaction_status;
            $paymentType = $notif->payment_type;
            $transactionId = $notif->transaction_id;

            // Debug data notifikasi
            \Log::info('Midtrans Notification Data', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'transaction_id' => $transactionId,
            ]);

            // Cari pembayaran berdasarkan order_id
            $pembayaran = Pembayaran::where('order_id', $orderId)->first();

            if ($pembayaran) {
                \Log::info('Pembayaran ditemukan', ['order_id' => $orderId]);

                // Update data pembayaran
                $pembayaran->update([
                    'status' => $transactionStatus,
                    'transaction_id' => $transactionId,
                    'payment_type' => $paymentType,
                ]);

                Log::info("✅ Pembayaran #{$orderId} diperbarui", ['status' => $transactionStatus]);

                // Jika transaksi berhasil
                if (in_array($transactionStatus, ['settlement', 'capture'])) {
                    $tagihan = $pembayaran->tagihan;

                    if ($tagihan) {
                        $tagihan->update([
                            'status' => 'Lunas',
                            'sisa_tagihan' => 0,
                        ]);

                        Log::info("💰 Tagihan #{$pembayaran->tagihan->id} diupdate menjadi Lunas");
                    } else {
                        Log::warning("⚠️ Tagihan tidak ditemukan untuk pembayaran", ['order_id' => $orderId]);
                    }
                }
            } else {
                Log::warning("⚠️ Pembayaran tidak ditemukan", ['order_id' => $orderId]);
            }

            return response()->json(['message' => 'Callback diproses'], 200);
        } catch (\Exception $e) {
            Log::error("❌ Gagal memproses callback: " . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    // Histori pembayaran
    public function histori()
    {
        $data = Pembayaran::whereHas('tagihan', function ($query) {
            $query->where('penyewa_id', auth()->id());
        })->latest()->get();

        return view('auth.penyewa.histori', compact('data'));
    }

    // Status pembayaran terbaru
    public function status()
    {
        $tagihan = Tagihan::where('penyewa_id', auth()->id())->orderByDesc('created_at')->first();
        return view('auth.penyewa.status_pembayaran', compact('tagihan'));
    }
}