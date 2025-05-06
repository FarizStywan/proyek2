<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            // ID dasar
            $table->id();
            $table->string('kode_transaksi')->unique()->comment('Kode unik untuk referensi admin');
            
            // Relasi dengan tagihan
            $table->foreignId('tagihan_id')->constrained('tagihan')->cascadeOnDelete();
            
            // Data Midtrans
            $table->string('order_id')->unique()->comment('Order ID dari Midtrans');
            $table->text('snap_token')->nullable()->comment('Token untuk Snap.js');
            $table->string('payment_type')->nullable()->comment('Jenis pembayaran: bank_transfer, ewallet, dll');
            $table->string('bank')->nullable()->comment('Nama bank jika transfer');
            $table->string('va_number')->nullable()->comment('Nomor VA jika bank transfer');
            
            // Status dan nominal
            $table->decimal('jumlah', 12, 2);
            $table->string('status')->default('pending')->comment('pending, success, failed, expired, challenge');
            $table->string('status_message')->nullable()->comment('Deskripsi status dari Midtrans');
            
            // Waktu pembayaran
            $table->timestamp('waktu_pembayaran')->nullable()->comment('Waktu pembayaran sukses');
            $table->timestamp('waktu_expire')->nullable()->comment('Batas waktu pembayaran');
            
            // Data response
            $table->json('request_payload')->nullable()->comment('Data yang dikirim ke Midtrans');
            $table->json('response_callback')->nullable()->comment('Response dari Midtrans callback');
            
            // Audit
            $table->foreignId('user_id')->nullable()->constrained()->comment('Penyewa yang melakukan pembayaran');
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Index untuk pencarian
            $table->index('order_id');
            $table->index('status');
            $table->index('tagihan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};