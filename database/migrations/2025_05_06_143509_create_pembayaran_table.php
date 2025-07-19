<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->constrained('tagihan')->onDelete('cascade');
            $table->string('order_id')->unique(); // Agar tidak duplikat
            $table->string('transaction_id')->nullable(); // ID dari Midtrans
            $table->string('payment_type')->nullable();   // e.g. gopay, bank_transfer
            $table->string('status')->default('pending'); // pending, settlement, expire, cancel
            $table->integer('jumlah');                    // Total pembayaran
            $table->timestamps();
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
}
