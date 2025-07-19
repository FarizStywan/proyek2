<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Log;
use Midtrans\Notification;
use App\Models\Tagihan;

class MidtransCallbackController extends Controller
{
    public function receive(Request $request)
    {
        try {
            // 📥 Log semua data callback dari Midtrans
            Log::info('📥 Callback Midtrans diterima', $request->all());

            // Ambil data penting dari request
            $orderId = $request->input('order_id');
            $statusCode = $request->input('status_code');
            $grossAmount = $request->input('gross_amount');
            $signatureKey = $request->input('signature_key');

            // ❌ Validasi data dasar
            if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey) {
                Log::warning('❌ Data callback tidak lengkap', $request->all());
                return response()->json(['message' => 'Data tidak lengkap'], 400);
            }

            // 🔐 Validasi signature key
            $serverKey = config('midtrans.server_key');
            $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($signatureKey !== $expectedSignature) {
                Log::error('❌ Signature tidak valid', [
                    'expected' => $expectedSignature,
                    'received' => $signatureKey
                ]);
                return response()->json(['message' => 'Signature tidak valid'], 403);
            }

            // 🛠️ Ambil detail transaksi dari Midtrans
            $notif = new Notification();
            $transactionStatus = $notif->transaction_status;
            $paymentType = $notif->payment_type;
            $transactionId = $notif->transaction_id;

            // 🔍 Cari pembayaran berdasarkan order_id
            $pembayaran = Pembayaran::where('order_id', $orderId)->first();

            if ($pembayaran) {
                // ✨ Update status pembayaran
                $pembayaran->update([
                    'status' => $transactionStatus,
                    'payment_type' => $paymentType,
                    'transaction_id' => $transactionId
                ]);

                Log::info('✅ Status pembayaran diperbarui', [
                    'order_id' => $orderId,
                    'status' => $transactionStatus,
                    'payment_type' => $paymentType
                ]);

                // 💰 Jika transaksi sukses
                if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
                    // 📦 Ambil tagihan via relasi
                    $tagihan = $pembayaran->tagihan;

                    if ($tagihan) {
                        // 💸 Update status tagihan ke Lunas
                        $tagihan->update([
                            'status' => 'Lunas',
                            'sisa_tagihan' => 0,
                        ]);

                        Log::info("💰 Tagihan #{$tagihan->id} berhasil diupdate menjadi Lunas");
                    } else {
                        Log::warning("⚠️ Tagihan tidak ditemukan untuk pembayaran", ['order_id' => $orderId]);
                    }
                }
            } else {
                Log::warning("⚠️ Pembayaran tidak ditemukan", ['order_id' => $orderId]);
            }

            return response()->json(['message' => 'Callback diproses'], 200);
        } catch (\Exception $e) {
            Log::error("❌ Error saat memproses callback", ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Server error'], 500);
        }
    }
}